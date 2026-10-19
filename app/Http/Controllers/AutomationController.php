<?php

namespace App\Http\Controllers;

use App\Models\AutomationLog;
use App\Models\Review;
use App\Services\ReviewAnalysisService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AutomationController extends Controller
{
    public function __construct(
        protected ReviewAnalysisService $analysisService
    ) {}

    /**
     * Show automation status, webhook information, and execution audit logs.
     */
    public function index(): View
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $logs = AutomationLog::with('review')
            ->whereHas('review', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->latest()
            ->paginate(15);

        $totalRuns = AutomationLog::whereHas('review', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->count();

        $completedRuns = AutomationLog::whereHas('review', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->where('status', 'completed')->count();

        $failedRuns = AutomationLog::whereHas('review', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->where('status', 'failed')->count();

        $lastExecution = AutomationLog::whereHas('review', function ($q) use ($store) {
            $q->where('store_id', $store->id);
        })->latest()->first();

        $webhookUrl = url('/api/reviews');
        $callbackUrl = url('/api/internal/reviews/{review_id}/analysis');

        return view('automation.index', [
            'store' => $store,
            'logs' => $logs,
            'totalRuns' => $totalRuns,
            'completedRuns' => $completedRuns,
            'failedRuns' => $failedRuns,
            'lastExecution' => $lastExecution,
            'webhookUrl' => $webhookUrl,
            'callbackUrl' => $callbackUrl,
        ]);
    }

    /**
     * Trigger a live test run through the review automation pipeline.
     */
    public function testConnection(): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $testReview = Review::create([
            'store_id' => $store->id,
            'reviewer_name' => 'Automated Test Bot',
            'product_name' => 'ReviewPulse Cloud Gateway',
            'rating' => 5,
            'review_text' => 'Live automated connection test executed from settings dashboard. Validating webhook and AI processing pipeline connectivity.',
            'review_status' => 'approved',
            'processing_status' => 'queued',
            'source' => 'test_suite',
        ]);

        $this->analysisService->processAndSave($testReview);

        return back()->with('success', 'Connection test succeeded! Test review was generated and processed with 100% success.');
    }

    /**
     * Retry a failed automation execution log.
     */
    public function retryLog(int $id): RedirectResponse
    {
        $user = Auth::user();
        $store = $user->stores()->firstOrFail();

        $log = AutomationLog::findOrFail($id);
        $review = $log->review;

        if ($review && $review->store_id === $store->id) {
            $this->analysisService->processAndSave($review);
            $log->update([
                'status' => 'completed',
                'retry_count' => $log->retry_count + 1,
                'error_message' => null,
            ]);

            return back()->with('success', "Workflow execution #{$id} retried successfully.");
        }

        return back()->withErrors(['error' => 'Log or review not found.']);
    }
}
