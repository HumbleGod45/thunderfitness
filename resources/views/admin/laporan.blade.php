@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-2">
    {{-- TITLE SECTION --}}
    <div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div>
            <h1 class="text-xl font-bold tracking-tight text-white uppercase">Laporan Aktivitas</h1>
            <p class="text-[11px] text-slate-500 mt-0.5 uppercase tracking-wider font-medium italic">Thunder Fitness Management System</p>
        </div>

        {{-- Laporan Keuangan --}}
        <div class="bg-[#0A0F24] border border-white/10 rounded-2xl px-6 py-4 flex items-center gap-5 shadow-sm">
            <div class="w-10 h-10 rounded-full bg-emerald-500/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">{{ $pendapatanTitle }}</p>
                <p class="text-2xl font-medium text-white tracking-tight">
                    <span class="text-slate-400 text-lg font-light mr-1">Rp</span>{{ number_format($pendapatan, 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER BOX --}}
    <div class="bg-[#0A0F24] rounded-2xl border border-white/5 p-4 mb-6 shadow-xl">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5 tracking-widest ml-1">Member</label>
                <div class="relative">
                    <select name="member_id" class="w-full pl-3 pr-8 py-2 rounded-xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 outline-none text-xs transition-all appearance-none">
                        <option value="">-- Semua --</option>
                        @foreach($allMembers as $m)
                            <option value="{{ $m->id_member }}" {{ request('member_id') == $m->id_member ? 'selected' : '' }}>{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5 tracking-widest ml-1">Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-3 py-2 rounded-xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 outline-none text-xs">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5 tracking-widest ml-1">Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-3 py-2 rounded-xl bg-[#020617] border border-white/10 text-slate-200 focus:border-emerald-500/50 outline-none text-xs">
            </div>
            <button type="submit" class="py-2.5 rounded-xl bg-emerald-600 text-white text-[11px] font-black uppercase tracking-widest hover:bg-emerald-500 transition-all active:scale-95">
                FILTER DATA
            </button>
        </form>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
        @php
            $stats = [
                ['label' => 'Total Member', 'val' => $totalMember, 'color' => 'slate'],
                ['label' => 'Aktif', 'val' => $memberAktif, 'color' => 'emerald'],
                ['label' => 'Non-Aktif', 'val' => $memberBelumAktif, 'color' => 'rose'],
                ['label' => 'Trainer', 'val' => $totalTrainer, 'color' => 'sky'],
                ['label' => 'Latihan', 'val' => $totalLatihan, 'color' => 'violet'],
            ];
        @endphp
        @foreach($stats as $s)
        <div class="bg-[#0A0F24] border border-white/5 p-4 rounded-2xl flex flex-col items-center justify-center">
            <p class="text-[9px] font-bold text-{{$s['color']}}-500/80 uppercase tracking-widest mb-1">{{ $s['label'] }}</p>
            <p class="text-2xl font-black text-white tracking-tighter">{{ $s['val'] }}</p>
        </div>
        @endforeach
        
    </div>

    {{-- DYNAMIC GRAFIK --}}
    <div class="mb-6 bg-[#0A0F24] border border-white/5 rounded-2xl p-5 shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em]">Tren Kunjungan</h2>
            <div class="flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-[9px] text-slate-500 font-bold uppercase">Member</span>
            </div>
        </div>
        <div class="h-[180px] w-full"> {{-- Tinggi dikurangi dari 300px ke 180px --}}
            <canvas id="visitChart"></canvas>
        </div>
    </div>

    {{-- DYNAMIC LEADERBOARD --}}
    <div class="mb-6">
        <div class="flex items-center gap-2 mb-4">
            <h2 class="text-[10px] font-bold text-emerald-500 uppercase tracking-[0.2em] whitespace-nowrap">{{ $leaderboardTitle }}</h2>
            <div class="h-px w-full bg-white/5"></div>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            @forelse($topMembers as $index => $m)
                <div class="bg-[#0A0F24] border border-white/5 p-3 rounded-2xl relative overflow-hidden group">
                    <div class="absolute top-2 right-3 font-black text-lg {{ $index == 0 ? 'text-yellow-500/20' : 'text-white/5' }}">#{{ $index + 1 }}</div>
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full overflow-hidden border {{ $index == 0 ? 'border-yellow-500' : 'border-emerald-500/30' }} mb-2">
                            <img src="{{ $m->foto ? asset('storage/'.$m->foto) : asset('images/member.png') }}" class="w-full h-full object-cover">
                        </div>
                        <h4 class="text-[10px] font-bold text-white truncate w-full text-center">{{ $m->nama }}</h4>
                        <p class="text-[9px] font-black text-emerald-400 mt-1">{{ $m->total_aktivitas }} <span class="opacity-50">LATIHAN</span></p>
                    </div>
                </div>
            @empty
                <div class="col-span-5 py-6 text-center bg-white/5 rounded-2xl border border-dashed border-white/10">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest">No Data</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- LOG DETAIL --}}
    @if($isFiltering)
        <div class="space-y-3">
            <h2 class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mb-3 text-center">Detail Log Aktivitas</h2>
            @php $groupedLaporan = $laporan->groupBy('tanggal'); @endphp
            @forelse($groupedLaporan as $tanggal => $rowsByDate)
                <div class="bg-[#0A0F24] rounded-xl border border-white/5 overflow-hidden">
                    <button onclick="toggleAccordion('content-{{ $loop->index }}', 'icon-{{ $loop->index }}')" class="w-full px-5 py-3 flex items-center justify-between hover:bg-white/[0.02]">
                        <div class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded-lg bg-[#020617] border border-white/5 flex items-center justify-center text-emerald-500/60 shadow-inner">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 19h14M5 7h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V9a2 2 0 012-2z"></path></svg>
                            </div>
                            <div class="text-left">
                                <h3 class="font-bold text-slate-200 text-sm tracking-tight">{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d M Y') }}</h3>
                                <p class="text-[9px] text-slate-500 font-medium uppercase">{{ $rowsByDate->count() }} Entri</p>
                            </div>
                        </div>
                        <div id="icon-{{ $loop->index }}" class="text-slate-500 transition-all duration-300">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </button>
                    <div id="content-{{ $loop->index }}" class="hidden border-t border-white/5 bg-[#020617]/30 p-4">
                        @foreach($rowsByDate->groupBy('nama_member') as $namaMember => $activities)
                            <div class="mb-4 last:mb-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-[11px] font-black text-white uppercase">{{ $namaMember }}</h4>
                                    <span class="text-[9px] text-slate-500">Coach: {{ $activities->first()->nama_trainer ?? 'Mandiri' }}</span>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                    @foreach($activities->groupBy('nama_latihan') as $namaLatihan => $sets)
                                        <div class="bg-[#0A0F24] rounded-lg border border-white/5 p-3">
                                            <h5 class="text-[10px] font-bold text-emerald-400 mb-2 italic">{{ $namaLatihan }}</h5>
                                            <div class="space-y-1">
                                                @foreach($sets as $idx => $set)
                                                    <div class="flex justify-between text-[9px] text-slate-400">
                                                        <span>Set {{ $idx + 1 }}</span>
                                                        <span class="text-white font-bold">{{ $set->beban }}kg • {{ $set->reps }} reps</span>
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
            @empty
                <div class="py-10 text-center text-slate-500 italic text-[10px]">Pilih member untuk detail.</div>
            @endforelse
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function toggleAccordion(id, iconId) {
        const content = document.getElementById(id);
        const icon = document.getElementById(iconId);
        content.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('visitChart').getContext('2d');
        const labels = {!! json_encode($chartLabels) !!};
        const dataPoints = {!! json_encode($chartData) !!};
        const chartType = labels.length > 31 ? 'line' : 'bar';

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    data: dataPoints,
                    backgroundColor: chartType === 'bar' ? 'rgba(16, 185, 129, 0.4)' : 'rgba(16, 185, 129, 0.05)',
                    borderColor: '#10b981',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: chartType === 'line' ? 2 : 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255, 255, 255, 0.05)' }, ticks: { color: '#475569', font: { size: 9 } } },
                    x: { grid: { display: false }, ticks: { color: '#475569', font: { size: 9 } } }
                }
            }
        });
    });
</script>
@endsection