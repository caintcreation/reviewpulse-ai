<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ReviewPulse AI') - AI Review Intelligence & Auto-Reply</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                            mono: ['"JetBrains Mono"', 'monospace'],
                        },
                        colors: {
                            brand: {
                                50: '#eef2ff',
                                100: '#e0e7ff',
                                400: '#818cf8',
                                500: '#6366f1',
                                600: '#4f46e5',
                                700: '#4338ca',
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex flex-col md:flex-row bg-slate-950 text-slate-200 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Mobile Top Navigation Header -->
    <div class="md:hidden flex items-center justify-between border-b border-slate-800 bg-slate-900/90 px-4 py-3 backdrop-blur-md sticky top-0 z-40">
        <div class="flex items-center space-x-2.5">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-400 flex items-center justify-center shadow-lg shadow-indigo-500/20 text-white font-black text-sm">
                RP
            </div>
            <span class="font-bold text-slate-100 tracking-tight text-base">ReviewPulse <span class="text-indigo-400 font-extrabold text-xs uppercase px-1.5 py-0.5 rounded bg-indigo-950/80 border border-indigo-500/30">AI</span></span>
        </div>
        <button type="button" onclick="document.getElementById('sidebar-menu').classList.toggle('hidden')" class="p-2 text-slate-400 hover:text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar-menu" class="hidden md:flex flex-col w-full md:w-64 lg:w-72 border-r border-slate-800/80 bg-slate-900/70 backdrop-blur-xl shrink-0 z-30 transition-all">
        <!-- Brand / Logo Area -->
        <div class="p-6 border-b border-slate-800/60">
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-400 flex items-center justify-center shadow-lg shadow-indigo-500/30 text-white font-black text-lg transition-transform group-hover:scale-105">
                        RP
                    </div>
                    <div>
                        <div class="flex items-center space-x-1.5">
                            <span class="font-extrabold text-white tracking-tight text-lg">ReviewPulse</span>
                            <span class="text-[10px] font-black uppercase tracking-wider text-indigo-300 bg-indigo-500/10 border border-indigo-500/30 px-1.5 py-0.5 rounded">AI</span>
                        </div>
                        <p class="text-xs text-slate-400 font-medium">Auto-pilot review workspace</p>
                    </div>
                </a>
            </div>

            <!-- Active Store Pill -->
            <div class="mt-4 p-2.5 rounded-xl bg-slate-800/60 border border-slate-700/60 flex items-center justify-between">
                <div class="flex items-center space-x-2.5 min-w-0">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shrink-0"></div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-slate-200 truncate">{{ $store->name ?? 'Caint Electronics' }}</p>
                        <p class="text-[10px] text-slate-400 font-mono truncate">{{ $store->platform_store_id ?? 'caint-electronics-us' }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-semibold text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-2 py-0.5 rounded-full">Live</span>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
            <div class="px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Main Menu</div>

            <a href="{{ route('dashboard') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 shadow-sm' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/40' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-indigo-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Overview</span>
                </div>
            </a>

            <a href="{{ route('reviews.index') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('reviews.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 shadow-sm' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/40' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('reviews.*') ? 'text-indigo-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    <span>Reviews Inbox</span>
                </div>
                @php
                    $pendingCount = \App\Models\Review::whereIn('review_status', ['unread', 'needs_review'])->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="text-xs px-2 py-0.5 rounded-full font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('automation.index') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('automation.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 shadow-sm' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/40' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('automation.*') ? 'text-indigo-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>Automation & Logs</span>
                </div>
            </a>

            <div class="pt-4 px-3 pb-2 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Configuration</div>

            <a href="{{ route('settings.index') }}" 
               class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('settings.*') ? 'bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 shadow-sm' : 'text-slate-400 hover:text-slate-100 hover:bg-slate-800/40' }}">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 {{ request()->routeIs('settings.*') ? 'text-indigo-400' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Store Settings</span>
                </div>
            </a>
        </nav>

        <!-- Quick Intake Action Button in Sidebar -->
        <div class="p-4 border-t border-slate-800/60">
            <button onclick="document.getElementById('intakeModal').classList.remove('hidden')" 
                    class="w-full flex items-center justify-center space-x-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-sm shadow-lg shadow-indigo-500/25 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Simulate New Review</span>
            </button>
        </div>

        <!-- User Profile Footer -->
        <div class="p-4 border-t border-slate-800/80 bg-slate-900/40 flex items-center justify-between">
            <div class="flex items-center space-x-3 min-w-0">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-cyan-500 flex items-center justify-center font-bold text-white text-xs shrink-0 shadow-md">
                    {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-slate-200 truncate">{{ Auth::user()->name ?? 'Guest User' }}</p>
                    <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" title="Sign out" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800/60 rounded-lg transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
        <!-- Top App Bar -->
        <header class="h-16 border-b border-slate-800/80 bg-slate-900/40 backdrop-blur-md px-6 flex items-center justify-between shrink-0 sticky top-0 z-20">
            <div class="flex items-center space-x-4">
                <h1 class="text-lg font-bold text-white tracking-tight">@yield('page_title', 'Dashboard')</h1>
                <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-400 font-mono bg-slate-800/60 px-2.5 py-1 rounded-md border border-slate-700/60">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
                    <span>Demo Mode Active</span>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                <button onclick="document.getElementById('intakeModal').classList.remove('hidden')" 
                        class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-xs transition shadow-md shadow-indigo-600/20 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="hidden sm:inline">Add Demo Review</span>
                    <span class="sm:hidden">Add</span>
                </button>
            </div>
        </header>

        <!-- Flash Notifications -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="p-4 mb-4 rounded-xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-200 text-sm flex items-center justify-between shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white">&times;</button>
                </div>
            @endif

            @if(session('info'))
                <div class="p-4 mb-4 rounded-xl bg-indigo-950/60 border border-indigo-500/40 text-indigo-200 text-sm flex items-center justify-between shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-indigo-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        <span>{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-indigo-400 hover:text-white">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="p-4 mb-4 rounded-xl bg-rose-950/60 border border-rose-500/40 text-rose-200 text-sm shadow-lg">
                    <div class="flex items-center space-x-2 font-semibold text-rose-300 mb-1">
                        <svg class="w-5 h-5 text-rose-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        <span>Please correct the errors below:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-1 text-rose-300">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Main Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>

    <!-- Modal: Simulate/Add Review -->
    <div id="intakeModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
        <div class="bg-slate-900 border border-slate-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl relative">
            <button onclick="document.getElementById('intakeModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white text-xl cursor-pointer">&times;</button>
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Intake Customer Review</h3>
                    <p class="text-xs text-slate-400">Simulate incoming review from Google, Shopify, or Trustpilot</p>
                </div>
            </div>

            <!-- Pre-load demo presets -->
            <div class="mb-4 p-2.5 rounded-xl bg-slate-800/40 border border-slate-700/50 flex items-center justify-between text-xs">
                <span class="text-slate-400">Quick Fill Example:</span>
                <div class="flex space-x-2">
                    <button type="button" onclick="fillExample('negative')" class="px-2 py-1 rounded bg-rose-950 text-rose-300 border border-rose-800 hover:bg-rose-900 cursor-pointer">1★ Complaint</button>
                    <button type="button" onclick="fillExample('positive')" class="px-2 py-1 rounded bg-emerald-950 text-emerald-300 border border-emerald-800 hover:bg-emerald-900 cursor-pointer">5★ Praise</button>
                    <button type="button" onclick="fillExample('neutral')" class="px-2 py-1 rounded bg-amber-950 text-amber-300 border border-amber-800 hover:bg-amber-900 cursor-pointer">3★ Mixed</button>
                </div>
            </div>

            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Customer Name</label>
                        <input type="text" id="modal_reviewer_name" name="reviewer_name" required placeholder="e.g. Jane W." 
                               class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Product / Service</label>
                        <input type="text" id="modal_product_name" name="product_name" placeholder="e.g. Wireless Headphones" 
                               class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Star Rating (1 - 5)</label>
                        <select id="modal_rating" name="rating" required class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                            <option value="5">★★★★★ (5 Stars - Excellent)</option>
                            <option value="4">★★★★☆ (4 Stars - Good)</option>
                            <option value="3">★★★☆☆ (3 Stars - Average)</option>
                            <option value="2">★★☆☆☆ (2 Stars - Poor)</option>
                            <option value="1">★☆☆☆☆ (1 Star - Terrible)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Review Channel</label>
                        <select name="source" class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500">
                            <option value="google">Google Reviews</option>
                            <option value="shopify">Shopify Store</option>
                            <option value="trustpilot">Trustpilot</option>
                            <option value="demo">Direct Demo API</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Customer Review Text</label>
                    <textarea id="modal_review_text" name="review_text" rows="3" required placeholder="Paste customer feedback here..."
                              class="w-full px-3 py-2 rounded-xl bg-slate-800 border border-slate-700 text-sm text-white focus:outline-none focus:border-indigo-500"></textarea>
                </div>

                <div class="pt-2 flex items-center justify-end space-x-3">
                    <button type="button" onclick="document.getElementById('intakeModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm font-medium cursor-pointer">Cancel</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-sm shadow-lg shadow-indigo-500/20 cursor-pointer">
                        Intake & Analyze Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fillExample(type) {
            if (type === 'negative') {
                document.getElementById('modal_reviewer_name').value = 'Jane W.';
                document.getElementById('modal_product_name').value = 'Wireless Headphones';
                document.getElementById('modal_rating').value = '1';
                document.getElementById('modal_review_text').value = 'My headphones arrived late, and the left earbud stopped working after two days. I\'m disappointed with the quality.';
            } else if (type === 'positive') {
                document.getElementById('modal_reviewer_name').value = 'Liam S.';
                document.getElementById('modal_product_name').value = 'Precision Mechanical Keyboard';
                document.getElementById('modal_rating').value = '5';
                document.getElementById('modal_review_text').value = 'Remarkable build quality! The tactile switches are responsive and the battery life lasts over two weeks on Bluetooth. Customer support also replied within 10 minutes.';
            } else {
                document.getElementById('modal_reviewer_name').value = 'Rachel C.';
                document.getElementById('modal_product_name').value = '4K UltraHD Webcam';
                document.getElementById('modal_rating').value = '3';
                document.getElementById('modal_review_text').value = 'The video sharpness is decent during bright daylight, but night calls look a bit grainy. The clip mount could also be sturdier.';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>
