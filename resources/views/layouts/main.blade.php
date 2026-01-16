<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-gray-900 flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <header class="w-full sticky top-0 z-40
                   bg-[#0A0F24]/90 backdrop-blur
                   border-b border-white/10">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <img
                    src="{{ asset('images/thunder.png') }}"
                    alt="Logo Thunder Fitness"
                    class="h-10 drop-shadow-[0_0_6px_rgba(250,204,21,0.6)]"
                >
                <span class="font-semibold text-white text-lg hidden sm:inline">
                    Thunder Fitness
                </span>
            </a>

            @php
                $navLink = 'hover:text-emerald-400 transition';
                $active  = 'text-emerald-400 font-semibold';
            @endphp

            {{-- Menu desktop --}}
            <nav class="hidden md:flex items-center gap-10 text-white/80 font-medium">
                <a href="/" class="{{ request()->is('/') ? $active : '' }} {{ $navLink }}">Home</a>
                <a href="/pricelist" class="{{ request()->is('pricelist') ? $active : '' }} {{ $navLink }}">Pricelist</a>
                <a href="/trainer" class="{{ request()->is('trainer') ? $active : '' }} {{ $navLink }}">Personal Trainer</a>
                <a href="/about" class="{{ request()->is('about') ? $active : '' }} {{ $navLink }}">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/login"
                   class="hidden md:inline-flex px-5 py-2 rounded-full
                          bg-emerald-500 text-white text-sm font-medium
                          hover:bg-emerald-400 transition">
                    Login
                </a>

                {{-- Burger --}}
                <button id="navToggle"
                        class="md:hidden inline-flex items-center justify-center
                               h-9 w-9 rounded-full
                               bg-white/10 hover:bg-white/20 transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 text-white"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <nav id="mobileNav"
             class="md:hidden hidden
                    border-t border-white/10
                    bg-[#0A0F24]/95 backdrop-blur
                    text-sm font-medium">
            <div class="max-w-7xl mx-auto px-4 py-4 space-y-3">
                <a href="/"
                   class="block {{ request()->is('/') ? 'text-emerald-400 font-semibold' : 'text-white/80 hover:text-emerald-400' }}">
                    Home
                </a>
                <a href="/pricelist"
                   class="block {{ request()->is('pricelist') ? 'text-emerald-400 font-semibold' : 'text-white/80 hover:text-emerald-400' }}">
                    Pricelist
                </a>
                <a href="/trainer"
                   class="block {{ request()->is('trainer') ? 'text-emerald-400 font-semibold' : 'text-white/80 hover:text-emerald-400' }}">
                    Personal Trainer
                </a>
                <a href="/about"
                   class="block {{ request()->is('about') ? 'text-emerald-400 font-semibold' : 'text-white/80 hover:text-emerald-400' }}">
                    Tentang Kami
                </a>
                <a href="/login"
                   class="block text-white/80 hover:text-emerald-400">
                    Login
                </a>
            </div>
        </nav>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#050816] text-gray-400">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-5
                    flex flex-col md:flex-row
                    items-center justify-between gap-2 text-sm">
            <p class="text-center md:text-left">
                © 2026 Thunder Fitness. All rights reserved
            </p>
            <p class="text-center md:text-right">
                Developed by <span class="text-emerald-400 font-medium">AFS</span>
            </p>
        </div>
    </footer>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('navToggle');
            const mobileNav = document.getElementById('mobileNav');

            toggle?.addEventListener('click', () => {
                mobileNav.classList.toggle('hidden');
            });
        });
    </script>

</body>
</html>
