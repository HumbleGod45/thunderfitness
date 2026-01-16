<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Member — Thunder Fitness' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#050816] text-white flex flex-col min-h-screen">

@php
    $user = auth()->user();
    $memberName = optional($user?->member)->nama ?? 'Member';
    $initial = strtoupper(mb_substr($memberName, 0, 1));
@endphp

{{-- HEADER --}}
<header class="w-full sticky top-0 z-40
               bg-[#0A0F24]/90 backdrop-blur
               border-b border-white/10">
    <div class="max-w-7xl mx-auto flex items-center justify-between
                px-4 md:px-6 py-3 md:py-4">

        {{-- Logo --}}
        <a href="/"
           class="flex items-center gap-3 md:ml-6">
            <img
                src="{{ asset('images/thunder.png') }}"
                alt="Logo Thunder Fitness"
                class="h-10 drop-shadow-[0_0_6px_rgba(250,204,21,0.6)]"
            >
            <span class="font-semibold text-white text-lg hidden sm:inline">
                Thunder Fitness
            </span>
        </a>
        
        <div class="hidden md:flex items-center gap-4">
            <span class="text-xs uppercase tracking-widest text-white/30">
                Member Area
            </span>
            <span class="h-5 w-px bg-white/10"></span>
            <span class="text-sm font-medium text-emerald-400">
                Dashboard
            </span>
        </div>

    </div>
</header>

{{-- MAIN WRAPPER --}}
<main class="flex-1 flex flex-col bg-[#050816]">

    <div class="flex flex-1 w-full">

        {{-- SIDEBAR --}}
        <aside id="memberSidebar"
               class="fixed left-0 top-[64px] md:top-[72px] bottom-0 w-64
                      bg-[#0A0F24] border-r border-white/10
                      transition-transform duration-300 z-30
                      -translate-x-full">

            <div class="flex flex-col items-center py-8 border-b border-white/10">
                <div class="w-20 h-20 rounded-full overflow-hidden bg-emerald-500/20">
                    <img src="{{ auth()->user()->member?->foto
                        ? asset('storage/' . auth()->user()->member->foto)
                        : asset('images/member.png') }}"
                         class="w-full h-full object-cover">
                </div>
                <p class="mt-3 text-xs font-semibold tracking-widest text-emerald-400 uppercase">
                    {{ $memberName }}
                </p>
            </div>

            <nav class="px-4 py-6 space-y-1 text-sm">
                <a href="/member/home"
                    class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->is('member/home*')
                        ? 'bg-emerald-500 text-black font-semibold'
                        : 'text-gray-300 hover:bg-white/10' }}">
                    HOME
                </a>

                <a href="/member/workouts/create"
                    class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->is('member/workouts/create*')
                        ? 'bg-emerald-500 text-black font-semibold'
                        : 'text-gray-300 hover:bg-white/10' }}">
                    LATIHAN
                </a>

                <a href="/member/workouts/history"
                    class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->is('member/workouts/history*')
                        ? 'bg-emerald-500 text-black font-semibold'
                        : 'text-gray-300 hover:bg-white/10' }}">
                    HISTORY
                </a>

                <a href="/member/profile"
                    class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->is('member/profile*')
                        ? 'bg-emerald-500 text-black font-semibold'
                        : 'text-gray-300 hover:bg-white/10' }}">
                    PROFILE
                </a>
                <hr class="border-white/10 my-4">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="w-full flex items-center px-4 py-2.5 rounded-lg
                            text-red-400 hover:bg-red-500/10 transition">
                        KELUAR
                    </button>   
                </form>
            </nav>

        </aside>

        {{-- CONTENT --}}
        <section id="memberContent"
                 class="flex-1 px-4 md:px-8 py-8 transition-all duration-300">

            <button id="memberSidebarToggle"
                    class="mb-6 h-9 w-9 rounded-full bg-white/10 border border-white/10">
                ☰
            </button>

            @yield('content')
        </section>
    </div>

    {{-- FOOTER (IKUT SIDEBAR) --}}
    <footer id="memberFooter"
            class="bg-[#050816] text-gray-400 border-t border-white/10
                   transition-all duration-300">
        <div class="px-4 md:px-8 py-4 flex flex-col md:flex-row
                    items-center justify-between text-sm gap-2">
            <p>© 2026 Thunder Fitness. All rights reserved</p>
            <p>Developed by <span class="text-emerald-400 font-medium">AFS</span></p>
        </div>
    </footer>

</main>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('memberSidebar');
    const toggle  = document.getElementById('memberSidebarToggle');
    const content = document.getElementById('memberContent');
    const footer  = document.getElementById('memberFooter');

    const isMobile = () => window.innerWidth < 1024;

    const openSidebar = () => {
        sidebar.classList.remove('-translate-x-full');
        content.classList.add('lg:ml-64');
        footer.classList.add('lg:ml-64');
    };

    const closeSidebar = () => {
        sidebar.classList.add('-translate-x-full');
        content.classList.remove('lg:ml-64');
        footer.classList.remove('lg:ml-64');
    };

    isMobile() ? closeSidebar() : openSidebar();

    toggle.addEventListener('click', () => {
        sidebar.classList.contains('-translate-x-full')
            ? openSidebar()
            : closeSidebar();
    });

    window.addEventListener('resize', () => {
        isMobile() ? closeSidebar() : openSidebar();
    });
});
</script>

</body>
</html>
