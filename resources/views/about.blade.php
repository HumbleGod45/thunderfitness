@extends('layouts.main', ['pageTitle' => 'Tentang Kami — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen">
    <div class="max-w-6xl mx-auto px-6 py-16 md:py-20">

        {{-- HEADER --}}
        <div class="mb-10">
            <p class="uppercase tracking-[0.25em] text-emerald-400 text-xs md:text-sm">
                Thunder Fitness
            </p>
            <h1 class="mt-3 text-3xl md:text-4xl font-extrabold">
                Tentang Thunder Fitness
            </h1>
            <p class="mt-3 text-sm md:text-base text-gray-400 max-w-3xl">
                Thunder Fitness adalah gym yang berfokus pada pengalaman latihan yang nyaman,
                terarah, dan terukur melalui dukungan fasilitas lengkap dan sistem manajemen
                gym berbasis web.
            </p>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="grid md:grid-cols-2 gap-10">

            {{-- Kolom kiri: profil singkat --}}
            <div class="space-y-5">
                <h2 class="text-xl md:text-2xl font-semibold">Siapa kami?</h2>
                <p class="text-sm md:text-base text-gray-300 leading-relaxed">
                    Thunder Fitness berlokasi di
                    <span class="font-semibold text-emerald-400">
                        Jl. Komodo Raya No.7, Kp. Baru, Kec. Ps. Kliwon, Kota Surakarta
                    </span>.
                    Gym ini menyediakan berbagai alat fitness yang lengkap dan up to date,
                    sehingga dapat mendukung berbagai tujuan latihan seperti fat loss,
                    hypertrophy, maupun strength training.
                </p>
                <p class="text-sm md:text-base text-gray-300 leading-relaxed">
                    Melalui sistem manajemen gym berbasis web, Thunder Fitness membantu
                    pengelola dalam mengatur data member, jadwal latihan, booking personal
                    trainer, hingga monitoring progress latihan secara digital.
                </p>
            </div>

            {{-- Kolom kanan: info singkat / highlight --}}
            <div class="space-y-5">
                <h2 class="text-xl md:text-2xl font-semibold">Kenapa Thunder Fitness?</h2>

                <div class="space-y-3 text-sm md:text-base text-gray-300">
                    <div class="flex gap-3">
                        <span class="text-emerald-400 mt-1">🏋️</span>
                        <p>
                            <span class="font-semibold text-white">Fasilitas lengkap</span><br>
                            Peralatan gym modern yang mendukung berbagai jenis latihan, dari
                            pemula hingga advance.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-emerald-400 mt-1">🚿</span>
                        <p>
                            <span class="font-semibold text-white">Fasilitas Terawat</span><br>
                            Kami memastikan semua area dan peralatan selalu terawat dan bersih, termasuk ruang ganti dan kamar mandi.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-emerald-400 mt-1">👥</span>
                        <p>
                            <span class="font-semibold text-white">Personal trainer profesional</span><br>
                            Tersedia trainer yang siap membantu menyusun program latihan
                            sesuai kebutuhan dan kondisi masing-masing member.
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <span class="text-emerald-400 mt-1">🔥</span>
                        <p>
                            <span class="font-semibold text-white">Atmosfer penuh energi</span><br>
                            Kami menciptakan lingkungan yang ramah dan suportif membuat sesi latihan lebih menyenangkan dan memotivasi untuk datang setiap hari.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER KECIL DI HALAMAN --}}
        <div class="mt-12 border-t border-white/5 pt-6 text-xs md:text-sm text-gray-500">
            <p>
                Sistem informasi manajemen gym ini dikembangkan sebagai bagian dari tugas akhir
                untuk mendukung operasional Thunder Fitness dan meningkatkan pengalaman latihan member.
            </p>
        </div>

    </div>
</section>
@endsection
