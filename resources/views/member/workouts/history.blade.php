@extends('layouts.member')

@section('content')
<h1 class="text-2xl font-bold mb-6">History Latihan</h1>

<div class="space-y-4">

@forelse($histories as $tanggal => $items)

    {{-- CARD TANGGAL --}}
    <div class="rounded-2xl bg-[#0A0F24] border border-white/10 overflow-hidden">

        {{-- HEADER --}}
        <button
    type="button"
    class="w-full flex items-center justify-between px-6 py-4
           hover:bg-white/5 toggle-history">

    {{-- LEFT : ICON + TANGGAL --}}
    <div class="flex items-center gap-4">

        {{-- ICON KALENDER --}}
        <div class="flex items-center justify-center
                    w-10 h-10 rounded-full
                    bg-emerald-500/15 text-emerald-400">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-5 h-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8 7V3m8 4V3M5 11h14M5 19h14M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"/>
            </svg>
        </div>

        {{-- TEXT --}}
        <div>
            <span class="text-sm text-gray-400 -ml-22">Tanggal</span>
            <p class="font-semibold text-lg">
                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
    </div>

    {{-- RIGHT : CHEVRON --}}
    <svg class="w-5 h-5 text-gray-400 transition-transform duration-200 icon"
         fill="none" stroke="currentColor" stroke-width="2"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M19 9l-7 7-7-7" />
    </svg>
</button>


        {{-- DETAIL --}}
        <div class="history-detail hidden px-6 pb-6 space-y-4">

            @foreach($items as $item)
                <div class="rounded-xl bg-[#020617] border border-white/10 p-4">

                    <p class="font-semibold mb-3">
                        {{ $item['workout'] }}
                    </p>

                    <div class="space-y-2 text-sm text-gray-300">
                        @foreach($item['sets'] as $i => $set)
                            <div class="flex justify-between">
                                <span>Set {{ $i + 1 }}</span>
                                <span>
                                    {{ $set['beban'] }} kg · {{ $set['reps'] }} reps
                                </span>
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        </div>
    </div>

@empty
    <div class="text-center text-gray-400 py-12">
        Belum ada history latihan.
    </div>
@endforelse

</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.toggle-history').forEach(btn => {
        btn.addEventListener('click', () => {
            const card   = btn.closest('div');
            const detail = card.querySelector('.history-detail');
            const icon   = btn.querySelector('.icon');

            detail.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

});
</script>
@endsection
