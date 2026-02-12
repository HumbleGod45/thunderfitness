@extends('layouts.main', ['pageTitle' => 'Login — Thunder Fitness'])

@section('content')
<section class="min-h-screen flex items-center justify-center bg-[#050816] text-white px-4">
    <div class="w-full max-w-md bg-[#0f172a] rounded-2xl p-6 sm:p-8 border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.7)]">

        {{-- TITLE --}}
        <h1 class="text-xl sm:text-2xl font-extrabold mb-2 text-center">
            Login Thunder Fitness
        </h1>
        <p class="text-xs sm:text-sm text-gray-400 text-center mb-6">
            Masuk untuk melanjutkan ke dashboard
        </p>

        {{-- STATUS / SUCCESS MESSAGES --}}
        @if (session('status'))
            <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500/20 px-4 py-3 text-xs text-emerald-400">
                {{ session('status') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500/20 px-4 py-3 text-xs sm:text-sm text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('login.post') }}" method="POST" class="space-y-4 sm:space-y-5">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label for="email" class="block text-xs sm:text-sm mb-1 text-gray-300">
                    Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm text-white">
            </div>

            {{-- PASSWORD --}}
            <div>
                <div class="flex justify-between items-center mb-1">
                    <label for="password" class="block text-xs sm:text-sm text-gray-300">
                        Password
                    </label>
                    {{-- LINK FORGOT PASSWORD (TRIGGER MODAL) --}}
                    <button type="button" id="openForgotModal" class="text-[10px] sm:text-xs text-emerald-400 hover:text-emerald-300 hover:underline">
                        Lupa Password?
                    </button>
                </div>

                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2.5 pr-11 rounded-lg bg-[#020617] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm text-white">

                    {{-- TOGGLE PASSWORD --}}
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-emerald-400 transition">
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.223 6.223A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.043 5.132" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BUTTON --}}
            <button type="submit" class="w-full py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400 font-semibold text-sm transition">
                Login
            </button>
        </form>

        {{-- REGISTER --}}
        <p class="mt-5 text-center text-xs text-gray-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-emerald-400 hover:underline">
                Daftar sebagai member
            </a>
        </p>
    </div>
</section>

{{-- MODAL FORGOT PASSWORD --}}
<div id="forgotPasswordModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
    <div class="bg-[#0f172a] rounded-2xl border border-white/10 w-full max-w-sm relative shadow-2xl">
        <div class="p-6 border-b border-white/5 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white">Reset Password</h3>
            <button id="closeForgotModal" class="text-gray-400 hover:text-white transition">✕</button>
        </div>

        <div class="p-6">
            <form action="{{ route('password.update.simple') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Email Terdaftar</label>
                    <input type="email" name="email" required placeholder="nama@email.com"
                        class="w-full px-4 py-2.5 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                </div>

                {{-- Password Baru dengan Eye Button --}}
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Password Baru</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="password" required
                            class="w-full px-4 py-2.5 pr-11 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-emerald-400 transition toggle-password-btn" data-target="new_password">
                            <svg class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="h-5 w-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.223 6.223A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.043 5.132" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Konfirmasi Password Baru dengan Eye Button --}}
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" id="new_password_confirmation" name="password_confirmation" required
                            class="w-full px-4 py-2.5 pr-11 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                        <button type="button" class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-emerald-400 transition toggle-password-btn" data-target="new_password_confirmation">
                            <svg class="h-5 w-5 eye-open" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg class="h-5 w-5 eye-closed hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.042-3.368" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.223 6.223A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.043 5.132" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-bold transition-all shadow-lg">
                    Update Password
                </button>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const togglePasswordButtons = document.querySelectorAll('#togglePassword, .toggle-password-btn');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target') || 'password';
            const passwordInput = document.getElementById(targetId);
            const eyeOpen = this.querySelector('#eyeOpen, .eye-open');
            const eyeClose = this.querySelector('#eyeClosed, .eye-closed');
            const isHidden = passwordInput.type === 'password';
            
            passwordInput.type = isHidden ? 'text' : 'password';
            
            if (eyeOpen && eyeClose) {
                eyeOpen.classList.toggle('hidden', isHidden);
                eyeClose.classList.toggle('hidden', !isHidden);
            }
        });
    });

    // 2. MODAL FORGOT PASSWORD (OPEN/CLOSE LOGIC)
    const forgotModal = document.getElementById('forgotPasswordModal');
    const openForgotBtn = document.getElementById('openForgotModal');
    const closeForgotBtn = document.getElementById('closeForgotModal');

    const toggleForgotModal = () => {
        if (forgotModal) forgotModal.classList.toggle('hidden');
    };

    if (openForgotBtn) openForgotBtn.addEventListener('click', toggleForgotModal);
    if (closeForgotBtn) closeForgotBtn.addEventListener('click', toggleForgotModal);

    // Close modal on outside click
    window.addEventListener('click', (e) => {
        if (e.target === forgotModal) toggleForgotModal();
    });
});
</script>
@endsection