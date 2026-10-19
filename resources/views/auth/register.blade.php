<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Account - ReviewPulse AI</title>
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
            <h1 class="text-2xl font-extrabold text-white tracking-tight">Create Store Account</h1>
            <p class="text-sm text-slate-400 mt-1">Get started with ReviewPulse AI in 30 seconds</p>
        </div>

        <!-- Auth Card -->
        <div class="bg-slate-900/80 border border-slate-800/80 backdrop-blur-xl rounded-2xl p-7 shadow-2xl">
            @if($errors->any())
                <div class="p-3 mb-5 rounded-xl bg-rose-950/60 border border-rose-500/30 text-rose-300 text-xs">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Alex Morgan"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Store / Brand Name</label>
                    <input type="text" name="store_name" value="{{ old('store_name') }}" required placeholder="e.g. Apex Tech Supply"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Email address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="alex@company.com"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Password</label>
                    <input type="password" name="password" required placeholder="Minimum 8 characters"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1.5">Confirm Password</label>
                    <input type="password" name="password_confirmation" required placeholder="Re-type password"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800/90 border border-slate-700/80 text-sm text-white focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <button type="submit" 
                        class="w-full py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white font-semibold text-sm shadow-lg shadow-indigo-500/25 transition cursor-pointer">
                    Create Account & Launch Store
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-800/80 text-center">
                <p class="text-xs text-slate-400">
                    Already registered? 
                    <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300 font-medium">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
