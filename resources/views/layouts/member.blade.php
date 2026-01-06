<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Member — Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="bg-[#050816] text-white">

    @php
        $user = auth()->user();
        $memberName = optional($user?->member)->nama ?? 'Member';
        $initial = strtoupper(mb_substr($memberName, 0, 1));
    @endphp

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
                    Dashboard Member
                </span>
                <div class="h-8 w-8 rounded-full bg-violet-200 flex items-center justify-center">
                    <span class="text-violet-700 text-sm font-semibold">
                        {{ $initial }}
                    </span>
                </div>
            </div>
        </div>
    </header>

    {{-- LAYOUT MEMBER --}}
    <main class="min-h-[calc(100vh-64px)] bg-[#050816]">
        <div class="flex w-full">

            {{-- SIDEBAR --}}
            <aside id="memberSidebar"
                   class="
                        fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                        bg-[#0A0F24] border-r border-white/10
                        transition-transform duration-300 ease-in-out
                        z-30
                        -translate-x-full
                   ">

                {{-- Profil / header sidebar --}}
                <div class="flex flex-col items-center py-8 border-b border-white/10">
                    <div class="w-20 h-20 rounded-full overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.5)] bg-emerald-500/20 flex items-center justify-center">
                        @if (!empty(auth()->user()->member?->foto))
                            <img src="{{ asset('storage/' . auth()->user()->member->foto) }}"
                                alt="Foto Member"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/member.png') }}"
                                alt="Member"
                                class="w-full h-full object-cover">
                        @endif
                    </div>
                    <p class="mt-3 text-xs font-semibold tracking-[0.1em] text-emerald-400 uppercase text-center">
                        {{ $memberName }}
                    </p>
                </div>

                {{-- MENU SIDEBAR --}}
                <nav class="px-5 py-6 space-y-2 text-sm font-medium text-gray-300">
                    <a href="/member/home"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('member/home*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        HOME
                    </a>
                    <a href="/member/workouts/create"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('member/workouts/create*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        LATIHAN
                    </a>
                    <a href="/member/profile"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('member/profile*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        PROFILE
                    </a>
                    <a href="/member/workouts/history"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('member/workouts/history*')
                            ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                            : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        HISTORY
                    </a>

                    <hr class="border-white/10 my-4">

                    {{-- Logout pakai POST --}}
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
            <section id="memberContent"
                     class="flex-1 px-4 md:px-8 py-8 w-full transition-all duration-300">

                {{-- Tombol hamburger --}}
                <button id="memberSidebarToggle"
                        class="inline-flex items-center justify-center mb-6 h-9 w-9 rounded-full
                               bg-white/10 hover:bg-white/20 border border-white/10">
                    <span class="sr-only">Toggle sidebar member</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                </button>

                @yield('content')
            </section>
        </div>
    </main>

    {{-- SCRIPT TOGGLE SIDEBAR --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('memberSidebar');
            const toggle  = document.getElementById('memberSidebarToggle');
            const content = document.getElementById('memberContent');

            if (!sidebar || !toggle || !content) return;

            const isMobile = () => window.innerWidth < 1024;

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                content.classList.add('lg:ml-64');
            };

            const closeSidebar = () => {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                content.classList.remove('lg:ml-64');
            };

            // state awal
            if (isMobile()) {
                closeSidebar();  
            } else {
                openSidebar();     
            }

            toggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', () => {
                if (isMobile()) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        });
    </script>
</body>
</html>
