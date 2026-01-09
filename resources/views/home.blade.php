@extends('layouts.main', ['pageTitle' => 'Thunder Fitness'])

@section('content')
{{-- ================= HERO SECTION ================= --}}
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
<section class="w-full bg-[#0A0F24] text-white py-12 md:py-20">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-10 text-center md:text-left">
            Kenapa pilih <span class="text-emerald-400">Thunder Fitness?</span>
        </h2>

        <div class="grid gap-10 md:grid-cols-3">
            <div class="flex flex-col gap-3 text-center md:text-left">
                <div class="text-emerald-400 text-3xl">👥</div>
                <h3 class="font-semibold text-lg">Trainer Profesional</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Dibimbing langsung oleh personal trainer berpengalaman
                    untuk membantu kamu mencapai target latihan.
                </p>
            </div>

            <div class="flex flex-col gap-3 text-center md:text-left">
                <div class="text-emerald-400 text-3xl">💰</div>
                <h3 class="font-semibold text-lg">Harga Bersahabat</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Alat lengkap dan berkualitas tanpa bikin kantong jebol.
                </p>
            </div>

            <div class="flex flex-col gap-3 text-center md:text-left">
                <div class="text-emerald-400 text-3xl">📍</div>
                <h3 class="font-semibold text-lg">Lokasi Strategis</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Lokasi mudah diakses dan jam operasional fleksibel.
                </p>
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
    let showA = true;

    const imgA = document.getElementById('sliderImageA');
    const imgB = document.getElementById('sliderImageB');

    setInterval(() => {
        index = (index + 1) % images.length;

        if (showA) {
            imgB.src = images[index];
            imgB.classList.replace('opacity-0', 'opacity-100');
            imgA.classList.replace('opacity-100', 'opacity-0');
        } else {
            imgA.src = images[index];
            imgA.classList.replace('opacity-0', 'opacity-100');
            imgB.classList.replace('opacity-100', 'opacity-0');
        }

        showA = !showA;
    }, 4500);
});
</script>
@endsection
