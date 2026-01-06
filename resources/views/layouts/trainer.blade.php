<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Trainer — Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-[#050816] text-white">

    {{-- NAVBAR / HEADER --}}
    <header class="w-full bg-[#e9ed81] shadow-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4">
            <a href="/" class="flex items-center gap-3">
                <img src="{{ asset('images/thunder.png') }}" alt="Logo Thunder Fitness" class="h-10">
                <span class="font-semibold text-gray-800 text-lg hidden sm:inline">
                    Thunder Fitness
                </span>
            </a>

            @php $navLink = 'hover:text-emerald-600 transition'; @endphp

            <nav class="hidden md:flex items-center gap-8 text-gray-900 font-medium">
                <a href="/"          class="{{ request()->is('/') ? 'text-emerald-600' : '' }} {{ $navLink }}">Home</a>
                <a href="/pricelist" class="{{ request()->is('pricelist') ? 'text-emerald-600' : '' }} {{ $navLink }}">Pricelist</a>
                <a href="/trainer"   class="{{ request()->is('trainer') ? 'text-emerald-600' : '' }} {{ $navLink }}">Personal Trainer</a>
                <a href="/about"     class="{{ request()->is('about') ? 'text-emerald-600' : '' }} {{ $navLink }}">Tentang Kami</a>
            </nav>

            <div class="flex items-center gap-3">
                <span class="hidden md:inline text-sm font-semibold text-gray-800">
                    Dashboard Trainer
                </span>
                <div class="h-8 w-8 rounded-full bg-violet-200 flex items-center justify-center">
                    <span class="text-violet-700 text-sm font-semibold">👤</span>
                </div>
            </div>
        </div>
    </header>

    {{-- LAYOUT TRAINER --}}
    <main class="min-h-[calc(100vh-64px)] bg-[#050816]">
        <div class="flex">

            {{-- SIDEBAR --}}
            <aside id="trainerSidebar"
                   class="fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                          bg-[#0A0F24] border-r border-white/10
                          transform transition-transform duration-300 ease-in-out
                          translate-x-0">

                {{-- Profil / header sidebar --}}
                @php
                    $trainer = auth()->user()->trainer;
                @endphp

                <div class="flex flex-col items-center py-8 border-b border-white/10">

                    {{-- FOTO TRAINER --}}
                    <div
                        class="w-20 h-20 rounded-full overflow-hidden
                            shadow-[0_0_20px_rgba(16,185,129,0.5)] bg-emerald-500/20 flex items-center justify-center">
                        <img
                            src="{{ $trainer && $trainer->foto
                                ? asset('storage/' . $trainer->foto)
                                : asset('images/trainer-default.png') }}"
                            alt="{{ $trainer->nama ?? 'Trainer' }}"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- NAMA TRAINER --}}
                    <p class="mt-3 text-sm font-semibold text-white">
                        {{ $trainer->nama ?? 'Trainer' }}
                    </p>
                    {{-- ROLE --}}
                    <p class="mt-1 text-xs font-semibold tracking-[0.2em] text-emerald-400">
                        TRAINER
                    </p>
                </div>


                {{-- MENU SIDEBAR --}}
                <nav class="px-5 py-6 space-y-2 text-sm font-medium text-gray-300">
                    <a href="/trainer/home"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('trainer/members*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        MEMBER
                    </a>
                    <a href="/trainer/latihan"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('trainer/latihan*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        LATIHAN
                    </a>
                    <a href="/trainer/profile"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('trainer/profile*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        PROFILE
                    </a>
                    <a href="/trainer/tbd"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('trainer/tbd*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        TBD
                    </a>

                    <hr class="border-white/10 my-4">

                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="w-full text-left block px-4 py-2 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300">
                            KELUAR
                        </button>
                    </form>
                </nav>
            </aside>

            {{-- KONTEN UTAMA --}}
            <section id="trainerContent"
                     class="flex-1 ml-64 px-4 md:px-8 py-8 transition-[margin-left] duration-300 ease-in-out w-full">

                {{-- Tombol hamburger --}}
                <button id="trainerSidebarToggle"
                        class="inline-flex items-center justify-center mb-6 h-9 w-9 rounded-full
                               bg-white/10 hover:bg-white/20 border border-white/10">
                    <span class="sr-only">Toggle sidebar trainer</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                </button>

                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </section>
        </div>
    </main>

    {{-- SCRIPT TOGGLE SIDEBAR --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const trainerSidebar  = document.getElementById('trainerSidebar');
            const trainerToggle   = document.getElementById('trainerSidebarToggle');
            const trainerContent  = document.getElementById('trainerContent');

            if (!trainerSidebar || !trainerToggle || !trainerContent) return;

            const isMobile = () => window.innerWidth < 1024;

            const openSidebar = () => {
                trainerSidebar.classList.remove('-translate-x-full');
                trainerSidebar.classList.add('translate-x-0');
                trainerContent.classList.add('ml-64');
            };

            const closeSidebar = () => {
                trainerSidebar.classList.remove('translate-x-0');
                trainerSidebar.classList.add('-translate-x-full');
                trainerContent.classList.remove('ml-64');
            };

            const applyInitial = () => {
                if (isMobile()) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            };

            applyInitial();

            trainerToggle.addEventListener('click', () => {
                if (trainerSidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', applyInitial);
        });
    </script>
</body>
</html>
