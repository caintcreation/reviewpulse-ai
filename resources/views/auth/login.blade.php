<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - ReviewPulse AI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-indigo-950/40 via-slate-950 to-slate-950 text-slate-200">

    <div class="w-full max-w-md">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-violet-400 items-center justify-center shadow-xl shadow-indigo-500/25 text-white font-black text-2xl mb-4">
                RP
            </div>
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Sign in to ReviewPulse <span class="text-indigo-400 font-black text-xs uppercase px-1.5 py-0.5 rounded bg-indigo-950/80 border border-indigo-500/30">AI</span></h1>
            <p class="text-sm text-slate-400 mt-1">Autonomous Customer Review Intelligence & Replies</p>
        </div>

        <!-- Auth Card -->
        <div class="bg-slate-900/80 border border-slate-800/80 backdrop-blur-xl rounded-2xl p-7 shadow-2xl">
            @if(session('info'))
                <div class="p-3 mb-5 rounded-xl bg-indigo-950/60 border border-indigo-500/30 text-indigo-300 text-xs">
                    {{ session('info') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 mb-5 rounded-xl bg-rose-950/60 border border-rose-500/30 text-rose-300 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'demo@reviewpulse.test') }}" required autofocus
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-xs font-semibold text-slate-300">Password</label>
                        <button type="button" onclick="togglePasswordVisibility()" class="text-xs text-indigo-400 hover:text-indigo-300 cursor-pointer">
                            <span id="toggleText">Show</span>
                        </button>
                    </div>
                    <input type="password" id="password" name="password" value="password" required
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 text-slate-400 cursor-pointer">
                        <input type="checkbox" name="remember" checked class="rounded bg-slate-800 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                        <span>Remember me</span>
                    </label>
                    <span class="text-slate-500">Demo Password: <code class="text-indigo-300 font-mono">password</code></span>
                </div>

                <button type="submit" 
                        class="w-full py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-sm shadow-lg shadow-indigo-500/25 transition cursor-pointer">
                    Sign In to Dashboard
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-800/80 text-center">
                <p class="text-xs text-slate-400">
                    Need a new store account? 
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Create one now</a>
                </p>
            </div>
        </div>

        <!-- Demo Quick Sign-in Note -->
        <div class="mt-4 p-3 rounded-xl bg-slate-900/40 border border-slate-800/50 text-center text-xs text-slate-400">
            Pre-seeded with Caint Electronics store & 10 real demonstration reviews.
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwd = document.getElementById('password');
            const txt = document.getElementById('toggleText');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                txt.textContent = 'Hide';
            } else {
                pwd.type = 'password';
                txt.textContent = 'Show';
            }
        }
    </script>
</body>
</html>
