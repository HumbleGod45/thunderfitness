@extends('layouts.main', ['pageTitle' => 'Personal Trainer — Thunder Fitness'])

@section('content')
<section class="w-full bg-[#050816] text-white min-h-screen">
    <div class="max-w-6xl mx-auto px-6 py-16 md:py-20">

        {{-- TITLE --}}
        <div class="text-center mb-10">
            <p class="uppercase tracking-[0.25em] text-emerald-400 text-xs md:text-sm">
                Thunder Fitness
            </p>
            <h1 class="mt-3 text-3xl md:text-4xl font-extrabold">
                Personal Trainer
            </h1>
            <p class="mt-3 text-sm md:text-base text-gray-400 max-w-2xl mx-auto">
                Temukan personal trainer yang paling cocok dengan tujuan latihan dan gaya
                latihanmu.
            </p>
        </div>

        {{-- SUBTITLE --}}
        <p class="text-gray-300 text-base mb-6">
            Temukan <span class="text-emerald-400 font-semibold">Personal Trainer</span> sesuai kebutuhan kamu:
        </p>

        {{-- GRID TRAINER --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">

            @forelse($trainers as $trainer)
                <div
                    class="rounded-2xl bg-[#0A0F24] border border-white/5 shadow-[0_18px_45px_rgba(0,0,0,0.7)]
                           p-5 flex flex-col items-center text-center">

                    {{-- Avatar --}}
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-4 ring-2 ring-emerald-500/60">
                        <img
                            src="{{ $trainer->foto
                                ? asset('storage/' . $trainer->foto)
                                : asset('images/trainer-default.png') }}"
                            alt="{{ $trainer->nama }}"
                            class="w-full h-full object-cover">
                    </div>

                    {{-- Nama --}}
                    <span
                        class="inline-flex px-4 py-1 rounded-full bg-white/5 text-sm font-semibold mb-3">
                        {{ $trainer->nama }}
                    </span>

                    {{-- Spesialis --}}
                    <div class="w-full rounded-xl bg-black/20 border border-white/5 px-4 py-3 mt-auto">
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">
                            Spesialis
                        </p>
                        <p class="text-sm font-semibold text-emerald-400">
                            {{ $trainer->spesialis ?? '-' }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-400">
                    Belum ada personal trainer tersedia.
                </div>
            @endforelse

        </div>

        {{-- CTA --}}
        <div class="mt-10 text-center">
            <p class="text-gray-400 text-sm mb-3">
                Belum yakin pilih trainer yang mana?
            </p>
            <a
                href="https://wa.me/6289509777727?text=Halo%20Thunder%20Fitness,%20saya%20ingin%20konsultasi%20pilih%20personal%20trainer."
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-6 py-2.5
                    text-sm font-semibold hover:bg-emerald-400 transition
                    shadow-lg shadow-emerald-500/30">
                Konsultasi Pilih Trainer
            </a>
        </div>
    </div>
</section>
@endsection
