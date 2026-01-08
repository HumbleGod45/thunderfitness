@extends('layouts.main', ['pageTitle' => 'Thunder Fitness'])

@section('content')
{{-- HERO SECTION --}}
<section class="w-full bg-[#050816] text-white">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12 md:py-20 flex flex-col md:flex-row items-center gap-10">

        {{-- KOLUM TEKS KIRI --}}
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
                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-full bg-emerald-500 px-6 py-3 text-sm md:text-base font-semibold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/30">
                    Daftar Program Nge-Gym!
                </button>

                <button
                    onclick="window.location.href='/pricelist'"
                    class="text-sm md:text-base text-gray-300 hover:text-emerald-400 underline-offset-4 hover:underline">
                    Lihat Paket Member
                </button>
            </div>
        </div>

        {{-- KOLUM GAMBAR KANAN (SLIDER) --}}
        <div class="w-full md:w-1/2 relative flex justify-center">
            <div class="w-full max-w-sm sm:max-w-md rounded-2xl overflow-hidden shadow-[0_25px_60px_rgba(0,0,0,0.7)] border border-white/5">
                <img
                    id="sliderImage"
                    src="{{ asset('images/gym1.png') }}"
                    alt="Foto Gym"
                    class="w-full h-[220px] sm:h-[260px] md:h-[320px] object-cover transition-opacity duration-500 ease-in-out"
                >
            </div>
        </div>

    </div>
</section>

{{-- SECTION KEUNGGULAN --}}
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
                    Dibimbing langsung oleh personal trainer berpengalaman untuk membantu kamu mencapai target latihan dengan lebih efektif.
                </p>
            </div>

            <div class="flex flex-col gap-3 text-center md:text-left">
                <div class="text-emerald-400 text-3xl">💰</div>
                <h3 class="font-semibold text-lg">Nilai Terbaik, Harga Super Hemat</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Rasakan pengalaman fitness dengan alat-alat yang lengkap dan berkualitas tinggi tanpa menguras kantong.
                </p>
            </div>

            <div class="flex flex-col gap-3 text-center md:text-left">
                <div class="text-emerald-400 text-3xl">📍</div>
                <h3 class="font-semibold text-lg">Lokasi Strategis & Akses Fleksibel</h3>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Terletak di lokasi yang mudah diakses di jantung kota Solo. Kami juga buka setiap hari dari jam 06.00 hingga 21.00, memastikan Anda selalu punya waktu untuk berlatih
                </p>
            </div>
        </div>
    </div>
</section>
{{-- Script slider --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const images = [
            "{{ asset('images/gym1.png') }}",
            "{{ asset('images/gym2.png') }}",
            "{{ asset('images/gym3.png') }}",
        ];

        let index   = 0;
        const imgEl   = document.getElementById('sliderImage');
        const prevBtn = document.getElementById('prevSlide');
        const nextBtn = document.getElementById('nextSlide');
        let timer = null;

        function changeImage(newIndex) {
            index = (newIndex + images.length) % images.length;

            imgEl.classList.add('opacity-0');
            setTimeout(() => {
                imgEl.src = images[index];
                imgEl.classList.remove('opacity-0');
            }, 250);
        }

        function startAutoSlide() {
            if (timer) clearInterval(timer);
            timer = setInterval(() => {
                changeImage(index + 1);
            }, 5000);
        }

        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', function () {
                changeImage(index - 1);
                startAutoSlide();
            });

            nextBtn.addEventListener('click', function () {
                changeImage(index + 1);
                startAutoSlide();
            });
        }

        startAutoSlide();
    });
</script>
@endsection
