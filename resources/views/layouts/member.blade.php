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
<header class="w-full bg-[#e9ed81] shadow-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4 px-4 md:px-6 py-3 md:py-4">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/thunder.png') }}" class="h-10">
            <span class="font-semibold text-gray-800 text-lg hidden sm:inline">
                Thunder Fitness
            </span>
        </a>

        <nav class="hidden md:flex items-center gap-8 text-gray-900 font-medium">
            <a href="/" class="hover:text-emerald-600">Home</a>
            <a href="/pricelist" class="hover:text-emerald-600">Pricelist</a>
            <a href="/trainer" class="hover:text-emerald-600">Personal Trainer</a>
            <a href="/about" class="hover:text-emerald-600">Tentang Kami</a>
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

            <nav class="px-5 py-6 space-y-2 text-sm">
                <a href="/member/home" class="block px-4 py-2 rounded-lg hover:bg-white/10">HOME</a>
                <a href="/member/workouts/create" class="block px-4 py-2 rounded-lg hover:bg-white/10">LATIHAN</a>
                <a href="/member/profile" class="block px-4 py-2 rounded-lg hover:bg-white/10">PROFILE</a>
                <a href="/member/workouts/history" class="block px-4 py-2 rounded-lg hover:bg-white/10">HISTORY</a>

                <hr class="border-white/10 my-4">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left px-4 py-2 rounded-lg text-red-400 hover:bg-red-500/10">
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
