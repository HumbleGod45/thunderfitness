@extends('layouts.main', ['pageTitle' => 'Pricelist — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-12 md:py-20">

        {{-- TITLE --}}
        <div class="text-center mb-12">
            <p class="uppercase tracking-[0.25em] text-emerald-400 text-xs md:text-sm">
                Thunder Fitness
            </p>
            <h1 class="mt-3 text-2xl sm:text-3xl md:text-4xl font-extrabold">
                Pricelist
            </h1>
            <p class="mt-3 text-sm md:text-base text-gray-400 max-w-2xl mx-auto">
                Pilih paket keanggotaan dan layanan personal trainer yang sesuai
                dengan kebutuhan dan target latihanmu.
            </p>
        </div>

        <div class="space-y-12">

            {{-- ================= MEMBERSHIP GYM ================= --}}
            <div class="rounded-2xl bg-[#0A0F24] border border-white/5
                        shadow-[0_20px_60px_rgba(0,0,0,0.6)]
                        p-5 sm:p-6 md:p-8">

                <h2 class="text-xl sm:text-2xl font-semibold mb-1">
                    Membership Gym
                </h2>
                <p class="text-gray-400 text-sm mb-6">
                    Akses penuh fasilitas gym Thunder Fitness.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">

                    {{-- Visit Only --}}
                    <div class="h-full rounded-xl bg-black/20 border border-white/5 p-4 flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1
                                hover:border-emerald-500/40
                                hover:shadow-[0_20px_50px_rgba(16,185,129,0.15)]">

                        <p class="font-semibold mb-1">Visit Only</p>

                        <p class="text-gray-400 text-sm flex-1">
                            Cocok untuk kamu yang ingin coba dulu.
                        </p>

                        <p class="mt-4 text-emerald-400 font-bold text-lg">
                            Rp 30.000
                            <span class="text-sm font-medium text-emerald-300">/ hari</span>
                        </p>
                    </div>

                    {{-- Paket Bulanan --}}
                    <div class="h-full rounded-xl bg-black/20 border border-white/5 p-4 flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1
                                hover:border-emerald-500/40
                                hover:shadow-[0_20px_50px_rgba(16,185,129,0.15)]">

                        <p class="font-semibold mb-1">Paket Bulanan</p>

                        <p class="text-gray-400 text-sm flex-1">
                            Akses penuh 1 bulan, fleksibel kapan saja.
                        </p>

                        <p class="mt-4 text-emerald-400 font-bold text-lg">
                            Rp 175.000
                            <span class="text-sm font-medium text-emerald-300">/ bulan</span>
                        </p>
                    </div>

                    {{-- Admin New Member --}}
                    <div class="h-full rounded-xl bg-black/20 border border-white/5 p-4 flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1
                                hover:border-emerald-500/40
                                hover:shadow-[0_20px_50px_rgba(16,185,129,0.15)]">

                        <p class="font-semibold mb-1">Admin New Member</p>

                        <p class="text-gray-400 text-sm flex-1">
                            Biaya awal join atau reaktivasi setelah off lebih dari 1 bulan.
                        </p>

                        <p class="mt-4 text-emerald-400 font-bold text-lg">
                            Rp 25.000
                        </p>
                    </div>
                </div>
            </div>

            {{-- ================= PERSONAL TRAINER ================= --}}
            <div class="rounded-2xl bg-[#0A0F24] border border-white/5
                        shadow-[0_20px_60px_rgba(0,0,0,0.6)]
                        p-5 sm:p-6 md:p-8">

                <h2 class="text-xl sm:text-2xl font-semibold mb-1">
                    Personal Trainer
                </h2>
                <p class="text-gray-400 text-sm mb-6">
                    Latihan terarah dengan pendampingan trainer pribadi.
                </p>

                {{-- ===== SINGLE ===== --}}
                <h3 class="text-lg font-semibold mb-4">
                    Single
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-10">

                    @foreach([
                        ['Sesi Percobaan','1x sesi konsultasi & latihan.','Rp 175.000','/ sesi'],
                        ['Paket 10 Sesi','Ideal untuk memulai program latihan.','Rp 1.500.000','/ paket'],
                        ['Paket 20 Sesi','Pendampingan intensif bersama trainer.','Rp 2.900.000','/ paket'],
                        ['Paket 30 Sesi','Program lanjutan untuk hasil maksimal.','Rp 4.200.000','/ paket'],
                    ] as [$title,$desc,$price,$unit])

                    <div class="h-full rounded-xl bg-black/20 border border-white/5 p-4 flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1
                                hover:border-emerald-500/40
                                hover:shadow-[0_20px_50px_rgba(16,185,129,0.15)]">

                        <p class="font-semibold mb-1">{{ $title }}</p>
                        <p class="text-gray-400 text-sm flex-1">{{ $desc }}</p>
                        <p class="mt-4 text-emerald-400 font-bold text-lg">
                            {{ $price }}
                            <span class="text-sm font-medium text-emerald-300">{{ $unit }}</span>
                        </p>
                    </div>

                    @endforeach
                </div>

                {{-- ===== COUPLE ===== --}}
                <h3 class="text-lg font-semibold mb-4">
                    Couple
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">

                    @foreach([
                        ['Sesi Percobaan','1x sesi latihan untuk dua orang.','Rp 295.000','/ sesi'],
                        ['Paket 10 Sesi','Cocok untuk mulai latihan bareng.','Rp 2.500.000','/ paket'],
                        ['Paket 20 Sesi','Latihan rutin dengan pendampingan.','Rp 4.900.000','/ paket'],
                        ['Paket 30 Sesi','Program intensif untuk dua orang.','Rp 7.200.000','/ paket'],
                    ] as [$title,$desc,$price,$unit])

                    <div class="h-full rounded-xl bg-black/20 border border-white/5 p-4 flex flex-col
                                transition-all duration-300
                                hover:-translate-y-1
                                hover:border-emerald-500/40
                                hover:shadow-[0_20px_50px_rgba(16,185,129,0.15)]">

                        <p class="font-semibold mb-1">{{ $title }}</p>
                        <p class="text-gray-400 text-sm flex-1">{{ $desc }}</p>
                        <p class="mt-4 text-emerald-400 font-bold text-lg">
                            {{ $price }}
                            <span class="text-sm font-medium text-emerald-300">{{ $unit }}</span>
                        </p>
                    </div>

                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
