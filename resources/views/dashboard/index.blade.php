@extends('layouts.app')

@section('title', 'Overview Dashboard')
@section('page_title', 'Overview Dashboard')

@section('content')
<div class="space-y-6">

    <!-- Top Stats Header & Date Filter Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
        <div>
            <h2 class="text-xl font-extrabold text-white tracking-tight">Review Performance & Insights</h2>
            <p class="text-xs text-slate-400">Real-time sentiment telemetry and AI response pipeline for {{ $store->name }}</p>
        </div>

        <!-- Date Range Filter Tabs -->
        <div class="inline-flex rounded-xl p-1 bg-slate-900 border border-slate-800 text-xs">
            <a href="{{ route('dashboard', ['range' => 'all']) }}" 
               class="px-3 py-1.5 rounded-lg font-medium transition {{ $range === 'all' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                All Time
            </a>
            <a href="{{ route('dashboard', ['range' => 'today']) }}" 
               class="px-3 py-1.5 rounded-lg font-medium transition {{ $range === 'today' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                Today
            </a>
            <a href="{{ route('dashboard', ['range' => '7d']) }}" 
               class="px-3 py-1.5 rounded-lg font-medium transition {{ $range === '7d' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                Last 7 Days
            </a>
            <a href="{{ route('dashboard', ['range' => '30d']) }}" 
               class="px-3 py-1.5 rounded-lg font-medium transition {{ $range === '30d' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-400 hover:text-white' }}">
                Last 30 Days
            </a>
        </div>
    </div>

    <!-- 5 Core KPI Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Card 1: Total Reviews -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Reviews</span>
                <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-white tracking-tight">{{ number_format($totalReviews) }}</div>
            <p class="text-[11px] text-slate-400 mt-2 flex items-center">
                <span class="text-indigo-400 font-semibold mr-1.5">{{ $sentCount }}</span> published in demo mode
            </p>
        </div>

        <!-- Card 2: Average Rating -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Avg Star Rating</span>
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-400 flex items-center justify-center">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
            </div>
            <div class="flex items-baseline space-x-2">
                <span class="text-3xl font-black text-amber-300 tracking-tight">{{ number_format($avgRating, 1) }}</span>
                <span class="text-xs text-slate-400 font-medium">/ 5.0</span>
            </div>
            <div class="flex items-center space-x-1 mt-2 text-amber-400 text-xs">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3.5 h-3.5 {{ $i <= round($avgRating) ? 'fill-amber-400' : 'text-slate-700' }}" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                @endfor
            </div>
        </div>

        <!-- Card 3: Positive Sentiment -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Positive Share</span>
                <div class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-emerald-400 tracking-tight">{{ $positivePercentage }}%</div>
            <p class="text-[11px] text-slate-400 mt-2">
                <span class="text-emerald-400 font-semibold">{{ $positiveCount }}</span> satisfied customers
            </p>
        </div>

        <!-- Card 4: Negative / Complaints -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Negative / Risk</span>
                <div class="w-8 h-8 rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-rose-400 tracking-tight">{{ $negativePercentage }}%</div>
            <p class="text-[11px] text-slate-400 mt-2">
                <span class="text-rose-400 font-semibold">{{ $negativeCount }}</span> negative feedback items
            </p>
        </div>

        <!-- Card 5: Awaiting Action -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg relative overflow-hidden group hover:border-slate-700 transition">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Awaiting Action</span>
                <div class="w-8 h-8 rounded-lg bg-violet-500/10 border border-violet-500/20 text-violet-400 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-violet-400 tracking-tight">{{ $awaitingAction }}</div>
            <p class="text-[11px] text-slate-400 mt-2">
                Needs human review or draft approval
            </p>
        </div>
    </div>

    <!-- Analytics Section: Sentiment Gauge & Star Rating Breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Sentiment Breakdown Card -->
        <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <h3 class="text-sm font-bold text-white mb-1">Sentiment Distribution</h3>
            <p class="text-xs text-slate-400 mb-6">AI natural language classification across all channels</p>

            <!-- Stacked Sentiment Progress Bar -->
            <div class="h-4 rounded-full bg-slate-800 flex overflow-hidden p-0.5 space-x-1 mb-6">
                @if($positivePercentage > 0)
                    <div style="width: {{ $positivePercentage }}%" class="bg-emerald-500 rounded-l-full" title="Positive: {{ $positivePercentage }}%"></div>
                @endif
                @if($neutralPercentage > 0)
                    <div style="width: {{ $neutralPercentage }}%" class="bg-amber-400" title="Neutral: {{ $neutralPercentage }}%"></div>
                @endif
                @if($negativePercentage > 0)
                    <div style="width: {{ $negativePercentage }}%" class="bg-rose-500 rounded-r-full" title="Negative: {{ $negativePercentage }}%"></div>
                @endif
            </div>

            <!-- Legend Items with Counts -->
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span class="font-medium text-slate-200">Positive</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-white">{{ $positiveCount }}</span>
                        <span class="text-slate-400">({{ $positivePercentage }}%)</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="font-medium text-slate-200">Neutral</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-white">{{ $neutralCount }}</span>
                        <span class="text-slate-400">({{ $neutralPercentage }}%)</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                        <span class="font-medium text-slate-200">Negative</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-white">{{ $negativeCount }}</span>
                        <span class="text-slate-400">({{ $negativePercentage }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Star Rating Breakdown Card (2 columns wide) -->
        <div class="lg:col-span-2 p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <h3 class="text-sm font-bold text-white mb-1">Star Rating Breakdown</h3>
            <p class="text-xs text-slate-400 mb-6">Customer satisfaction spread across 1 to 5 star scores</p>

            <div class="space-y-3.5">
                @foreach($starBreakdown as $star => $data)
                    <div class="flex items-center space-x-4 text-xs">
                        <div class="flex items-center space-x-1 w-14 shrink-0 font-medium text-slate-300">
                            <span>{{ $star }}</span>
                            <span class="text-amber-400">★</span>
                        </div>
                        <div class="flex-1 h-3 rounded-full bg-slate-800/80 overflow-hidden">
                            <div style="width: {{ $data['pct'] }}%" 
                                 class="h-full rounded-full {{ $star >= 4 ? 'bg-emerald-500' : ($star == 3 ? 'bg-amber-400' : 'bg-rose-500') }} transition-all duration-500">
                            </div>
                        </div>
                        <div class="w-16 text-right text-slate-400 font-mono text-[11px] shrink-0">
                            {{ $data['count'] }} ({{ $data['pct'] }}%)
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Incoming Reviews Section -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-bold text-white">Recent Customer Reviews</h3>
                <p class="text-xs text-slate-400">Incoming reviews with automated AI response drafts</p>
            </div>
            <a href="{{ route('reviews.index') }}" class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 flex items-center space-x-1">
                <span>View All In Inbox</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="divide-y divide-slate-800/60">
            @forelse($recentReviews as $rev)
                <div class="py-4 flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                    <div class="flex items-start space-x-3.5 min-w-0">
                        <div class="w-9 h-9 rounded-full bg-slate-800 border border-slate-700/80 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0 mt-0.5">
                            {{ substr($rev->reviewer_name, 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center space-x-2.5 flex-wrap">
                                <span class="font-bold text-slate-100 text-sm">{{ $rev->reviewer_name }}</span>
                                <span class="text-xs text-amber-400 font-mono">
                                    @for($i = 0; $i < $rev->rating; $i++)★@endfor
                                </span>
                                @if($rev->product_name)
                                    <span class="text-xs text-slate-400">on <strong class="text-slate-300 font-normal">{{ $rev->product_name }}</strong></span>
                                @endif

                                <!-- Sentiment Badge -->
                                @if($rev->sentiment === 'positive')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-950/80 text-emerald-400 border border-emerald-500/30">Positive</span>
                                @elseif($rev->sentiment === 'negative')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-rose-950/80 text-rose-400 border border-rose-500/30">Negative</span>
                                @else
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-amber-950/80 text-amber-400 border border-amber-500/30">Neutral</span>
                                @endif

                                <!-- Review Status Badge -->
                                @if($rev->review_status === 'sent')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-cyan-950/80 text-cyan-300 border border-cyan-500/30">Sent (Demo)</span>
                                @elseif($rev->review_status === 'approved')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-indigo-950/80 text-indigo-300 border border-indigo-500/30">Approved</span>
                                @elseif($rev->review_status === 'needs_review')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-rose-950/80 text-rose-300 border border-rose-500/30 animate-pulse">Needs Review</span>
                                @else
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-800 text-slate-300 border border-slate-700">Pending</span>
                                @endif
                            </div>

                            <p class="text-xs text-slate-300 mt-1 line-clamp-1 italic">"{{ $rev->review_text }}"</p>

                            @if($rev->ai_summary)
                                <p class="text-[11px] text-indigo-300 mt-1 flex items-center space-x-1">
                                    <svg class="w-3.5 h-3.5 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span class="truncate"><strong>AI Summary:</strong> {{ $rev->ai_summary }}</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center space-x-3 shrink-0 self-end md:self-center">
                        <span class="text-[11px] text-slate-500 font-mono">{{ $rev->created_at->diffForHumans() }}</span>
                        <a href="{{ route('reviews.show', $rev->id) }}" 
                           class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white text-slate-300 text-xs font-semibold transition border border-slate-700">
                            Open Workspace &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-400 text-sm">
                    No reviews received in this time period. Use the "+ Add Demo Review" button to generate one!
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
