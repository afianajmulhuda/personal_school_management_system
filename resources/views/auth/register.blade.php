<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School SMS - Terminal Registry</title>
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

    <div class="w-full max-w-xl">
        <!-- Brand/Logo Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 mb-3 shadow-lg shadow-emerald-500/10">
                <i class="bi bi-person-plus-fill text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Create Operator Identity</h1>
            <p class="text-slate-400 text-sm mt-1">Register new administrative node accounts</p>
        </div>

        <!-- Main Card Form Panel -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 shadow-2xl">

            <!-- Laravel Error Session Alert Box Block -->
            @if ($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-300 text-xs flex items-start gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-sm mt-0.5"></i>
                    <div>
                        <span class="font-semibold text-rose-200">Validation Failures:</span>
                        <ul class="mt-1 list-disc list-inside space-y-0.5 opacity-90">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Grid Row Box for Operators Name Context Metrics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Legal First Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required autofocus
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-600 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all text-sm font-medium"
                                placeholder="John">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Surname / Last Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-600 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all text-sm font-medium"
                                placeholder="Doe">
                        </div>
                    </div>
                </div>

                <!-- Workplace Email Address field structure layout -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Corporate Primary Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-600 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all text-sm font-medium"
                            placeholder="johndoe@school.com">
                    </div>
                </div>

                <!-- Dual columns block structure mapping security phrases securely -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Security Password Key</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password" name="password" id="passReg" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-600 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all text-sm font-medium"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Confirm Input Key</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <input type="password" name="password_confirmation" id="passRegConfirm" required
                                class="w-full pl-10 pr-4 py-2.5 bg-slate-900/50 border border-slate-700/60 rounded-xl text-slate-200 placeholder-slate-600 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all text-sm font-medium"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <!-- Terms/Privacy validation link hook component -->
                <div class="flex items-start mt-2">
                    <input type="checkbox" name="terms" id="terms" required class="mt-0.5 w-4 h-4 bg-slate-900 border-slate-700 rounded text-emerald-600 focus:ring-emerald-500/20 focus:ring-offset-0 checked:bg-emerald-600">
                    <label for="terms" class="ml-2.5 text-xs text-slate-400 select-none cursor-pointer leading-normal">
                        I confirm this terminal registration belongs to an authorized school administrator or staff member.
                    </label>
                </div>

                <!-- Account Submission Action Route Button Element -->
                <button type="submit" class="w-full mt-2 py-3 px-4 bg-emerald-600 hover:bg-emerald-500 active:bg-emerald-700 text-white font-semibold rounded-xl text-sm shadow-lg shadow-emerald-600/10 hover:shadow-emerald-500/20 transition-all transform active:scale-[0.99] flex items-center justify-center gap-2">
                    <i class="bi bi-shield-lock-fill text-sm"></i>
                    <span>Provision System Profile</span>
                </button>
            </form>

            <!-- Bottom Redirect Navigation Segment Layout Hook -->
            <div class="mt-6 pt-5 border-t border-slate-800 text-center">
                <p class="text-slate-400 text-xs font-medium">
                    Already possess an authenticated profile node? 
                    <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300 font-bold ml-1 hover:underline transition-all">Sign In</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>