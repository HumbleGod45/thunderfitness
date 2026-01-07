@extends('layouts.main', ['pageTitle' => 'Login — Thunder Fitness'])

@section('content')
<section class="min-h-screen flex items-center justify-center bg-[#050816] text-white px-4">
    <div class="w-full max-w-md bg-[#0f172a] rounded-2xl
                p-6 sm:p-8
                border border-white/10
                shadow-[0_20px_60px_rgba(0,0,0,0.7)]">

        {{-- TITLE --}}
        <h1 class="text-xl sm:text-2xl font-extrabold mb-2 text-center">
            Login Thunder Fitness
        </h1>
        <p class="text-xs sm:text-sm text-gray-400 text-center mb-6">
            Masuk untuk melanjutkan ke dashboard
        </p>

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
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-3 py-2.5 rounded-lg
                           bg-[#020617] border border-gray-700
                           focus:outline-none focus:ring-2 focus:ring-emerald-500
                           text-sm text-white"
                >
            </div>

            {{-- PASSWORD --}}
            <div>
                <label for="password" class="block text-xs sm:text-sm mb-1 text-gray-300">
                    Password
                </label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        class="w-full px-3 py-2.5 pr-11 rounded-lg
                               bg-[#020617] border border-gray-700
                               focus:outline-none focus:ring-2 focus:ring-emerald-500
                               text-sm text-white"
                    >

                    {{-- TOGGLE PASSWORD --}}
                    <button type="button"
                            id="togglePassword"
                            class="absolute inset-y-0 right-3 flex items-center
                                   text-gray-400 hover:text-emerald-400 transition">

                        {{-- EYE OPEN --}}
                        <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                                     c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7
                                     -4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>

                        {{-- EYE CLOSED --}}
                        <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 hidden"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13.875 18.825A10.05 10.05 0 0112 19
                                     c-4.478 0-8.268-2.943-9.542-7
                                     a9.956 9.956 0 012.042-3.368"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6.223 6.223A9.953 9.953 0 0112 5
                                     c4.478 0 8.268 2.943 9.542 7
                                     a9.97 9.97 0 01-4.043 5.132"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- BUTTON --}}
            <button
                type="submit"
                class="w-full py-2.5 rounded-lg
                       bg-emerald-500 hover:bg-emerald-400
                       font-semibold text-sm transition">
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

{{-- SCRIPT SHOW / HIDE PASSWORD --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const password = document.getElementById('password');
    const toggle   = document.getElementById('togglePassword');
    const eyeOpen  = document.getElementById('eyeOpen');
    const eyeClose = document.getElementById('eyeClosed');

    toggle.addEventListener('click', () => {
        const hidden = password.type === 'password';

        password.type = hidden ? 'text' : 'password';
        eyeOpen.classList.toggle('hidden', hidden);
        eyeClose.classList.toggle('hidden', !hidden);
    });
});
</script>
@endsection
