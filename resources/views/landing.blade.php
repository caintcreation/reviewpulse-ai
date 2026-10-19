<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50 text-slate-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ReviewPulse AI - Reply to Customer Reviews Automatically with AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-indigo-500 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Top Navigation Header -->
    <header class="border-b border-slate-200 bg-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center space-x-2.5">
                <div class="w-9 h-9 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-extrabold text-sm shadow-sm">
                    RP
                </div>
                <span class="font-bold text-lg text-slate-900 tracking-tight">ReviewPulse AI</span>
            </a>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-slate-600">
                <a href="#how-it-works" class="hover:text-slate-900 transition-colors">How It Works</a>
                <a href="#demo" class="hover:text-slate-900 transition-colors">Interactive Preview</a>
                <a href="#comparison" class="hover:text-slate-900 transition-colors">Why ReviewPulse</a>
                <a href="#pricing" class="hover:text-slate-900 transition-colors">Pricing</a>
                <a href="#faq" class="hover:text-slate-900 transition-colors">FAQ</a>
            </nav>

            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition-colors">
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900 px-3 py-2 transition-colors">
                        Sign In
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition-colors">
                        Start Free Trial
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">

        <!-- Hero Section -->
        <section class="py-16 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    <!-- Left Hero Copy Column -->
                    <div class="lg:col-span-6 text-center lg:text-left">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                            Reply to Customer Reviews Automatically. <span class="text-indigo-600">Without Sounding Like a Robot.</span>
                        </h1>

                        <p class="text-base sm:text-lg text-slate-600 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                            New review on Google, Shopify, or Trustpilot? ReviewPulse analyzes the sentiment, extracts the core message, and drafts an authentic response in your brand voice. You approve or edit before anything gets posted.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mb-6">
                            <a href="{{ route('login') }}" class="px-6 py-3.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-sm transition-colors text-center">
                                Start Free Trial (No Card Required)
                            </a>
                            <a href="#demo" class="px-6 py-3.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm border border-slate-200 transition-colors text-center">
                                See It In Action
                            </a>
                        </div>

                        <!-- Trust Signal -->
                        <div class="flex items-center justify-center lg:justify-start space-x-2 text-xs text-slate-500">
                            <div class="flex text-amber-400">
                                <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                            </div>
                            <span class="font-medium text-slate-700">5.0 Star rated by store owners</span>
                            <span class="text-slate-300">•</span>
                            <span>Free plan available</span>
                        </div>
                    </div>

                    <!-- Right Column: Interactive Review Email / Inbox Mockup -->
                    <div class="lg:col-span-6" id="demo">
                        <div class="bg-white rounded-xl shadow-xl border border-slate-200 overflow-hidden text-left">
                            
                            <!-- Window Title Bar -->
                            <div class="flex items-center justify-between bg-slate-100 px-4 py-2.5 border-b border-slate-200">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-rose-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                                    <span class="text-xs font-semibold text-slate-600 pl-2">ReviewPulse AI Inbox</span>
                                </div>
                                <div class="text-[11px] font-mono text-slate-500">Google Reviews Sync</div>
                            </div>

                            <!-- Interactive Sample Review Switcher Tabs -->
                            <div class="bg-slate-50 px-4 py-2 border-b border-slate-200 flex items-center space-x-2 text-xs">
                                <span class="text-slate-500 font-medium text-[11px] uppercase tracking-wider mr-1">Sample:</span>
                                <button type="button" onclick="selectSample('critique')" id="tab-critique" class="px-2.5 py-1 rounded font-medium border bg-white border-slate-300 text-slate-900 shadow-xs">
                                    1 Star Complaint
                                </button>
                                <button type="button" onclick="selectSample('praise')" id="tab-praise" class="px-2.5 py-1 rounded font-medium border bg-slate-100 border-transparent text-slate-600 hover:text-slate-900">
                                    5 Star Praise
                                </button>
                                <button type="button" onclick="selectSample('mixed')" id="tab-mixed" class="px-2.5 py-1 rounded font-medium border bg-slate-100 border-transparent text-slate-600 hover:text-slate-900">
                                    3 Star Mixed
                                </button>
                            </div>

                            <!-- Notification Body -->
                            <div class="p-5 space-y-4">
                                <!-- Customer Review Card -->
                                <div class="p-4 rounded-lg bg-slate-50 border border-slate-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center font-bold text-xs text-slate-700" id="card-avatar">
                                                J
                                            </div>
                                            <span class="text-xs font-bold text-slate-900" id="card-name">Jane W.</span>
                                            <span class="text-xs text-slate-400" id="card-product">on Wireless Headphones Pro</span>
                                        </div>
                                        <div class="text-amber-500 text-xs font-mono" id="card-rating">★☆☆☆☆ (1/5)</div>
                                    </div>
                                    <p class="text-xs text-slate-700 italic leading-relaxed" id="card-text">
                                        "My headphones arrived late, and the left earbud stopped working after two days. I am disappointed with the quality."
                                    </p>
                                </div>

                                <!-- AI Analysis Result Pill -->
                                <div class="flex items-center justify-between px-3 py-2 rounded-lg bg-slate-100 border border-slate-200 text-xs">
                                    <div class="flex items-center space-x-2">
                                        <span class="font-semibold text-slate-700">Sentiment:</span>
                                        <span id="card-sentiment" class="font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded text-[11px]">Negative (96% Confidence)</span>
                                    </div>
                                    <span id="card-status" class="text-[11px] font-semibold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">Action Required: Flagged for Review</span>
                                </div>

                                <!-- Suggested AI Reply Box -->
                                <div>
                                    <div class="text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
                                        <span>Draft Response in Your Brand Voice:</span>
                                        <span class="text-[11px] text-indigo-600 font-normal">Generated in 1.4s</span>
                                    </div>
                                    <div class="p-3.5 rounded-lg bg-indigo-50/60 border border-indigo-200 text-xs text-slate-800 leading-relaxed font-sans" id="card-reply">
                                        "We're truly sorry to hear about your experience, Jane. We understand how frustrating it is to receive a late delivery followed by a hardware issue. We'd like to make this right immediately. Please reach out to our team at support@caintelectronics.com with your order number so we can arrange an expedited replacement."
                                    </div>
                                </div>

                                <!-- Primary Action Button -->
                                <button type="button" onclick="alert('In the live dashboard, clicking this immediately posts the approved response to Google Reviews in Demo Mode!')" 
                                        class="w-full py-3 px-4 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs transition-colors flex items-center justify-center space-x-2 shadow-xs cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Approve & Post Reply</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Metric Numbers Strip -->
        <section class="py-10 bg-slate-100 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">100%</div>
                        <div class="text-xs text-slate-600 mt-1">Review Response Rate</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">&lt; 2 Seconds</div>
                        <div class="text-xs text-slate-600 mt-1">Average Draft Speed</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">Zero</div>
                        <div class="text-xs text-slate-600 mt-1">Unsupervised Auto-Posts</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-slate-900">3.5 Hours</div>
                        <div class="text-xs text-slate-600 mt-1">Saved Per Week</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works (3 Clean Steps) -->
        <section id="how-it-works" class="py-16 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">How ReviewPulse AI Works</h2>
                    <p class="text-slate-600 text-sm mt-3">Three straightforward steps to run your review inbox on autopilot.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 text-left">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white font-bold text-sm flex items-center justify-center mb-4">
                            1
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">Connect Your Store Channels</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Connect your Google Business Profile, Shopify store, or custom webhook endpoint. ReviewPulse monitors new reviews 24/7 without requiring manual checks.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 text-left">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white font-bold text-sm flex items-center justify-center mb-4">
                            2
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">AI Analyzes & Drafts Responses</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Google Gemini AI reads the review, determines the exact customer sentiment, extracts key takeaways, and drafts an empathetic, tailored response in your brand voice.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="p-6 rounded-xl border border-slate-200 bg-slate-50 text-left">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white font-bold text-sm flex items-center justify-center mb-4">
                            3
                        </div>
                        <h3 class="text-base font-bold text-slate-900 mb-2">One-Click Approval & Publishing</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Approve the draft with a single click, or make quick edits directly in the dashboard. Negative reviews are flagged automatically so a human can inspect them first.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Before vs After Comparison Table -->
        <section id="comparison" class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manual Replying vs ReviewPulse AI</h2>
                    <p class="text-slate-600 text-sm mt-3">Why business owners choose structured review automation.</p>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                                <th class="p-4">Criteria</th>
                                <th class="p-4 text-slate-500">Without ReviewPulse</th>
                                <th class="p-4 text-indigo-700 bg-indigo-50/50">With ReviewPulse AI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <tr>
                                <td class="p-4 font-semibold text-slate-900">Time per review</td>
                                <td class="p-4 text-slate-500">5 to 10 minutes copying back and forth</td>
                                <td class="p-4 text-slate-900 font-medium bg-indigo-50/30">Under 2 seconds with pre-generated draft</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-semibold text-slate-900">Tone consistency</td>
                                <td class="p-4 text-slate-500">Varies wildly depending on who is replying</td>
                                <td class="p-4 text-slate-900 font-medium bg-indigo-50/30">Strict adherence to your defined store persona</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-semibold text-slate-900">Negative review handling</td>
                                <td class="p-4 text-slate-500">Often ignored or replied to defensively</td>
                                <td class="p-4 text-slate-900 font-medium bg-indigo-50/30">Quarantined for human review with empathetic suggestions</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-semibold text-slate-900">Response audit trail</td>
                                <td class="p-4 text-slate-500">No record of who wrote or modified replies</td>
                                <td class="p-4 text-slate-900 font-medium bg-indigo-50/30">Full history table tracking AI drafts vs human edits</td>
                            </tr>
                            <tr>
                                <td class="p-4 font-semibold text-slate-900">Automation integration</td>
                                <td class="p-4 text-slate-500">Requires manual copy-paste</td>
                                <td class="p-4 text-slate-900 font-medium bg-indigo-50/30">Native API endpoints and ready-to-import n8n workflow</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Pricing Section -->
        <section id="pricing" class="py-16 sm:py-24 bg-white border-b border-slate-200">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Simple, Transparent Pricing</h2>
                    <p class="text-slate-600 text-sm mt-3">Start free, upgrade as your store review volume grows.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 items-stretch">
                    
                    <!-- Plan 1: Starter -->
                    <div class="p-8 rounded-xl border border-slate-200 bg-white flex flex-col justify-between text-left">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Free Forever</h3>
                            <p class="text-xs text-slate-500 mt-1 mb-6">For single boutiques & test setups</p>
                            <div class="text-3xl font-extrabold text-slate-900 mb-6">$0 <span class="text-xs font-normal text-slate-500">/ month</span></div>
                            <ul class="text-xs text-slate-700 space-y-3 mb-8">
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>1 Business Location</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Up to 50 Reviews Per Month</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Deterministic Heuristic Engine</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Review Inbox & Manual Edit</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="w-full py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-800 font-semibold text-xs text-center transition-colors">
                            Get Started Free
                        </a>
                    </div>

                    <!-- Plan 2: Pro (Featured) -->
                    <div class="p-8 rounded-xl border-2 border-indigo-600 bg-white flex flex-col justify-between text-left shadow-lg relative">
                        <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-indigo-600 text-white font-bold text-[10px] uppercase tracking-wider">
                            Recommended
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Pro Business</h3>
                            <p class="text-xs text-slate-500 mt-1 mb-6">For active retail & e-commerce brands</p>
                            <div class="text-3xl font-extrabold text-slate-900 mb-6">$19 <span class="text-xs font-normal text-slate-500">/ month</span></div>
                            <ul class="text-xs text-slate-700 space-y-3 mb-8">
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Up to 5 Business Locations</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Unlimited Review Intake</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Google Gemini 3.8 Flash AI Model</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Tone Presets (Professional, Empathetic, Enthusiastic)</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Complete Audit History & Revisions</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="w-full py-2.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs text-center transition-colors shadow-sm">
                            Start 14-Day Free Trial
                        </a>
                    </div>

                    <!-- Plan 3: Multi-Location / Agency -->
                    <div class="p-8 rounded-xl border border-slate-200 bg-white flex flex-col justify-between text-left">
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Agency & Franchise</h3>
                            <p class="text-xs text-slate-500 mt-1 mb-6">For agencies managing client portfolios</p>
                            <div class="text-3xl font-extrabold text-slate-900 mb-6">$49 <span class="text-xs font-normal text-slate-500">/ month</span></div>
                            <ul class="text-xs text-slate-700 space-y-3 mb-8">
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Up to 25 Business Locations</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Multi-User Access & Roles</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Dedicated n8n Webhook Pipeline</span>
                                </li>
                                <li class="flex items-center space-x-2.5">
                                    <span class="text-emerald-600 font-bold">✓</span>
                                    <span>Priority SLA & API Support</span>
                                </li>
                            </ul>
                        </div>
                        <a href="{{ route('login') }}" class="w-full py-2.5 rounded-lg border border-slate-300 hover:bg-slate-50 text-slate-800 font-semibold text-xs text-center transition-colors">
                            Contact Sales
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- Frequently Asked Questions -->
        <section id="faq" class="py-16 sm:py-24 bg-slate-50 border-b border-slate-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Frequently Asked Questions</h2>
                    <p class="text-slate-600 text-sm mt-2">Everything you need to know about ReviewPulse AI.</p>
                </div>

                <div class="space-y-4 text-left">
                    <div class="p-5 rounded-lg bg-white border border-slate-200">
                        <h4 class="text-sm font-bold text-slate-900 mb-1.5">Will ReviewPulse publish replies without my permission?</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            No. By default, every AI-generated reply is kept in draft state until you approve it. In demo mode, approvals are simulated so you can test end-to-end without touching live customer accounts.
                        </p>
                    </div>

                    <div class="p-5 rounded-lg bg-white border border-slate-200">
                        <h4 class="text-sm font-bold text-slate-900 mb-1.5">How does the AI handle critical or 1-star complaints?</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Any review with a 1 or 2 star rating, or reviews flagged with negative sentiment, are marked as "Requires Human Review". ReviewPulse crafts an apologetic, non-defensive draft offering direct support contact details, and flags it prominently on your dashboard.
                        </p>
                    </div>

                    <div class="p-5 rounded-lg bg-white border border-slate-200">
                        <h4 class="text-sm font-bold text-slate-900 mb-1.5">Can I connect this to n8n or an external webhook?</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Yes. ReviewPulse comes with an intake webhook endpoint at POST /api/reviews and a secure callback endpoint at POST /api/internal/reviews/{id}/analysis with signing secret protection. A pre-configured n8n workflow file is included in the project repository.
                        </p>
                    </div>

                    <div class="p-5 rounded-lg bg-white border border-slate-200">
                        <h4 class="text-sm font-bold text-slate-900 mb-1.5">What AI model powers the response drafts?</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            ReviewPulse is connected directly to Google Gemini 3.8 Flash for sub-second generation. It also has a built-in fallback NLP engine so your review intake never fails even if your external connection drops.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final Call to Action -->
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-4">Ready to Automate Your Review Management?</h2>
                <p class="text-slate-600 text-sm max-w-xl mx-auto mb-8">
                    Sign in to the pre-seeded demo store or register your business to test live sentiment analysis in seconds.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-3">
                    <a href="{{ route('login') }}" class="px-7 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-sm transition-colors">
                        Launch Live App Dashboard
                    </a>
                    <a href="{{ route('register') }}" class="px-7 py-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm border border-slate-200 transition-colors">
                        Create Store Account
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Clean Footer -->
    <footer class="border-t border-slate-200 py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
            <div class="flex items-center space-x-2">
                <span class="font-bold text-slate-800">ReviewPulse AI</span>
                <span>•</span>
                <span>Customer Review Management on Autopilot</span>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ route('login') }}" class="hover:text-slate-900 transition-colors">Sign In</a>
                <a href="{{ route('register') }}" class="hover:text-slate-900 transition-colors">Register</a>
                <a href="{{ route('dashboard') }}" class="hover:text-slate-900 transition-colors">Dashboard</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Sample Switcher Script -->
    <script>
        const samples = {
            critique: {
                name: 'Jane W.',
                product: 'on Wireless Headphones Pro',
                rating: '★☆☆☆☆ (1/5)',
                text: '"My headphones arrived late, and the left earbud stopped working after two days. I am disappointed with the quality."',
                sentiment: 'Negative (96% Confidence)',
                sentimentClass: 'font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded text-[11px]',
                status: 'Action Required: Flagged for Review',
                statusClass: 'text-[11px] font-semibold text-amber-800 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded',
                reply: '"We\'re truly sorry to hear about your experience, Jane. We understand how frustrating it is to receive a late delivery followed by a hardware issue. We\'d like to make this right immediately. Please reach out to our team at support@caintelectronics.com with your order number so we can arrange an expedited replacement."'
            },
            praise: {
                name: 'Liam S.',
                product: 'on Precision Mechanical Keyboard',
                rating: '★★★★★ (5/5)',
                text: '"Remarkable build quality! The tactile switches are responsive and the battery life lasts over two weeks on Bluetooth. Customer support also replied within 10 minutes."',
                sentiment: 'Positive (99% Confidence)',
                sentimentClass: 'font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded text-[11px]',
                status: 'Ready: Pre-Approved for Posting',
                statusClass: 'text-[11px] font-semibold text-emerald-800 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded',
                reply: '"Thank you so much for the stellar 5-star review, Liam! We\'re thrilled that the tactile switches and battery life are powering your setup. We appreciate your support and hope you enjoy typing every day!"'
            },
            mixed: {
                name: 'Rachel C.',
                product: 'on 4K UltraHD Streaming Webcam',
                rating: '★★★☆☆ (3/5)',
                text: '"The video sharpness is decent during bright daylight, but night calls look a bit grainy. The clip mount could also be sturdier."',
                sentiment: 'Neutral (86% Confidence)',
                sentimentClass: 'font-bold text-slate-700 bg-slate-100 border border-slate-300 px-2 py-0.5 rounded text-[11px]',
                status: 'Pending: Standard Approval',
                statusClass: 'text-[11px] font-semibold text-slate-700 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded',
                reply: '"Hi Rachel, thank you for the detailed feedback! For evening calls, enabling the low-light booster in our companion desktop app helps eliminate graininess. We have also shared your feedback regarding the mount stability with our product team!"'
            }
        };

        function selectSample(type) {
            const data = samples[type];
            document.getElementById('card-name').textContent = data.name;
            document.getElementById('card-avatar').textContent = data.name.charAt(0);
            document.getElementById('card-product').textContent = data.product;
            document.getElementById('card-rating').textContent = data.rating;
            document.getElementById('card-text').textContent = data.text;
            
            const sentEl = document.getElementById('card-sentiment');
            sentEl.textContent = data.sentiment;
            sentEl.className = data.sentimentClass;

            const statEl = document.getElementById('card-status');
            statEl.textContent = data.status;
            statEl.className = data.statusClass;

            document.getElementById('card-reply').textContent = data.reply;

            ['critique', 'praise', 'mixed'].forEach(k => {
                const b = document.getElementById('tab-' + k);
                b.className = 'px-2.5 py-1 rounded font-medium border bg-slate-100 border-transparent text-slate-600 hover:text-slate-900';
            });

            const activeBtn = document.getElementById('tab-' + type);
            activeBtn.className = 'px-2.5 py-1 rounded font-medium border bg-white border-slate-300 text-slate-900 shadow-xs';
        }
    </script>
</body>
</html>
