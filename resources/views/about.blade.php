@extends('layouts.main', ['pageTitle' => 'Tentang Kami — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen">
    <div class="max-w-6xl mx-auto px-6 py-16 md:py-20">

        {{-- HEADER --}}
        <div class="mb-10 text-center md:text-left">
            <p class="uppercase tracking-[0.25em] text-emerald-400 text-xs md:text-sm">
                Thunder Fitness
            </p>
            <h1 class="mt-3 text-3xl md:text-4xl font-extrabold">
                Tentang Thunder Fitness
            </h1>
            <p class="mt-3 text-sm md:text-base text-gray-400 max-w-3xl mx-auto md:mx-0">
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
                    mendukung berbagai tujuan latihan seperti fat loss, hypertrophy, maupun strength training.
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
                <div class="space-y-4 text-sm md:text-base text-gray-300">
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <span class="text-emerald-400">🏋️</span>
                        </div>
                        <p><span class="font-semibold text-white">Fasilitas lengkap</span><br>Peralatan gym modern dari pemula hingga advance.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <span class="text-emerald-400">🚿</span>
                        </div>
                        <p><span class="font-semibold text-white">Fasilitas Terawat</span><br>Area bersih, termasuk ruang ganti dan kamar mandi.</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center shrink-0">
                            <span class="text-emerald-400">👥</span>
                        </div>
                        <p><span class="font-semibold text-white">Personal trainer profesional</span><br>Trainer siap menyusun program latihan personal.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- BAGIAN GOOGLE MAPS --}}
        <div class="mt-16">
            <h2 class="text-xl md:text-2xl font-semibold mb-6 flex items-center gap-2 text-white">
                <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                Lokasi Kami
            </h2>
            
            <div class="w-full h-[350px] md:h-[450px] rounded-2xl overflow-hidden border border-white/10 shadow-2xl relative bg-[#0A0F24]">
                <iframe 
                    width="100%" 
                    height="100%" 
                    frameborder="0" 
                    style="border:0;" 
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3955.034!2d110.8270863!3d-7.5693274!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5961f4b50d55%3A0x158fbc02cd647711!2sTHUNDER%20FITNESS!5e0!3m2!1sid!2sid!4v1715000000000!5m2!1sid!2sid"
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <div class="absolute inset-0 pointer-events-none shadow-[inset_0_0_80px_rgba(5,8,22,0.6)]"></div>
            </div>
            
            {{-- Info Bar & Tombol --}}
            <div class="mt-4 flex flex-col md:flex-row justify-between items-stretch md:items-center bg-white/5 p-4 rounded-xl border border-white/5 gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-400/10 flex items-center justify-center border border-emerald-400/20">
                        <span class="text-emerald-400">📍</span>
                    </div>
                    <div>
                        <p class="text-white text-sm font-bold uppercase tracking-wider">THUNDER FITNESS</p>
                        <p class="text-gray-400 text-[11px] md:text-xs">Jl. Komodo Raya No.7, Kp. Baru, Surakarta</p>
                    </div>
                </div>
                
                <div class="flex flex-col items-stretch md:items-end gap-1">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=-7.569314773796967,110.82709894852869" 
                       target="_blank" 
                       class="w-full md:w-auto px-6 py-2.5 bg-emerald-500 hover:bg-emerald-400 text-[#050816] text-xs font-extrabold rounded-lg transition-all shadow-lg shadow-emerald-500/20 text-center uppercase tracking-wider">
                        Petunjuk Arah
                    </a>
                    <p class="text-gray-500 text-[10px] hidden md:block italic">Akan membuka Google Maps di tab baru</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection