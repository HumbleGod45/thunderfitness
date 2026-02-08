@extends('layouts.trainer')

@section('content')
<h1 class="text-2xl font-bold mb-6">History Latihan Member</h1>

{{-- PILIH MEMBER --}}
<form method="GET"
      action="{{ isset($member) ? route('trainer.history.show', $member) : route('trainer.history.index') }}"
      class="mb-8">

    {{-- PILIH MEMBER --}}
<div class="mb-8">
    <label class="block text-sm text-gray-400 mb-2">Pilih Member</label>

    <div class="flex items-center gap-2">
        {{-- Dropdown Select --}}
        <div class="relative flex-1 max-w-md">
            <select onchange="if(this.value) window.location.href = this.value"
                class="w-full px-4 py-2.5 rounded-xl bg-[#020617] border border-white/10 text-white focus:border-emerald-500 outline-none transition-all appearance-none cursor-pointer">
                <option value="">-- Pilih Member --</option>
                @foreach($members as $m)
                    <option value="{{ route('trainer.history.show', $m) }}"
                        {{ isset($member) && $member->id_member === $m->id_member ? 'selected' : '' }}>
                        {{ $m->nama }}
                    </option>
                @endforeach
            </select>
            {{-- Icon Panah Dropdown --}}
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        {{-- Tombol Reset Kecil --}}
        @if(isset($member))
            <a href="{{ route('trainer.history.index') }}" 
               title="Reset Filter"
               class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-white hover:bg-red-500/20 hover:border-red-500/50 transition-all flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </a>
        @endif
    </div>
</div>
</form>

{{-- BELUM PILIH MEMBER --}}
@if(!$member)
    <div class="rounded-xl border border-white/10 bg-[#0A0F24] p-6 text-gray-400">
        Silakan pilih member untuk melihat history latihan.
    </div>
@endif

{{-- HISTORY DENGAN ACCORDION --}}
@if($member && $logs && $logs->count())
    <div class="space-y-4">
        @foreach($logs as $tanggal => $exercises)
            <div class="rounded-2xl bg-[#0A0F24] border border-white/10 overflow-hidden shadow-sm">
                
                {{-- HEADER ACCORDION (TANGGAL) --}}
                <button onclick="toggleAccordion('content-{{ $loop->index }}', 'icon-{{ $loop->index }}')" 
                    class="w-full px-6 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors focus:outline-none">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 19h14M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h2 class="text-lg font-semibold text-white">
                                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                            </h2>
                            <p class="text-xs text-gray-500 uppercase tracking-tighter">
                                {{ count($exercises) }} Jenis Latihan
                            </p>
                        </div>
                    </div>
                    <svg id="icon-{{ $loop->index }}" class="w-5 h-5 text-gray-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                {{-- KONTEN ACCORDION --}}
                <div id="content-{{ $loop->index }}" class="hidden border-t border-white/5 bg-[#020617]/20 p-6 space-y-6">
                    @foreach($exercises as $namaLatihan => $sets)
                        <div class="rounded-xl bg-[#020617] border border-white/10 p-4">
                            <h3 class="font-semibold mb-3 text-emerald-400">
                                {{ $namaLatihan }}
                            </h3>

                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-gray-300">
                                    <thead class="text-gray-500 text-xs uppercase tracking-wider">
                                        <tr>
                                            <th class="text-left py-2 border-b border-white/5">Set</th>
                                            <th class="text-left py-2 border-b border-white/5">Beban (kg)</th>
                                            <th class="text-left py-2 border-b border-white/5">Reps</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-white/5">
                                        @foreach($sets as $set)
                                            <tr>
                                                <td class="py-2 text-gray-400 font-mono">{{ $set->jumlah_set }}</td>
                                                <td class="py-2 text-white font-bold">{{ $set->beban }} kg</td>
                                                <td class="py-2 text-white font-bold">{{ $set->reps }}x</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- TIDAK ADA DATA --}}
@if($member && (!$logs || !$logs->count()))
    <div class="rounded-xl border border-white/10 bg-[#0A0F24] p-6 text-gray-400">
        Belum ada history latihan untuk member ini.
    </div>
@endif

{{-- SCRIPT ACCORDION --}}
<script>
    function toggleAccordion(id, iconId) {
        const content = document.getElementById(id);
        const icon = document.getElementById(iconId);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection