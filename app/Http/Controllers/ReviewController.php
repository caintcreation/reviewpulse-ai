<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewReplyHistory;
use App\Models\Store;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewAnalysisService $analysisService
    ) {}

    /**
     * Display a paginated, filterable list of reviews for the active store.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $query = Review::where('store_id', $store->id);

        // Search text
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('reviewer_name', 'like', "%{$search}%")
                    ->orWhere('product_name', 'like', "%{$search}%")
                    ->orWhere('review_text', 'like', "%{$search}%");
            });
        }

        // Filter: Sentiment
        if ($sentiment = $request->query('sentiment')) {
            if (in_array($sentiment, ['positive', 'neutral', 'negative'])) {
                $query->where('sentiment', $sentiment);
            }
        }

        // Filter: Rating
        if ($rating = $request->query('rating')) {
            if (is_numeric($rating) && $rating >= 1 && $rating <= 5) {
                $query->where('rating', (int) $rating);
            }
        }

        // Filter: Status
        if ($status = $request->query('status')) {
            if (in_array($status, ['unread', 'pending', 'needs_review', 'approved', 'sent', 'archived'])) {
                $query->where('review_status', $status);
            }
        }

        // Sorting
        $sort = $request->query('sort', 'newest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'rating_high' => $query->orderByDesc('rating')->latest(),
            'rating_low' => $query->orderBy('rating')->latest(),
            default => $query->latest(),
        };

        $reviews = $query->paginate(10)->withQueryString();

        return view('reviews.index', [
            'store' => $store,
            'reviews' => $reviews,
            'filters' => [
                'q' => $request->query('q', ''),
                'sentiment' => $request->query('sentiment', ''),
                'rating' => $request->query('rating', ''),
                'status' => $request->query('status', ''),
                'sort' => $sort,
            ],
        ]);
    }

    /**
     * Show detailed review view and AI response workspace.
     */
    public function show(int $id): View
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)
            ->with(['replyHistories.user', 'automationLogs'])
            ->findOrFail($id);

        return view('reviews.show', [
            'store' => $store,
            'review' => $review,
        ]);
    }

    /**
     * Create review manually via dashboard modal or form.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $validated = $request->validate([
            'reviewer_name' => ['required', 'string', 'max:255'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review_text' => ['required', 'string', 'max:3000'],
            'source' => ['nullable', 'string', 'max:50'],
        ]);

        $review = Review::create([
            'store_id' => $store->id,
            'reviewer_name' => $validated['reviewer_name'],
            'product_name' => $validated['product_name'] ?: 'General Service',
            'rating' => $validated['rating'],
            'review_text' => $validated['review_text'],
            'source' => $validated['source'] ?: 'manual',
            'review_status' => 'unread',
            'processing_status' => 'queued',
        ]);

        // Run analysis synchronously for immediate MVP feedback
        $this->analysisService->processAndSave($review);

        return redirect()->route('reviews.show', $review->id)
            ->with('success', 'Review submitted and AI analysis generated successfully!');
    }

    /**
     * Save draft reply edit.
     */
    public function updateReply(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);

        $validated = $request->validate([
            'suggested_reply' => ['required', 'string', 'max:4000'],
        ]);

        $original = $review->getActiveReplyAttribute();
        $edited = $validated['suggested_reply'];

        $review->update([
            'suggested_reply' => $edited,
            'review_status' => ($review->review_status === 'unread' || $review->review_status === 'needs_review') ? 'pending' : $review->review_status,
        ]);

        ReviewReplyHistory::create([
            'review_id' => $review->id,
            'original_reply' => $original,
            'edited_reply' => $edited,
            'user_id' => $user->id,
            'action_type' => 'edit',
        ]);

        return back()->with('success', 'Draft reply saved successfully.');
    }

    /**
     * Approve reply.
     */
    public function approve(int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);

        if (empty($review->getActiveReplyAttribute())) {
            return back()->withErrors(['reply' => 'Cannot approve an empty reply. Please generate or enter a reply draft first.']);
        }

        $review->update([
            'review_status' => 'approved',
            'requires_human_review' => false,
        ]);

        ReviewReplyHistory::create([
            'review_id' => $review->id,
            'original_reply' => $review->ai_generated_reply,
            'edited_reply' => $review->getActiveReplyAttribute(),
            'user_id' => $user->id,
            'action_type' => 'approve',
        ]);

        return back()->with('success', 'Reply approved! Ready for publishing.');
    }

    /**
     * Mark reply as sent in Demo Mode.
     */
    public function sendDemo(int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);

        if (empty($review->getActiveReplyAttribute())) {
            return back()->withErrors(['reply' => 'Cannot send an empty reply. Please generate a reply first.']);
        }

        $review->update([
            'review_status' => 'sent',
            'requires_human_review' => false,
        ]);

        ReviewReplyHistory::create([
            'review_id' => $review->id,
            'original_reply' => $review->ai_generated_reply,
            'edited_reply' => $review->getActiveReplyAttribute(),
            'user_id' => $user->id,
            'action_type' => 'send',
        ]);

        return back()->with('success', 'Response marked as SENT in Demo Mode (Simulated live publishing).');
    }

    /**
     * Flag review for human review.
     */
    public function flag(int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);

        $review->update([
            'review_status' => 'needs_review',
            'requires_human_review' => true,
        ]);

        return back()->with('info', 'Review has been flagged for human attention.');
    }

    /**
     * Regenerate AI reply with optional tone parameter.
     */
    public function regenerate(Request $request, int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);
        $tone = $request->input('tone', 'professional');

        $this->analysisService->processAndSave($review, $tone);

        return back()->with('success', "AI response regenerated with {$tone} tone.");
    }

    /**
     * Reprocess review pipeline if failed.
     */
    public function reprocess(int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $review = Review::where('store_id', $store->id)->findOrFail($id);

        $this->analysisService->processAndSave($review);

        return back()->with('success', 'Review analysis reprocessed successfully.');
    }
}
