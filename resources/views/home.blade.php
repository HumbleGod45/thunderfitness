@extends('layouts.main', ['pageTitle' => 'Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 md:py-20
                flex flex-col md:flex-row items-center gap-10">

        {{-- TEKS --}}
        <div class="w-full md:w-1/2 space-y-6 text-center md:text-left">
            <p class="uppercase tracking-[0.25em] text-emerald-400 text-xs md:text-sm">
                Thunder Fitness
            </p>

            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight">
                Tempat terbaik buat
                <span class="text-emerald-400">naik level</span> kebugaranmu.
            </h1>

            <p class="text-sm md:text-base text-gray-400">
                Pantau progres latihan, jadwal personal trainer, dan keanggotaan kamu
                lewat sistem manajemen gym Thunder Fitness.
            </p>

            <div class="flex flex-col sm:flex-row items-center sm:items-baseline gap-4 pt-2">
                <button
                    onclick="window.location.href='/register'"
                    class="w-full sm:w-auto inline-flex items-center justify-center
                           rounded-full bg-emerald-500 px-6 py-3
                           text-sm md:text-base font-semibold
                           hover:bg-emerald-400 transition
                           shadow-lg shadow-emerald-500/30">
                    Daftar Program Nge-Gym!
                </button>

                <button
                    onclick="window.location.href='/pricelist'"
                    class="text-sm md:text-base text-gray-300
                           hover:text-emerald-400 hover:underline underline-offset-4">
                    Lihat Paket Member
                </button>
            </div>
        </div>

        {{-- SLIDER FOTO --}}
        <div class="w-full md:w-1/2 flex justify-center">
            <div class="relative w-full max-w-sm sm:max-w-md
                        h-[220px] sm:h-[260px] md:h-[320px]
                        rounded-2xl overflow-hidden
                        shadow-[0_25px_60px_rgba(0,0,0,0.7)]
                        border border-white/5">

                <img id="sliderImageA"
                     src="{{ asset('images/gym1.JPG') }}"
                     class="absolute inset-0 w-full h-full object-cover
                            transition-opacity duration-1000 ease-in-out opacity-100">

                <img id="sliderImageB"
                     src=""
                     class="absolute inset-0 w-full h-full object-cover
                            transition-opacity duration-1000 ease-in-out opacity-0">
            </div>
        </div>
    </div>
</section>

{{-- ================= KEUNGGULAN ================= --}}
<section class="w-full bg-[#050816] text-white py-16 md:py-24 relative overflow-hidden">
    {{-- Dekorasi Background --}}
    <div class="absolute top-0 left-1/4 w-64 h-64 bg-emerald-500/5 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10">
        <div class="text-center md:text-left mb-16">
            <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-none mb-4">
                KENAPA HARUS <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">THUNDER FITNESS?</span>
            </h2>
            <div class="h-1 w-20 bg-emerald-500 mx-auto md:mx-0 rounded-full"></div>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            {{-- Card 1 --}}
            <div class="group p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-emerald-500/30 hover:bg-white/[0.04] transition-all duration-500 shadow-2xl relative overflow-hidden">
                {{-- Glow Effect on Hover --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-10 transition-opacity"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-emerald-500/10 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                        👥
                    </div>
                    <h3 class="font-bold text-xl mb-3 group-hover:text-emerald-400 transition-colors">Trainer Profesional</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Dibimbing langsung oleh personal trainer berpengalaman untuk membantu kamu mencapai target latihan secara terukur.
                    </p>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="group p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-emerald-500/30 hover:bg-white/[0.04] transition-all duration-500 shadow-2xl relative overflow-hidden">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-10 transition-opacity"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-emerald-500/10 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                        💰
                    </div>
                    <h3 class="font-bold text-xl mb-3 group-hover:text-emerald-400 transition-colors">Harga Bersahabat</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Nikmati fasilitas alat yang lengkap, modern, dan berkualitas tinggi tanpa perlu khawatir bikin kantong kamu jebol.
                    </p>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="group p-8 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-emerald-500/30 hover:bg-white/[0.04] transition-all duration-500 shadow-2xl relative overflow-hidden">
                <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-10 transition-opacity"></div>
                
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-emerald-500/10 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                        📍
                    </div>
                    <h3 class="font-bold text-xl mb-3 group-hover:text-emerald-400 transition-colors">Lokasi Strategis</h3>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Berada di pusat kota yang sangat mudah diakses dengan dukungan jam operasional yang fleksibel sesuai jadwalmu.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= SLIDER SCRIPT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const images = [
        "{{ asset('images/gym1.JPG') }}",
        "{{ asset('images/gym2.JPG') }}",
        "{{ asset('images/gym3.JPG') }}",
        "{{ asset('images/gym4.JPG') }}",
        "{{ asset('images/gym5.JPG') }}"
    ];

    let index = 0;
    let showingA = true;

    const imgA = document.getElementById('sliderImageA');
    const imgB = document.getElementById('sliderImageB');

    function swapImage() {
        index = (index + 1) % images.length;

        const incoming = showingA ? imgB : imgA;
        const outgoing = showingA ? imgA : imgB;

        // preload image dulu
        const preload = new Image();
        preload.src = images[index];

        preload.onload = () => {
            incoming.src = preload.src;

            // fade
            incoming.classList.remove('opacity-0');
            incoming.classList.add('opacity-100');

            outgoing.classList.remove('opacity-100');
            outgoing.classList.add('opacity-0');

            showingA = !showingA;
        };
    }

    setInterval(swapImage, 4500);
});
</script>
@endsection
