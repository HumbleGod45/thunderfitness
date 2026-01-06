<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin — Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#050816] text-white overflow-x-hidden">

    {{-- NAVBAR --}}
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
                    Dashboard Admin
                </span>
                {{-- Logout pakai POST --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-full bg-white/80 text-gray-900 text-sm font-semibold hover:bg-white transition">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- LAYOUT ADMIN --}}
    <main class="min-h-[calc(100vh-64px)] bg-[#050816]">
        <div class="max-w-7xl mx-auto relative">

            {{-- overlay (mobile) --}}
            <div id="adminOverlay"
                 class="fixed inset-x-0 bottom-0 top-[64px] md:top-[72px] bg-black/50 z-30 hidden"></div>

            {{-- SIDEBAR --}}
            <aside id="adminSidebar"
                   class="
                        bg-[#0A0F24] border-r border-white/10
                        transition-transform duration-300 ease-in-out
                        z-40 transform

                        fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                        -translate-x-full
                   ">

                {{-- Profil admin --}}
                <div class="flex flex-col items-center py-8 border-b border-white/10">
                    <div class="w-20 h-20 rounded-full overflow-hidden shadow-[0_0_20px_rgba(16,185,129,0.5)] bg-emerald-500/20 flex items-center justify-center">
                        <img src="{{ asset('images/member.png') }}" alt="Admin" class="w-full h-full object-cover">
                    </div>
                    <p class="mt-3 text-xs font-semibold tracking-[0.2em] text-emerald-400">
                        ADMIN PANEL
                    </p>
                </div>

                {{-- MENU --}}
                <nav class="px-5 py-6 space-y-2 text-sm font-medium text-gray-300">
                    {{-- MEMBER (halaman utama admin) --}}
                    <a href="{{ route('admin.members') }}"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('admin/members*')
                           ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                           : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        MEMBER
                    </a>
                    
                    <a href="/admin/trainer"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('admin/trainers*')
                           ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                           : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        TRAINER
                    </a>

                    <a href="/admin/jadwal"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('admin/jadwal*')
                           ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                           : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        JADWAL
                    </a>

                    <a href="/admin/tbd"
                       class="block px-4 py-2 rounded-lg
                       {{ request()->is('admin/tbd*')
                           ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/40'
                           : 'hover:bg-white/10 hover:text-emerald-400' }}">
                        TBD
                    </a>
                </nav>
            </aside>

            {{-- KONTEN --}}
            <section id="adminContent" class="flex-1 px-4 md:px-8 py-8 w-full transition-all duration-300">

                {{-- TOMBOL HAMBURGER --}}
                <button id="sidebarToggle"
                        class="inline-flex items-center justify-center mb-6 h-9 w-9 rounded-full
                               bg-white/10 hover:bg-white/20 border border-white/10">
                    <span class="sr-only">Toggle sidebar admin</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h10" />
                    </svg>
                </button>

                @yield('content')
            </section>
        </div>
    </main>

    {{-- Script toggle sidebar --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('adminSidebar');
            const toggle  = document.getElementById('sidebarToggle');
            const overlay = document.getElementById('adminOverlay');
            const content = document.getElementById('adminContent');

            if (!sidebar || !toggle || !content) return;

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');

                if (window.innerWidth >= 1024) {
                    content.classList.add('lg:ml-64');
                    if (overlay) overlay.classList.add('hidden');
                } else {
                    if (overlay) overlay.classList.remove('hidden');
                }
            };

            const closeSidebar = () => {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                content.classList.remove('lg:ml-64');

                if (overlay) overlay.classList.add('hidden');
            };

            // STATE AWAL
            if (window.innerWidth >= 1024) {
                openSidebar();
            } else {
                closeSidebar();
            }

            toggle.addEventListener('click', () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
