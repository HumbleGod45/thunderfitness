<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-gray-900">

    {{-- NAVBAR --}}
    <header class="w-full bg-[#e9ed81] shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4">

            {{-- Logo + nama --}}
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/thunder.png') }}" alt="Logo Thunder Fitness" class="h-10">
                <span class="font-semibold text-gray-800 text-lg hidden sm:inline">
                    Thunder Fitness
                </span>
            </a>

            {{-- Menu desktop --}}
            @php
                $navLink = 'hover:text-emerald-600 transition';
                $active  = 'text-emerald-600 font-semibold';
            @endphp
            <nav class="hidden md:flex items-center gap-10 text-gray-900 font-medium">
                <a href="/" class="{{ request()->is('/') ? $active : '' }} {{ $navLink }}">
                    Home
                </a>
                <a href="/pricelist" class="{{ request()->is('pricelist') ? $active : '' }} {{ $navLink }}">
                    Pricelist
                </a>
                <a href="/trainer" class="{{ request()->is('trainer') ? $active : '' }} {{ $navLink }}">
                    Personal Trainer
                </a>
                <a href="/about" class="{{ request()->is('about') ? $active : '' }} {{ $navLink }}">
                    Tentang Kami
                </a>
            </nav>

            <div class="flex items-center gap-3">
                {{-- Tombol login desktop --}}
                <a href="/login"
                   class="hidden md:inline-flex px-5 py-2 rounded-full bg-white/80 text-gray-900 text-sm font-medium hover:bg-white transition">
                    Login
                </a>

                {{-- Tombol burger mobile --}}
                <button id="navToggle"
                        class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-full bg-white/80">
                    <span class="sr-only">Toggle navigation</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Menu mobile --}}
        <nav id="mobileNav"
             class="md:hidden hidden border-t border-yellow-200 bg-[#f2f4a1] text-sm font-medium">
            <div class="max-w-7xl mx-auto px-4 py-3 space-y-2">
                <a href="/" class="block {{ request()->is('/') ? 'text-emerald-700 font-semibold' : 'text-gray-900' }}">
                    Home
                </a>
                <a href="/pricelist" class="block {{ request()->is('pricelist') ? 'text-emerald-700 font-semibold' : 'text-gray-900' }}">
                    Pricelist
                </a>
                <a href="/trainer" class="block {{ request()->is('trainer') ? 'text-emerald-700 font-semibold' : 'text-gray-900' }}">
                    Personal Trainer
                </a>
                <a href="/about" class="block {{ request()->is('about') ? 'text-emerald-700 font-semibold' : 'text-gray-900' }}">
                    Tentang Kami
                </a>
                <a href="/login" class="block text-gray-900">
                    Login
                </a>
            </div>
        </nav>
    </header>

    {{-- WRAPPER KONTEN --}}
    <main class="min-h-screen">
        @yield('content')
    </main>
        {{-- FOOTER --}}
    <footer class="w-full bg-[#050816] text-gray-400">
        <div class="max-w-7xl mx-auto px-4 md:px-6 py-6
                    flex flex-col md:flex-row items-center justify-between gap-3 text-sm">

            <p class="text-center md:text-left">
                © 2026 Thunder Fitness. All rights reserved
            </p>

            <p class="text-center md:text-right">
                Developed by <span class="text-emerald-400 font-medium">AFS</span>
            </p>

        </div>
    </footer>

    {{-- Script toggle menu mobile --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.getElementById('navToggle');
            const mobileNav = document.getElementById('mobileNav');

            if (toggle && mobileNav) {
                toggle.addEventListener('click', () => {
                    mobileNav.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
