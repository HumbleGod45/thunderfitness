@extends('layouts.main', ['pageTitle' => 'Pricelist — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen relative overflow-hidden">
    <div class="absolute top-0 -left-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-40 -right-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-12 md:py-20 relative z-10">

        {{-- TITLE --}}
        <div class="text-center mb-16">
            <p class="uppercase tracking-[0.3em] text-emerald-400 text-xs md:text-sm font-bold">
                Thunder Fitness
            </p>
            <h1 class="mt-3 text-3xl sm:text-4xl md:text-5xl font-black tracking-tight">
                Investasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Kesehatanmu</span>
            </h1>
            <p class="mt-4 text-sm md:text-base text-gray-400 max-w-xl mx-auto leading-relaxed">
                Pilih paket keanggotaan yang dirancang untuk membantumu mencapai level kebugaran maksimal.
            </p>
        </div>

        <div class="space-y-16">

            {{-- ================= MEMBERSHIP GYM ================= --}}
            <div>
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-2xl font-bold italic tracking-tighter uppercase">Membership Gym</h2>
                    <div class="h-[2px] flex-1 bg-gradient-to-r from-emerald-500/50 to-transparent"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

                    {{-- Visit Only --}}
                    <div class="group relative rounded-2xl bg-white/[0.03] border border-white/10 p-6 transition-all duration-500 hover:border-emerald-500/50 hover:bg-white/[0.06] hover:-translate-y-2">
                        <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-2xl"></div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Daily Pass</p>
                        <h3 class="text-xl font-bold mb-3">Visit Only</h3>
                        <p class="text-gray-400 text-sm leading-relaxed mb-6">Cocok untuk kamu yang ingin merasakan atmosfer latihan kami.</p>
                        <div class="mt-auto">
                            <span class="text-2xl font-black text-emerald-400">Rp 30.000</span>
                            <span class="text-xs font-medium text-gray-500 uppercase ml-1">/ visit</span>
                        </div>
                    </div>

                    {{-- Paket Bulanan (BEST VALUE) --}}
                    <div class="group relative rounded-2xl bg-gradient-to-b from-emerald-500/20 to-emerald-500/[0.02] border-2 border-emerald-500/50 p-6 transition-all duration-500 hover:-translate-y-2 shadow-[0_0_40px_rgba(16,185,129,0.1)]">
                        <p class="text-emerald-400 text-xs font-bold uppercase tracking-widest mb-2">Full Access</p>
                        <h3 class="text-xl font-bold mb-3">Paket Bulanan</h3>
                        <p class="text-emerald-500/70 text-sm leading-relaxed mb-6">Akses tanpa batas selama 30 hari penuh ke seluruh area gym.</p>
                        <div class="mt-auto">
                            <span class="text-3xl font-black text-white">Rp 175k</span>
                            <span class="text-xs font-medium text-emerald-400 uppercase ml-1">/ bulan</span>
                        </div>
                    </div>

                    {{-- Admin New Member --}}
                    <div class="group relative rounded-2xl bg-white/[0.03] border border-white/10 p-6 transition-all duration-500 hover:border-emerald-500/50 hover:bg-white/[0.06] hover:-translate-y-2">
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-2">Registration</p>
                        <h3 class="text-xl font-bold mb-3">One-time Fee</h3>
                        <p class="text-gray-400 text-sm leading-relaxed mb-6">Biaya pendaftaran member baru atau reaktivasi member lama.</p>
                        <div class="mt-auto">
                            <span class="text-2xl font-black text-emerald-400">Rp 25.000</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================= PERSONAL TRAINER ================= --}}
            <div>
                <div class="flex items-center gap-4 mb-8">
                    <h2 class="text-2xl font-bold italic tracking-tighter uppercase">Personal Trainer</h2>
                    <div class="h-[2px] flex-1 bg-gradient-to-r from-cyan-500/50 to-transparent"></div>
                </div>

                {{-- ===== SINGLE ===== --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-emerald-400 font-bold uppercase tracking-widest text-sm flex items-center gap-2">
                        <span class="w-8 h-[1px] bg-emerald-400"></span> Single Program
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                    @foreach([
                        ['Trial Session','1x Konsultasi','Rp 175k','/ sesi'],
                        ['Beginner','Paket 10 Sesi','Rp 1.5jt','/ paket'],
                        ['Intensive','Paket 20 Sesi','Rp 2.9jt','/ paket'],
                        ['Transformation','Paket 30 Sesi','Rp 4.2jt','/ paket'],
                    ] as [$title,$desc,$price,$unit])
                    <div class="group p-5 rounded-2xl bg-[#0A0F24] border border-white/5 hover:border-cyan-500/50 transition-all duration-500">
                        <h4 class="font-bold text-white mb-1 group-hover:text-cyan-400 transition-colors">{{ $title }}</h4>
                        <p class="text-gray-500 text-xs mb-4">{{ $desc }}</p>
                        <p class="text-lg font-black text-white group-hover:scale-105 transition-transform origin-left">
                            {{ $price }} <span class="text-[10px] text-gray-500 uppercase font-normal">{{ $unit }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>

                {{-- ===== COUPLE ===== --}}
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-cyan-400 font-bold uppercase tracking-widest text-sm flex items-center gap-2">
                        <span class="w-8 h-[1px] bg-cyan-400"></span> Couple Program
                    </h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach([
                        ['Couple Trial','1x Sesi Berdua','Rp 295k','/ sesi'],
                        ['Duo Start','Paket 10 Sesi','Rp 2.5jt','/ paket'],
                        ['Duo Routine','Paket 20 Sesi','Rp 4.9jt','/ paket'],
                        ['Duo Goal','Paket 30 Sesi','Rp 7.2jt','/ paket'],
                    ] as [$title,$desc,$price,$unit])
                    <div class="group p-5 rounded-2xl bg-[#0A0F24] border border-white/5 hover:border-emerald-500/50 transition-all duration-500">
                        <h4 class="font-bold text-white mb-1 group-hover:text-emerald-400 transition-colors">{{ $title }}</h4>
                        <p class="text-gray-500 text-xs mb-4">{{ $desc }}</p>
                        <p class="text-lg font-black text-white group-hover:scale-105 transition-transform origin-left">
                            {{ $price }} <span class="text-[10px] text-gray-500 uppercase font-normal">{{ $unit }}</span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection