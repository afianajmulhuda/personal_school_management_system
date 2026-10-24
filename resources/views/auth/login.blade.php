<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School SMS - Portal Login</title>
    <!-- Tailwind CSS & Bootstrap Icons -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #311042 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased">

    <div class="w-full max-w-md">
        <!-- Brand/Logo Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600/20 border border-indigo-500/30 text-indigo-400 mb-3 shadow-lg shadow-indigo-500/10">
                <i class="bi bi-mortarboard-fill text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Welcome Back</h1>
            <p class="text-slate-400 text-sm mt-1">School Management Subsystem</p>
        </div>

        <!-- Main Card Form -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 shadow-2xl">
            
            <!-- Laravel Error Session Alert Box Block -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-300 text-xs flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-sm mt-0.5"></i>
                    <div>
                        <span class="font-semibold text-rose-200">System Error Logged:</span>
                        <ul class="mt-1 list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email Input Field Container -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Workspace Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-10 pr-4 py-3 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all font-medium text-sm"
                            placeholder="name@school.com">
                    </div>
                </div>

                <!-- Password Input Field Container -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider">Security Access Key</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-indigo-400 hover:text-indigo-300 hover:underline transition-all">Forgot Pass?</a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" id="passwordInput" required
                            class="w-full pl-10 pr-11 py-3 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all font-medium text-sm"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('passwordInput', 'toggleIcon')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-200 transition-all">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me Checkbox Subsystem -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 bg-slate-900 border-slate-700 rounded text-indigo-600 focus:ring-indigo-500/20 focus:ring-offset-0 bg-slate-800 checked:bg-indigo-600">
                    <label for="remember" class="ml-2.5 text-xs font-medium text-slate-400 select-none cursor-pointer">Keep my terminal authenticated</label>
                </div>

                <!-- Submission Authentication CTA Button -->
                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 active:bg-indigo-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-indigo-600/20 hover:shadow-indigo-500/30 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2">
                    <span>Authenticate Account</span>
                    <i class="bi bi-arrow-right-short text-lg"></i>
                </button>
            </form>

            <!-- Bottom Redirect Navigation Segment -->
            <div class="mt-6 pt-6 border-t border-slate-800 text-center">
                <p class="text-slate-400 text-xs font-medium">
                    New operator requiring portal access? 
                    <a href="{{ route('register') }}" class="text-indigo-400 hover:text-indigo-300 font-bold ml-1 hover:underline transition-all">Register Terminal</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Password visibility verification utility logic -->
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }
    </script>
</body>
</html>