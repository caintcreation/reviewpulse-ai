@extends('layouts.app')

@section('title', 'Store & System Settings')
@section('page_title', 'Store & System Settings')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <div class="pb-2 border-b border-slate-800/80">
        <h2 class="text-xl font-extrabold text-white tracking-tight">Store & Model Configuration</h2>
        <p class="text-xs text-slate-400">Manage business details, webhook signing keys, and review response defaults</p>
    </div>

    <!-- Store Profile Configuration Card -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-5">
        <div>
            <h3 class="text-sm font-bold text-white">Store Identity</h3>
            <p class="text-xs text-slate-400">Details used in AI review replies and automated customer messages</p>
        </div>

        <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Store / Business Name</label>
                    <input type="text" name="name" value="{{ old('name', $store->name) }}" required
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Platform Store Identifier</label>
                    <input type="text" value="{{ $store->platform_store_id }}" readonly
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950/80 border border-slate-800 text-sm font-mono text-slate-400 cursor-not-allowed">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Timezone</label>
                    <select name="timezone" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                        <option value="America/New_York" {{ $store->timezone === 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                        <option value="America/Los_Angeles" {{ $store->timezone === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles (PST)</option>
                        <option value="America/Chicago" {{ $store->timezone === 'America/Chicago' ? 'selected' : '' }}>America/Chicago (CST)</option>
                        <option value="Europe/London" {{ $store->timezone === 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                        <option value="UTC" {{ $store->timezone === 'UTC' ? 'selected' : '' }}>UTC</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Default AI Tone</label>
                    <select disabled class="w-full px-3.5 py-2.5 rounded-xl bg-slate-950/80 border border-slate-800 text-sm text-slate-400">
                        <option>Professional & Empathetic (Adaptive)</option>
                    </select>
                </div>
            </div>

            <div class="pt-2 flex justify-end">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-xs shadow-md shadow-indigo-600/20 transition cursor-pointer">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Webhook Secret & Security Card -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-bold text-white">Webhook Signing Secret</h3>
                <p class="text-xs text-slate-400">Used by n8n or external workers to securely post back analysis</p>
            </div>
        </div>

        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-between">
            <span class="font-mono text-xs text-emerald-400 select-all">{{ $store->webhook_secret ?? 'Not configured' }}</span>
            <form action="{{ route('settings.regenerate-secret') }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Rotating the secret will require updating your n8n workflow headers. Continue?')"
                        class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-medium border border-slate-700 cursor-pointer">
                    Rotate Secret
                </button>
            </form>
        </div>
    </div>

    <!-- Google Gemini AI Studio Setup Info Card -->
    <div class="p-6 rounded-2xl bg-slate-900/80 border border-slate-800/80 shadow-lg space-y-3">
        <div class="flex items-center space-x-2.5">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/10 border border-indigo-500/20 text-indigo-400 flex items-center justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">Google Gemini AI Engine</h3>
                <p class="text-xs text-slate-400">Current status: Active (Smart Fallback Engine enabled)</p>
            </div>
        </div>
        <p class="text-xs text-slate-300 leading-relaxed">
            ReviewPulse AI includes an intelligent deterministic NLP engine out-of-the-box for instant local testing. To optionally connect direct Google Gemini API generation:
        </p>
        <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 font-mono text-xs text-indigo-300">
            GEMINI_API_KEY=your_google_ai_studio_api_key_here
        </div>
        <p class="text-[11px] text-slate-400">Add this to your <code class="text-slate-300 font-mono">.env</code> file. No restart required.</p>
    </div>

</div>
@endsection
