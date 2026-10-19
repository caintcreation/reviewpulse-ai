@extends('layouts.app')

@section('title', 'Automation & Logs')
@section('page_title', 'Automation & Logs')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2 border-b border-slate-800/80">
        <div>
            <h2 class="text-xl font-extrabold text-white tracking-tight">Automation Pipeline & Webhooks</h2>
            <p class="text-xs text-slate-400">Monitor incoming review intake, n8n workflow connections, and background AI execution telemetry</p>
        </div>

        <!-- Trigger Live Test Connection Button -->
        <form action="{{ route('automation.test') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="px-4 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-xs shadow-lg shadow-indigo-500/25 transition flex items-center space-x-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>Trigger Test Pipeline Connection</span>
            </button>
        </form>
    </div>

    <!-- 4 Automation KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Status Card -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Connection Status</span>
            <div class="flex items-center space-x-2.5">
                @if($totalRuns > 0)
                    <div class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></div>
                    <span class="text-lg font-bold text-emerald-400">Connected & Verified</span>
                @else
                    <div class="w-3 h-3 rounded-full bg-slate-500"></div>
                    <span class="text-lg font-bold text-slate-400">Not Connected</span>
                @endif
            </div>
            <p class="text-[11px] text-slate-500 mt-2">
                @if($lastExecution)
                    Last run: {{ $lastExecution->created_at->diffForHumans() }}
                @else
                    Awaiting initial webhook dispatch
                @endif
            </p>
        </div>

        <!-- Total Executions -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Total Executions</span>
            <div class="text-2xl font-black text-white">{{ number_format($totalRuns) }}</div>
            <p class="text-[11px] text-slate-500 mt-2">Workflows processed</p>
        </div>

        <!-- Completed Runs -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Successful Runs</span>
            <div class="text-2xl font-black text-emerald-400">{{ number_format($completedRuns) }}</div>
            <p class="text-[11px] text-slate-500 mt-2">Zero unhandled exceptions</p>
        </div>

        <!-- Failed Runs -->
        <div class="p-5 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-2">Failed Runs</span>
            <div class="text-2xl font-black {{ $failedRuns > 0 ? 'text-rose-400' : 'text-slate-300' }}">{{ number_format($failedRuns) }}</div>
            <p class="text-[11px] text-slate-500 mt-2">Retryable failure events</p>
        </div>
    </div>

    <!-- Webhook Integration Architecture Box -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-4">
        <div>
            <h3 class="text-sm font-bold text-white">Endpoint & Webhook Credentials</h3>
            <p class="text-xs text-slate-400">Use these endpoints to bridge Google Reviews, Shopify, or n8n workflow webhooks</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Review Intake Endpoint -->
            <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800 space-y-1.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-400">1. Review Intake Webhook</span>
                <p class="text-xs font-mono text-slate-300 break-all select-all bg-slate-900 px-2 py-1.5 rounded border border-slate-800">{{ $webhookUrl }}</p>
                <p class="text-[11px] text-slate-400">Accepts <code class="text-indigo-300">POST</code> with JSON payload (reviewer_name, rating, review_text, product_name)</p>
            </div>

            <!-- Secure Callback Endpoint -->
            <div class="p-4 rounded-xl bg-slate-950/80 border border-slate-800 space-y-1.5">
                <span class="text-[11px] font-bold uppercase tracking-wider text-cyan-400">2. Secure Analysis Callback Endpoint</span>
                <p class="text-xs font-mono text-slate-300 break-all select-all bg-slate-900 px-2 py-1.5 rounded border border-slate-800">{{ $callbackUrl }}</p>
                <p class="text-[11px] text-slate-400">Header required: <code class="text-cyan-300">X-ReviewPulse-Secret: {{ $store->webhook_secret ?? 'rp_sec_...' }}</code></p>
            </div>
        </div>
    </div>

    <!-- Execution Logs Table -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-white">Execution Audit Trail</h3>
                <p class="text-xs text-slate-400">History of dispatched workflows, status responses, and error traces</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3 px-4">Log ID</th>
                        <th class="py-3 px-4">Workflow Type</th>
                        <th class="py-3 px-4">Associated Review</th>
                        <th class="py-3 px-4">Execution Status</th>
                        <th class="py-3 px-4">Payload Summary</th>
                        <th class="py-3 px-4">Timestamp</th>
                        <th class="py-3 px-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="py-3.5 px-4 font-mono text-slate-400">#{{ $log->id }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-200">{{ $log->workflow_type }}</td>
                            <td class="py-3.5 px-4">
                                @if($log->review)
                                    <a href="{{ route('reviews.show', $log->review->id) }}" class="text-indigo-400 hover:underline">
                                        Review #{{ $log->review->id }} ({{ $log->review->reviewer_name }})
                                    </a>
                                @else
                                    <span class="text-slate-500">N/A</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if($log->status === 'completed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950/80 text-emerald-400 border border-emerald-500/30">Completed</span>
                                @elseif($log->status === 'failed')
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-950/80 text-rose-400 border border-rose-500/30">Failed</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-950/80 text-amber-400 border border-amber-500/30">Processing</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate font-mono text-[11px] text-slate-400">
                                {{ $log->payload_data ? Str::limit($log->payload_data, 50) : '-' }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-mono text-slate-500 text-[11px]">
                                {{ $log->created_at->format('M d, H:i:s') }}
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @if($log->status === 'failed')
                                    <form action="{{ route('automation.retry', $log->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded bg-rose-900/60 hover:bg-rose-800 text-rose-200 font-semibold text-[11px] cursor-pointer">
                                            Retry
                                        </button>
                                    </form>
                                @else
                                    <span class="text-slate-600 text-[11px]">No action</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                No automation logs recorded yet. Click "Trigger Test Pipeline Connection" above to simulate an execution.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="pt-4 border-t border-slate-800">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
