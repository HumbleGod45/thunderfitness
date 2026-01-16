@extends('layouts.main', ['pageTitle' => 'Personal Trainer — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen relative overflow-hidden">
    {{-- Aksen Background Glow --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-500/5 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-blue-500/5 rounded-full blur-[120px] -z-10"></div>

    <div class="max-w-6xl mx-auto px-6 py-16 md:py-20 relative">

        {{-- TITLE --}}
        <div class="text-center mb-16">
            <h1 class="mt-3 text-4xl md:text-5xl font-black tracking-tight italic">
                PERSONAL <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">TRAINER</span>
            </h1>
            <div class="h-1 w-24 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            <p class="mt-6 text-sm md:text-base text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Partner latihan profesional yang siap membimbingmu mencapai transformasi fisik maksimal dengan teknik yang benar.
            </p>
        </div>
        <div class="flex items-center gap-3 mb-8">
            <div class="w-2 h-8 bg-emerald-500 rounded-full"></div>
            <h2 class="text-lg md:text-xl font-bold uppercase tracking-wider">Meet Our Professionals</h2>
        </div>

        {{-- GRID TRAINER --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">

            @forelse($trainers as $trainer)
                <div class="group relative rounded-2xl bg-white/[0.02] border border-white/5 p-6 flex flex-col items-center text-center transition-all duration-500 hover:bg-white/[0.05] hover:-translate-y-2 hover:border-emerald-500/30">
                    
                    {{-- Dekorasi Card Hover --}}
                    <div class="absolute inset-0 bg-gradient-to-b from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl"></div>

                    {{-- Avatar dengan Glow --}}
                    <div class="relative mb-6">
                        <div class="absolute inset-0 bg-emerald-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="w-28 h-28 rounded-full overflow-hidden relative ring-4 ring-emerald-500/20 group-hover:ring-emerald-500/50 transition-all duration-500 shadow-2xl">
                            <img
                                src="{{ $trainer->foto ? asset('storage/' . $trainer->foto) : asset('images/trainer-default.png') }}"
                                alt="{{ $trainer->nama }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        </div>
                    </div>

                    {{-- Nama --}}
                    <h3 class="text-lg font-bold text-white mb-1 group-hover:text-emerald-400 transition-colors">
                        {{ $trainer->nama }}
                    </h3>
                    <p class="text-[10px] text-gray-500 uppercase tracking-[0.2em] font-bold mb-4">Certified Trainer</p>

                    {{-- Spesialis --}}
                    <div class="w-full rounded-xl bg-black/40 border border-white/5 p-3 relative z-10">
                        <p class="text-[9px] text-gray-400 uppercase tracking-widest mb-1 font-black">
                            Expertise
                        </p>
                        <p class="text-xs font-bold text-white group-hover:text-emerald-400 transition-colors">
                            {{ $trainer->spesialis ?? 'General Fitness' }}
                        </p>
                    </div>
                    
                    <div class="w-0 h-1 bg-emerald-500 absolute bottom-0 left-0 group-hover:w-full transition-all duration-500 rounded-b-2xl"></div>
                </div>
            @empty
                <div class="col-span-full py-20 rounded-2xl bg-white/[0.02] border border-dashed border-white/10 text-center text-gray-500 italic">
                    Belum ada personal trainer tersedia di squad ini.
                </div>
            @endforelse

        </div>

        {{-- CTA --}}
        <div class="mt-16 text-center relative">
            <div class="absolute -top-10 left-1/2 -translate-x-1/2 w-40 h-[1px] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
            
            <p class="text-gray-400 text-sm mb-6 max-w-sm mx-auto">
                Bingung menentukan trainer yang tepat? Konsultasi gratis untuk program latihanmu sekarang.
            </p>
            
            <a
                href="https://wa.me/6289509777727?text=Halo%20Thunder%20Fitness,%20saya%20ingin%20konsultasi%20pilih%20personal%20trainer."
                target="_blank"
                rel="noopener noreferrer"
                class="group relative inline-flex items-center gap-3 bg-emerald-500 px-8 py-3.5 rounded-full text-sm font-black text-[#050816] uppercase tracking-wider hover:bg-emerald-400 transition-all shadow-[0_10px_30px_rgba(16,185,129,0.3)] overflow-hidden">
                <span class="relative z-10">Konsultasi Pilih Trainer</span>
                <svg class="w-4 h-4 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
            </a>
        </div>
    </div>
</section>
@endsection