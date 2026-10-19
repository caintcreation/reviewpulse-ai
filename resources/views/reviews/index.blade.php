@extends('layouts.app')

@section('title', 'Reviews Inbox')
@section('page_title', 'Reviews Inbox')

@section('content')
<div class="space-y-6">

    <!-- Filters & Search Form -->
    <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
        <form action="{{ route('reviews.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
            <!-- Search Query -->
            <div class="lg:col-span-2">
                <label class="block text-xs font-semibold text-slate-300 mb-1">Search Keywords</label>
                <div class="relative">
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Search customer, product, or review text..."
                           class="w-full pl-9 pr-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <!-- Sentiment Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Sentiment</label>
                <select name="sentiment" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white focus:outline-none focus:border-indigo-500">
                    <option value="">All Sentiments</option>
                    <option value="positive" {{ $filters['sentiment'] === 'positive' ? 'selected' : '' }}>Positive (Good/Great)</option>
                    <option value="neutral" {{ $filters['sentiment'] === 'neutral' ? 'selected' : '' }}>Neutral (Mixed/Okay)</option>
                    <option value="negative" {{ $filters['sentiment'] === 'negative' ? 'selected' : '' }}>Negative (Complaint/Risk)</option>
                </select>
            </div>

            <!-- Rating Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Star Rating</label>
                <select name="rating" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white focus:outline-none focus:border-indigo-500">
                    <option value="">All Ratings (1 - 5)</option>
                    <option value="5" {{ $filters['rating'] === '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ $filters['rating'] === '4' ? 'selected' : '' }}>4 Stars</option>
                    <option value="3" {{ $filters['rating'] === '3' ? 'selected' : '' }}>3 Stars</option>
                    <option value="2" {{ $filters['rating'] === '2' ? 'selected' : '' }}>2 Stars</option>
                    <option value="1" {{ $filters['rating'] === '1' ? 'selected' : '' }}>1 Star</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Review Status</label>
                <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-xs text-white focus:outline-none focus:border-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="needs_review" {{ $filters['status'] === 'needs_review' ? 'selected' : '' }}>Needs Review (Flagged)</option>
                    <option value="pending" {{ $filters['status'] === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ $filters['status'] === 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="sent" {{ $filters['status'] === 'sent' ? 'selected' : '' }}>Sent (Demo Mode)</option>
                    <option value="unread" {{ $filters['status'] === 'unread' ? 'selected' : '' }}>Unread</option>
                </select>
            </div>
        </form>

        @if(!empty($filters['q']) || !empty($filters['sentiment']) || !empty($filters['rating']) || !empty($filters['status']))
            <div class="mt-3 pt-3 border-t border-slate-800 flex items-center justify-between text-xs">
                <span class="text-slate-400">Filtering active results</span>
                <a href="{{ route('reviews.index') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Clear all filters</a>
            </div>
        @endif
    </div>

    <!-- Reviews Table Card -->
    <div class="rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 bg-slate-900/90 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-5 py-3.5">Customer & Product</th>
                        <th class="px-5 py-3.5">Rating</th>
                        <th class="px-5 py-3.5">Review Feedback</th>
                        <th class="px-5 py-3.5">Sentiment</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Date</th>
                        <th class="px-5 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 text-xs">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-slate-800/30 transition group">
                            <!-- Customer & Product -->
                            <td class="px-5 py-4 min-w-[180px]">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-slate-300 text-xs shrink-0">
                                        {{ substr($review->reviewer_name, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-white truncate">{{ $review->reviewer_name }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">{{ $review->product_name ?? 'General' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Rating -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-1 text-amber-400 font-mono">
                                    <span>{{ $review->rating }}</span>
                                    <span>★</span>
                                </div>
                            </td>

                            <!-- Review Text & AI summary -->
                            <td class="px-5 py-4 max-w-xs md:max-w-md">
                                <p class="text-slate-200 line-clamp-2 leading-relaxed">"{{ $review->review_text }}"</p>
                                @if($review->ai_summary)
                                    <p class="text-[11px] text-indigo-400/90 mt-1 line-clamp-1 flex items-center space-x-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shrink-0"></span>
                                        <span>{{ $review->ai_summary }}</span>
                                    </p>
                                @endif
                            </td>

                            <!-- Sentiment Badge -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($review->sentiment === 'positive')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-950/80 text-emerald-400 border border-emerald-500/30">
                                        Positive ({{ round(($review->confidence_score ?? 0.95) * 100) }}%)
                                    </span>
                                @elseif($review->sentiment === 'negative')
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-rose-950/80 text-rose-400 border border-rose-500/30">
                                        Negative ({{ round(($review->confidence_score ?? 0.95) * 100) }}%)
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-amber-950/80 text-amber-400 border border-amber-500/30">
                                        Neutral ({{ round(($review->confidence_score ?? 0.85) * 100) }}%)
                                    </span>
                                @endif
                            </td>

                            <!-- Status Pill -->
                            <td class="px-5 py-4 whitespace-nowrap">
                                @if($review->review_status === 'sent')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-cyan-950/80 text-cyan-300 border border-cyan-500/30">Sent (Demo)</span>
                                @elseif($review->review_status === 'approved')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-indigo-950/80 text-indigo-300 border border-indigo-500/30">Approved</span>
                                @elseif($review->review_status === 'needs_review')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-rose-950/80 text-rose-300 border border-rose-500/30 animate-pulse">Needs Review</span>
                                @elseif($review->review_status === 'pending')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-amber-950/80 text-amber-300 border border-amber-500/30">Pending</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-slate-800 text-slate-300 border border-slate-700">Unread</span>
                                @endif
                            </td>

                            <!-- Date -->
                            <td class="px-5 py-4 whitespace-nowrap text-slate-400 text-[11px] font-mono">
                                {{ $review->created_at->format('M d, H:i') }}
                            </td>

                            <!-- Action -->
                            <td class="px-5 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('reviews.show', $review->id) }}" 
                                   class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white text-slate-200 font-semibold transition border border-slate-700">
                                    <span>Reply</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                No reviews match your selected filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($reviews->hasPages())
            <div class="px-6 py-4 border-t border-slate-800 bg-slate-900/60">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
