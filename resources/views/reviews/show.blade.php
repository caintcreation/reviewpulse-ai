@extends('layouts.app')

@section('title', 'AI Response Workspace #' . $review->id)
@section('page_title', 'AI Response Workspace')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Top Action Breadcrumb & Status Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-800/80">
        <div class="flex items-center space-x-3">
            <a href="{{ route('reviews.index') }}" class="p-2 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white hover:bg-slate-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <div class="flex items-center space-x-2.5">
                    <h2 class="text-lg font-extrabold text-white">Review #{{ $review->id }} &mdash; {{ $review->reviewer_name }}</h2>
                    <span class="text-xs text-slate-400 font-mono">({{ $review->created_at->format('M d, Y H:i') }})</span>
                </div>
                <p class="text-xs text-slate-400">Intake channel: <strong class="text-slate-300 capitalize">{{ $review->source }}</strong></p>
            </div>
        </div>

        <div class="flex items-center space-x-2.5 flex-wrap">
            <!-- Review Status Pill -->
            @if($review->review_status === 'sent')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-cyan-950/90 text-cyan-300 border border-cyan-500/30 flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                    <span>Sent (Demo Mode)</span>
                </span>
            @elseif($review->review_status === 'approved')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-950/90 text-indigo-300 border border-indigo-500/30 flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                    <span>Approved</span>
                </span>
            @elseif($review->review_status === 'needs_review')
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-950/90 text-rose-300 border border-rose-500/30 flex items-center space-x-1.5 animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                    <span>Requires Human Review</span>
                </span>
            @else
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-950/90 text-amber-300 border border-amber-500/30 flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                    <span>Pending Action</span>
                </span>
            @endif

            <!-- Processing Status -->
            <span class="px-2.5 py-1 rounded-full text-xs font-mono text-slate-400 bg-slate-900 border border-slate-800">
                AI: {{ $review->processing_status }}
            </span>
        </div>
    </div>

    <!-- Alert for Negative / Sensitive Reviews -->
    @if($review->requires_human_review || $review->sentiment === 'negative' || $review->rating <= 2)
        <div class="p-4 rounded-2xl bg-rose-950/40 border border-rose-500/30 text-rose-200 text-xs flex items-start space-x-3 shadow-lg">
            <svg class="w-5 h-5 text-rose-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div>
                <p class="font-bold text-rose-300">Flagged For Human Review & Risk Assessment</p>
                <p class="mt-0.5 text-rose-300/80">This review has been classified as negative or sensitive. Please inspect the customer complaint, customize the draft response with appropriate empathy, and verify details before approving.</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Column 1 & 2: Review Content & AI Editor -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Customer Review Details Card -->
            <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-white text-sm">
                            {{ substr($review->reviewer_name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">{{ $review->reviewer_name }}</h3>
                            <p class="text-xs text-slate-400">Purchased: <span class="text-slate-200">{{ $review->product_name ?? 'General item' }}</span></p>
                        </div>
                    </div>

                    <!-- Star Rating Display -->
                    <div class="flex items-center space-x-1.5 text-amber-400 bg-slate-950/60 px-3 py-1.5 rounded-xl border border-slate-800">
                        <div class="text-base font-bold font-mono">{{ $review->rating }}</div>
                        <div class="flex text-amber-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Review Content -->
                <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800/60 text-sm text-slate-200 leading-relaxed italic">
                    "{{ $review->review_text }}"
                </div>

                <!-- AI Sentiment & Summary Box -->
                <div class="mt-4 p-4 rounded-xl bg-indigo-950/30 border border-indigo-500/20 space-y-2.5">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="font-semibold text-indigo-300">AI Sentiment:</span>
                            @if($review->sentiment === 'positive')
                                <span class="px-2 py-0.5 rounded-full font-bold bg-emerald-950 text-emerald-400 border border-emerald-500/30">Positive</span>
                            @elseif($review->sentiment === 'negative')
                                <span class="px-2 py-0.5 rounded-full font-bold bg-rose-950 text-rose-400 border border-rose-500/30">Negative</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full font-bold bg-amber-950 text-amber-400 border border-amber-500/30">Neutral</span>
                            @endif
                        </div>
                        <span class="text-slate-400 font-mono text-[11px]">Confidence: <strong>{{ round(($review->confidence_score ?? 0.95) * 100) }}%</strong></span>
                    </div>

                    @if($review->ai_summary)
                        <div class="text-xs text-slate-300">
                            <strong class="text-indigo-400 font-medium">Core Summary:</strong> {{ $review->ai_summary }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- AI Suggested Reply Editor Card -->
            <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-white flex items-center space-x-2">
                            <span>AI Suggested Response</span>
                            <span class="text-[10px] uppercase font-bold text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-1.5 py-0.5 rounded">Ready to Edit</span>
                        </h3>
                        <p class="text-xs text-slate-400">Review, personalize, or regenerate the drafted reply</p>
                    </div>

                    <!-- Tone Regenerator Selector -->
                    <form action="{{ route('reviews.regenerate', $review->id) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        <select name="tone" class="px-2.5 py-1 rounded-lg bg-slate-800 border border-slate-700 text-xs text-slate-200 focus:outline-none">
                            <option value="professional">Professional Tone</option>
                            <option value="empathetic">Empathetic Tone</option>
                            <option value="enthusiastic">Enthusiastic Tone</option>
                            <option value="apologetic">Apologetic Tone</option>
                        </select>
                        <button type="submit" class="px-3 py-1 rounded-lg bg-slate-800 hover:bg-slate-700 text-indigo-400 text-xs font-semibold border border-slate-700 flex items-center space-x-1 cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Regenerate</span>
                        </button>
                    </form>
                </div>

                <!-- Reply Textarea Form -->
                <form action="{{ route('reviews.reply', $review->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <textarea name="suggested_reply" rows="6" required 
                                  class="w-full p-4 rounded-xl bg-slate-950 border border-slate-800 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 leading-relaxed font-sans">{{ old('suggested_reply', $review->getActiveReplyAttribute()) }}</textarea>
                    </div>

                    <!-- Action Buttons Toolbar -->
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <div class="flex items-center space-x-2">
                            <!-- Save Draft Button -->
                            <button type="submit" 
                                    class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition cursor-pointer">
                                Save Draft Edit
                            </button>
                        </div>
                </form>

                        <div class="flex items-center space-x-2.5">
                            <!-- Flag for Human Review Form -->
                            <form action="{{ route('reviews.flag', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-3.5 py-2 rounded-xl bg-rose-950/50 hover:bg-rose-900/60 text-rose-300 text-xs font-semibold border border-rose-800/60 transition cursor-pointer">
                                    Flag Attention
                                </button>
                            </form>

                            <!-- Approve Reply Form -->
                            <form action="{{ route('reviews.approve', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-semibold shadow-md shadow-indigo-600/20 transition cursor-pointer">
                                    Approve Reply
                                </button>
                            </form>

                            <!-- Mark as Sent (Demo Mode) Form -->
                            <form action="{{ route('reviews.send-demo', $review->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white text-xs font-bold shadow-md shadow-emerald-600/20 transition cursor-pointer flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Publish (Demo Mode)</span>
                                </button>
                            </form>
                        </div>
                    </div>
            </div>
        </div>

        <!-- Column 3: Audit Trail & Reply History Timeline -->
        <div class="space-y-6">
            <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
                <h3 class="text-sm font-bold text-white mb-1">Reply Audit History</h3>
                <p class="text-xs text-slate-400 mb-4">Complete timeline of AI suggestions and human revisions</p>

                <div class="space-y-4">
                    @forelse($review->replyHistories as $hist)
                        <div class="p-3.5 rounded-xl bg-slate-950/80 border border-slate-800 text-xs space-y-1.5 relative">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-200 capitalize">Action: {{ $hist->action_type }}</span>
                                <span class="text-[10px] text-slate-500 font-mono">{{ $hist->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-400 text-[11px] font-mono">By: {{ $hist->user->name ?? 'System AI' }}</p>
                            <div class="pt-1.5 border-t border-slate-800/80 text-slate-300 text-xs italic">
                                "{{ Str::limit($hist->edited_reply, 120) }}"
                            </div>
                        </div>
                    @empty
                        <div class="p-4 rounded-xl bg-slate-950/40 border border-slate-800/40 text-center text-xs text-slate-500">
                            No edits or approvals recorded yet. The current text matches the original AI draft.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Original AI Draft Reference Card -->
            @if($review->ai_generated_reply)
                <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
                    <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">Original AI Draft</h3>
                    <div class="p-3 rounded-xl bg-slate-950 text-xs text-slate-400 font-mono leading-relaxed">
                        {{ $review->ai_generated_reply }}
                    </div>
                </div>
            @endif

            <!-- Retry Analysis Card -->
            <div class="p-5 rounded-2xl bg-slate-900/60 border border-slate-800/80 text-xs text-slate-400 flex items-center justify-between">
                <div>
                    <p class="font-semibold text-slate-300">Need to re-run pipeline?</p>
                    <p class="text-[11px]">Re-executes sentiment classification & drafting</p>
                </div>
                <form action="{{ route('reviews.reprocess', $review->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium cursor-pointer">
                        Reprocess
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
