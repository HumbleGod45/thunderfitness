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

<body class="bg-[#050816] text-white overflow-x-hidden flex flex-col min-h-screen">

{{-- NAVBAR --}}
<header class="w-full bg-[#e9ed81] shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/thunder.png') }}" alt="Logo" class="h-10">
            <span class="font-semibold text-gray-800 text-lg hidden sm:inline">
                Thunder Fitness
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-gray-900 font-medium">
            <a href="/" class="{{ request()->is('/') ? 'text-emerald-600' : '' }}">Home</a>
            <a href="/pricelist" class="{{ request()->is('pricelist') ? 'text-emerald-600' : '' }}">Pricelist</a>
            <a href="/trainer" class="{{ request()->is('trainer') ? 'text-emerald-600' : '' }}">Personal Trainer</a>
            <a href="/about" class="{{ request()->is('about') ? 'text-emerald-600' : '' }}">Tentang Kami</a>
        </nav>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="px-4 py-2 rounded-full bg-white/80 text-gray-900 text-sm font-semibold">
                Keluar
            </button>
        </form>
    </div>
</header>

{{-- MAIN --}}
<main class="flex-1 bg-[#050816]">
    <div class="relative flex">

        {{-- Overlay --}}
        <div id="adminOverlay"
             class="fixed inset-x-0 bottom-0 top-[64px] md:top-[72px] bg-black/50 z-30 hidden"></div>

        {{-- SIDEBAR --}}
        <aside id="adminSidebar"
               class="fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                      bg-[#0A0F24] border-r border-white/10
                      transition-transform duration-300 z-40
                      -translate-x-full">

            <div class="flex flex-col items-center py-8 border-b border-white/10">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-emerald-500/20">
                    <img src="{{ asset('images/member.png') }}" class="w-full h-full object-cover">
                </div>
                <p class="mt-3 text-xs font-semibold tracking-widest text-emerald-400">
                    ADMIN PANEL
                </p>
            </div>

            <nav class="px-5 py-6 space-y-2 text-sm">
                <a href="{{ route('admin.members') }}"
                   class="block px-4 py-2 rounded-lg {{ request()->is('admin/members*') ? 'bg-emerald-500' : 'hover:bg-white/10' }}">
                    MEMBER
                </a>
                <a href="/admin/trainer"
                   class="block px-4 py-2 rounded-lg {{ request()->is('admin/trainers*') ? 'bg-emerald-500' : 'hover:bg-white/10' }}">
                    TRAINER
                </a>
                <a href="/admin/laporan"
                   class="block px-4 py-2 rounded-lg {{ request()->is('admin/laporan*') ? 'bg-emerald-500' : 'hover:bg-white/10' }}">
                    LAPORAN
                </a>
                <a href="{{ route('admin.announcements.index') }}"
                   class="block px-4 py-2 rounded-lg {{ request()->is('admin/announcements*') ? 'bg-emerald-500' : 'hover:bg-white/10' }}">
                    PENGUMUMAN
                </a>
            </nav>
        </aside>

        {{-- CONTENT + FOOTER WRAPPER --}}
        <div id="adminContentWrapper"
             class="flex-1 flex flex-col transition-all duration-300">

            {{-- CONTENT --}}
            <section id="adminContent" class="flex-1 px-4 md:px-8 py-8">
                <button id="sidebarToggle"
                        class="mb-6 h-9 w-9 rounded-full bg-white/10 border border-white/10">
                    ☰
                </button>

                @yield('content')
            </section>

            {{-- FOOTER --}}
            <footer class="mt-auto w-full bg-[#050816] text-gray-400">
                <div class="px-4 md:px-6 py-6
                            flex flex-col md:flex-row items-center justify-between gap-3 text-sm">
                    <p>© 2026 Thunder Fitness. All rights reserved</p>
                    <p>Developed by <span class="text-emerald-400 font-medium">AFS</span></p>
                </div>
            </footer>

        </div>
    </div>
</main>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar  = document.getElementById('adminSidebar');
    const toggle   = document.getElementById('sidebarToggle');
    const overlay  = document.getElementById('adminOverlay');
    const wrapper  = document.getElementById('adminContentWrapper');

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        wrapper.classList.add('lg:ml-64');
        overlay?.classList.add('hidden');
    };

    const close = () => {
        sidebar.classList.add('-translate-x-full');
        wrapper.classList.remove('lg:ml-64');
        overlay?.classList.add('hidden');
    };

    window.innerWidth >= 1024 ? open() : close();

    toggle.onclick = () =>
        sidebar.classList.contains('-translate-x-full') ? open() : close();

    overlay?.addEventListener('click', close);

    window.addEventListener('resize', () =>
        window.innerWidth >= 1024 ? open() : close()
    );
});
</script>

</body>
</html>
