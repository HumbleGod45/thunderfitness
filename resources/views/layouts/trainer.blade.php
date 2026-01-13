<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Trainer — Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#050816] text-white flex flex-col min-h-screen">

{{-- HEADER --}}
<header class="w-full bg-[#e9ed81] shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 py-3 md:py-4">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/thunder.png') }}" class="h-10">
            <span class="font-semibold text-gray-800 text-lg hidden sm:inline">
                Thunder Fitness
            </span>
        </a>

        <nav class="hidden md:flex gap-8 text-gray-900 font-medium">
            <a href="/" class="{{ request()->is('/') ? 'text-emerald-600' : '' }}">Home</a>
            <a href="/pricelist" class="{{ request()->is('pricelist') ? 'text-emerald-600' : '' }}">Pricelist</a>
            <a href="/trainer" class="{{ request()->is('trainer') ? 'text-emerald-600' : '' }}">Personal Trainer</a>
            <a href="/about" class="{{ request()->is('about') ? 'text-emerald-600' : '' }}">Tentang Kami</a>
        </nav>

        <span class="hidden md:inline text-sm font-semibold text-gray-800">
            Dashboard Trainer
        </span>
    </div>
</header>

{{-- MAIN --}}
<main class="flex-1 bg-[#050816]">
    <div class="relative flex">

        {{-- SIDEBAR --}}
        @php $trainer = auth()->user()->trainer; @endphp

        <aside id="trainerSidebar"
               class="fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                      bg-[#0A0F24] border-r border-white/10
                      transition-transform duration-300 z-40
                      -translate-x-full">

            <div class="flex flex-col items-center py-8 border-b border-white/10">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-emerald-500/20">
                    <img src="{{ $trainer && $trainer->foto
                        ? asset('storage/' . $trainer->foto)
                        : asset('images/trainer-default.png') }}"
                        class="w-full h-full object-cover">
                </div>

                <p class="mt-3 text-sm font-semibold">{{ $trainer->nama ?? 'Trainer' }}</p>
                <p class="mt-1 text-xs tracking-widest text-emerald-400">TRAINER</p>
            </div>

            <nav class="px-5 py-6 space-y-2 text-sm text-gray-300">
                <a href="/trainer/home"
                   class="block px-4 py-2 rounded-lg {{ request()->is('trainer/home*') ? 'bg-emerald-500 text-white' : 'hover:bg-white/10' }}">
                    MEMBER
                </a>
                <a href="/trainer/latihan"
                   class="block px-4 py-2 rounded-lg {{ request()->is('trainer/latihan*') ? 'bg-emerald-500 text-white' : 'hover:bg-white/10' }}">
                    LATIHAN
                </a>
                <a href="/trainer/profile"
                   class="block px-4 py-2 rounded-lg {{ request()->is('trainer/profile*') ? 'bg-emerald-500 text-white' : 'hover:bg-white/10' }}">
                    PROFILE
                </a>
                <a href="/trainer/history"
                   class="block px-4 py-2 rounded-lg {{ request()->is('trainer/history*') ? 'bg-emerald-500 text-white' : 'hover:bg-white/10' }}">
                    HISTORY
                </a>

                <hr class="border-white/10 my-4">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded-lg text-red-400 hover:bg-red-500/10">
                        KELUAR
                    </button>
                </form>
            </nav>
        </aside>

        {{-- CONTENT + FOOTER --}}
        <div id="trainerWrapper"
             class="flex-1 flex flex-col transition-all duration-300">

            {{-- CONTENT --}}
            <section id="trainerContent" class="flex-1 px-4 md:px-8 py-8">
                <button id="trainerSidebarToggle"
                        class="mb-6 h-9 w-9 rounded-full bg-white/10 border border-white/10">
                    ☰
                </button>

                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </section>

            {{-- FOOTER --}}
            <footer class="mt-auto bg-[#050816] text-gray-400">
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
    const sidebar = document.getElementById('trainerSidebar');
    const toggle  = document.getElementById('trainerSidebarToggle');
    const wrapper = document.getElementById('trainerWrapper');

    const isMobile = () => window.innerWidth < 1024;

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        wrapper.classList.add('lg:ml-64');
    };

    const close = () => {
        sidebar.classList.add('-translate-x-full');
        wrapper.classList.remove('lg:ml-64');
    };

    isMobile() ? close() : open();

    toggle.onclick = () =>
        sidebar.classList.contains('-translate-x-full') ? open() : close();

    window.addEventListener('resize', () =>
        isMobile() ? close() : open()
    );
});
</script>

</body>
</html>
