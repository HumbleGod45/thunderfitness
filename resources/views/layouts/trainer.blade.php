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
                Trainer Area
            </span>
            <span class="h-5 w-px bg-white/10"></span>
            <span class="text-sm font-medium text-emerald-400">
                Dashboard
            </span>
        </div>
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

        {{-- PROFILE --}}
        <div class="flex flex-col items-center py-8 border-b border-white/10">
            <div class="relative">
                <div class="w-20 h-20 rounded-full overflow-hidden
                        bg-emerald-500/20 ring-2 ring-emerald-500/30">
                    <img src="{{ $trainer && $trainer->foto
                        ? asset('storage/' . $trainer->foto)
                        : asset('images/trainer-default.png') }}"
                        class="w-full h-full object-cover">
                </div>
            </div>

            <p class="mt-4 text-sm font-semibold text-white">
                {{ $trainer->nama ?? 'Trainer' }}
            </p>
            <p class="mt-1 text-xs tracking-widest text-emerald-400 uppercase">
                Trainer 
            </p>
        </div>

        {{-- MENU --}}
        <nav class="px-4 py-6 space-y-1 text-sm">
            <a href="/trainer/home"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg
                  {{ request()->is('trainer/home*')
                      ? 'bg-emerald-500 text-black font-semibold'
                      : 'text-gray-300 hover:bg-white/10' }}">
                MEMBER
            </a>

            <a href="/trainer/latihan"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg
                  {{ request()->is('trainer/latihan*')
                      ? 'bg-emerald-500 text-black font-semibold'
                      : 'text-gray-300 hover:bg-white/10' }}">
                LATIHAN
            </a>

            <a href="/trainer/history"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg
                  {{ request()->is('trainer/history*')
                      ? 'bg-emerald-500 text-black font-semibold'
                      : 'text-gray-300 hover:bg-white/10' }}">
                HISTORY
            </a>

            <a href="/trainer/profile"
                class="flex items-center gap-3 px-4 py-2.5 rounded-lg
                  {{ request()->is('trainer/profile*')
                      ? 'bg-emerald-500 text-black font-semibold'
                      : 'text-gray-300 hover:bg-white/10' }}">
                PROFILE
            </a>
            <hr class="border-white/10 my-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    class="w-full flex items-center gap-3
                       px-4 py-2.5 rounded-lg
                       text-red-400 hover:bg-red-500/10 transition">
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
