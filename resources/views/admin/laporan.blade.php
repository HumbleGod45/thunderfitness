@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    {{-- TITLE SECTION --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-white uppercase">Statistik & Laporan Aktivitas</h1>
        <p class="text-sm text-slate-400 mt-1">Pantau performa dan keaktifan member Thunder Fitness.</p>
    </div>

    {{-- FILTER BOX --}}
    <div class="bg-[#0A0F24] rounded-3xl border border-white/5 p-6 mb-8 shadow-2xl shadow-black/20">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2 tracking-widest ml-1">Pilih Member</label>
                <div class="relative">
                    <select name="member_id" class="w-full pl-4 pr-10 py-3 rounded-2xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 focus:ring-4 focus:ring-emerald-500/5 outline-none text-sm appearance-none transition-all">
                        <option value="">-- Semua Member --</option>
                        @foreach($allMembers as $m)
                            <option value="{{ $m->id_member }}" {{ request('member_id') == $m->id_member ? 'selected' : '' }}>{{ $m->nama }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2 tracking-widest ml-1">Rentang Awal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-3 rounded-2xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 outline-none text-sm transition-all">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase mb-2 tracking-widest ml-1">Rentang Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-3 rounded-2xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 outline-none text-sm transition-all">
            </div>
            <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-600/90 text-white font-bold hover:bg-emerald-500 transition-all shadow-lg shadow-emerald-900/20 text-sm tracking-wide active:scale-95">
                Tampilkan Data
            </button>
        </form>
    </div>

    {{-- SUMMARY CARDS (STATISTIK) --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
        @php
            $stats = [
                ['label' => 'Total Member', 'val' => $totalMember, 'color' => 'slate'],
                ['label' => 'Member Aktif', 'val' => $memberAktif, 'color' => 'emerald'],
                ['label' => 'Non-Aktif', 'val' => $memberBelumAktif, 'color' => 'rose'],
                ['label' => 'Total Trainer', 'val' => $totalTrainer, 'color' => 'sky'],
                ['label' => 'Total Latihan', 'val' => $totalLatihan, 'color' => 'violet'],
            ];
        @endphp

        @foreach($stats as $s)
        <div class="bg-[#0A0F24] border border-white/5 p-5 rounded-[2rem] flex flex-col items-center justify-center transition-transform hover:scale-105">
            <p class="text-[10px] font-bold text-{{$s['color']}}-500/80 uppercase tracking-[0.2em] mb-1">{{ $s['label'] }}</p>
            <p class="text-4xl font-black text-white tracking-tighter">{{ $s['val'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- HASIL FILTER --}}
    @if($isFiltering)
        <div class="relative">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-px flex-1 bg-white/5"></div>
                <h2 class="text-xs font-bold text-slate-500 uppercase tracking-[0.3em]">Log Aktivitas Terkini</h2>
                <div class="h-px flex-1 bg-white/5"></div>
            </div>

            <div class="space-y-4">
                @php $groupedLaporan = $laporan->groupBy('tanggal'); @endphp

                @forelse($groupedLaporan as $tanggal => $rowsByDate)
                    <div class="bg-[#0A0F24] rounded-3xl border border-white/5 overflow-hidden group">
                        {{-- Tombol Accordion Tanggal --}}
                        <button onclick="toggleAccordion('content-{{ $loop->index }}', 'icon-{{ $loop->index }}')" 
                            class="w-full px-8 py-5 flex items-center justify-between hover:bg-white/[0.02] transition-all">
                            <div class="flex items-center gap-6">
                                <div class="w-12 h-12 rounded-2xl bg-[#020617] border border-white/5 flex items-center justify-center text-emerald-500/60 shadow-inner group-hover:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 19h14M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"></path></svg>
                                </div>
                                <div class="text-left">
                                    <h3 class="font-bold text-slate-200 text-lg tracking-tight">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h3>
                                    <p class="text-[11px] text-slate-500 font-medium uppercase tracking-widest">{{ $rowsByDate->count() }} Entri Latihan</p>
                                </div>
                            </div>
                            <div id="icon-{{ $loop->index }}" class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-slate-500 transition-all duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </button>

                        {{-- Konten Dropdown --}}
                        <div id="content-{{ $loop->index }}" class="hidden border-t border-white/5 bg-[#020617]/30">
                            <div class="p-6 space-y-8">
                                @foreach($rowsByDate->groupBy('nama_member') as $namaMember => $activities)
                                    <div class="space-y-4">
                                        {{-- Nama Member Header --}}
                                        <div class="flex items-center gap-3 ml-1">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                                            <h4 class="text-sm font-black text-white uppercase tracking-tighter">{{ $namaMember }}</h4>
                                            <span class="text-[10px] text-slate-500 font-bold ml-auto uppercase tracking-widest">Coach: {{ $activities->first()->nama_trainer ?? 'Mandiri' }}</span>
                                        </div>

                                        {{-- Grid Latihan per Jenis --}}
                                        <div class="grid grid-cols-1 gap-3">
                                            @foreach($activities->groupBy('nama_latihan') as $namaLatihan => $sets)
                                                <div class="bg-[#0A0F24]/80 rounded-2xl border border-white/5 p-5 transition-all hover:border-white/10">
                                                    <div class="flex justify-between items-center mb-3">
                                                        <h5 class="text-sm font-bold text-emerald-400 tracking-tight">{{ $namaLatihan }}</h5>
                                                    </div>
                                                    
                                                    <div class="space-y-2">
                                                        @foreach($sets as $idx => $set)
                                                            <div class="flex justify-between items-center text-xs">
                                                                <span class="text-slate-500 font-medium">Set {{ $idx + 1 }}</span>
                                                                <div class="flex items-center gap-2">
                                                                    <span class="text-slate-200 font-bold">{{ $set->beban }} <span class="text-[10px] text-slate-500 font-normal">kg</span></span>
                                                                    <span class="text-slate-600">•</span>
                                                                    <span class="text-slate-200 font-bold">{{ $set->reps }} <span class="text-[10px] text-slate-500 font-normal">reps</span></span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500 italic text-sm">Tidak ada data yang cocok dengan kriteria filter.</div>
                @endforelse
            </div>
        </div>
    @else
        {{-- EMPTY STATE (Belum Filter) --}}
        <div class="py-24 flex flex-col items-center justify-center">
            <div class="w-20 h-20 rounded-full bg-white/5 flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Gunakan filter di atas untuk menarik data log aktivitas.</p>
        </div>
    @endif
</div>

<script>
    function toggleAccordion(id, iconId) {
        const content = document.getElementById(id);
        const iconContainer = document.getElementById(iconId);
        const icon = iconContainer.querySelector('svg');
        
        content.classList.toggle('hidden');
        if (!content.classList.contains('hidden')) {
            iconContainer.classList.add('bg-emerald-500/10', 'text-emerald-500');
            icon.classList.add('rotate-180');
        } else {
            iconContainer.classList.remove('bg-emerald-500/10', 'text-emerald-500');
            icon.classList.remove('rotate-180');
        }
    }
</script>
@endsection