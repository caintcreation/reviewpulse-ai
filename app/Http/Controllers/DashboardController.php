<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display live overview metrics and recent activity for the active store.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $store = $user->stores()->first();

        if (! $store) {
            $store = Store::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => 'Demo Store',
                    'platform_store_id' => 'demo-store-001',
                    'timezone' => 'UTC',
                    'webhook_secret' => 'rp_sec_'.bin2hex(random_bytes(12)),
                ]
            );
        }

        // Date range filter
        $range = $request->query('range', 'all');
        $query = Review::where('store_id', $store->id);

        if ($range === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($range === '7d') {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        } elseif ($range === '30d') {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        }

        $totalReviews = (clone $query)->count();
        $avgRating = (clone $query)->avg('rating') ?: 0;

        $positiveCount = (clone $query)->where('sentiment', 'positive')->count();
        $neutralCount = (clone $query)->where('sentiment', 'neutral')->count();
        $negativeCount = (clone $query)->where('sentiment', 'negative')->count();

        $positivePercentage = $totalReviews > 0 ? round(($positiveCount / $totalReviews) * 100) : 0;
        $neutralPercentage = $totalReviews > 0 ? round(($neutralCount / $totalReviews) * 100) : 0;
        $negativePercentage = $totalReviews > 0 ? round(($negativeCount / $totalReviews) * 100) : 0;

        $awaitingAction = (clone $query)->whereIn('review_status', ['unread', 'pending', 'needs_review'])->count();
        $sentCount = (clone $query)->where('review_status', 'sent')->count();
        $approvedCount = (clone $query)->where('review_status', 'approved')->count();

        // Rating breakdown (1 to 5 stars)
        $starBreakdown = [];
        for ($s = 5; $s >= 1; $s--) {
            $count = (clone $query)->where('rating', $s)->count();
            $starBreakdown[$s] = [
                'count' => $count,
                'pct' => $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0,
            ];
        }

        // Recent reviews
        $recentReviews = (clone $query)->latest()->take(6)->get();

        return view('dashboard.index', [
            'store' => $store,
            'range' => $range,
            'totalReviews' => $totalReviews,
            'avgRating' => round($avgRating, 1),
            'positiveCount' => $positiveCount,
            'neutralCount' => $neutralCount,
            'negativeCount' => $negativeCount,
            'positivePercentage' => $positivePercentage,
            'neutralPercentage' => $neutralPercentage,
            'negativePercentage' => $negativePercentage,
            'awaitingAction' => $awaitingAction,
            'sentCount' => $sentCount,
            'approvedCount' => $approvedCount,
            'starBreakdown' => $starBreakdown,
            'recentReviews' => $recentReviews,
        ]);
    }
}
