<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AutomationLog;
use App\Models\Review;
use App\Models\Store;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewIntakeController extends Controller
{
    public function __construct(
        protected ReviewAnalysisService $analysisService
    ) {}

    /**
     * Review Intake Endpoint (POST /api/reviews)
     */
    public function intake(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'store_id' => ['nullable', 'exists:stores,id'],
            'platform_store_id' => ['nullable', 'string', 'exists:stores,platform_store_id'],
            'reviewer_name' => ['required', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'max:5000'],
            'source' => ['nullable', 'string', 'max:50'],
            'external_review_id' => ['nullable', 'string', 'max:255'],
        ]);

        // Resolve store
        $store = null;
        if (! empty($validated['store_id'])) {
            $store = Store::find($validated['store_id']);
        } elseif (! empty($validated['platform_store_id'])) {
            $store = Store::where('platform_store_id', $validated['platform_store_id'])->first();
        } else {
            $store = Store::first();
        }

        if (! $store) {
            return response()->json(['error' => 'No active store found to associate review.'], 404);
        }

        // Prevent duplicate imported reviews
        if (! empty($validated['external_review_id'])) {
            $existing = Review::where('store_id', $store->id)
                ->where('external_review_id', $validated['external_review_id'])
                ->first();

            if ($existing) {
                return response()->json([
                    'message' => 'Review already exists.',
                    'review_id' => $existing->id,
                    'status' => $existing->processing_status,
                ], 200);
            }
        }

        $review = Review::create([
            'store_id' => $store->id,
            'reviewer_name' => $validated['reviewer_name'],
            'product_name' => $validated['product_name'] ?? 'General Order',
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'review_status' => 'unread',
            'processing_status' => 'queued',
            'source' => $validated['source'] ?? 'api',
            'external_review_id' => $validated['external_review_id'] ?? null,
        ]);

        // Trigger processing pipeline
        try {
            $this->analysisService->processAndSave($review);
        } catch (\Throwable $e) {
            // Error already logged by analysisService
        }

        $review->refresh();

        return response()->json([
            'message' => 'Review accepted and queued for analysis.',
            'review_id' => $review->id,
            'processing_status' => $review->processing_status,
            'review_status' => $review->review_status,
            'sentiment' => $review->sentiment,
            'suggested_reply' => $review->suggested_reply,
        ], 201);
    }

    /**
     * Secure Results Callback (POST /api/internal/reviews/{review}/analysis)
     * Used by external automation workers (n8n, AWS Lambda, microservices)
     */
    public function analysisCallback(Request $request, int $reviewId): JsonResponse
    {
        $review = Review::with('store')->find($reviewId);

        if (! $review) {
            return response()->json(['error' => 'Review not found.'], 404);
        }

        // Authenticate request using header secret
        $secretHeader = $request->header('X-ReviewPulse-Secret') ?? $request->bearerToken();
        $expectedSecret = $review->store->webhook_secret ?? env('WORKFLOW_SECRET', 'rp_sec_live_9876543210abcdef');

        if (! $secretHeader || ! hash_equals((string) $expectedSecret, (string) $secretHeader)) {
            return response()->json(['error' => 'Unauthorized: Invalid or missing webhook secret header.'], 401);
        }

        $validated = $request->validate([
            'sentiment' => ['required', 'in:positive,neutral,negative'],
            'confidence' => ['required', 'numeric', 'between:0,1'],
            'summary' => ['required', 'string', 'max:1000'],
            'suggested_reply' => ['required', 'string', 'max:5000'],
            'requires_human_review' => ['nullable', 'boolean'],
        ]);

        $requiresHumanReview = $validated['requires_human_review'] ?? ($validated['sentiment'] === 'negative');

        $review->update([
            'sentiment' => $validated['sentiment'],
            'confidence_score' => $validated['confidence'],
            'ai_summary' => $validated['summary'],
            'ai_generated_reply' => $validated['suggested_reply'],
            'suggested_reply' => $review->suggested_reply ?: $validated['suggested_reply'],
            'requires_human_review' => $requiresHumanReview,
            'processing_status' => 'completed',
            'review_status' => $requiresHumanReview ? 'needs_review' : 'pending',
        ]);

        AutomationLog::create([
            'review_id' => $review->id,
            'workflow_type' => 'n8n_callback',
            'status' => 'completed',
            'payload_data' => json_encode($validated),
            'error_message' => null,
            'retry_count' => 0,
        ]);

        return response()->json([
            'success' => true,
            'review_id' => $review->id,
            'processing_status' => 'completed',
            'review_status' => $review->review_status,
        ]);
    }
}
