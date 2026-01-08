@extends('layouts.admin')

@section('content')
<h1 class="text-2xl md:text-3xl font-extrabold mb-6">
    LAPORAN
</h1>

{{-- FILTER TANGGAL --}}
<form method="GET" class="mb-6">
    <div class="flex flex-wrap items-end gap-4">
        <div>
            <label class="text-sm text-gray-400">Dari Tanggal</label>
            <input type="date"
                   name="start_date"
                   value="{{ $startDate }}"
                   class="mt-1 px-3 py-2 rounded-lg
                          bg-[#020617] border border-white/10 text-white">
        </div>

        <div>
            <label class="text-sm text-gray-400">Sampai Tanggal</label>
            <input type="date"
                   name="end_date"
                   value="{{ $endDate }}"
                   class="mt-1 px-3 py-2 rounded-lg
                          bg-[#020617] border border-white/10 text-white">
        </div>

        <button type="submit"
                class="px-5 py-2 rounded-lg bg-emerald-500
                       font-semibold hover:bg-emerald-400">
            Tampilkan
        </button>
    </div>
</form>

{{-- SUMMARY CARD --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <p class="text-sm text-gray-400">Total Member</p>
        <p class="text-3xl font-bold mt-2">{{ $totalMember }}</p>
    </div>

    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <p class="text-sm text-gray-400">Total Trainer</p>
        <p class="text-3xl font-bold mt-2">{{ $totalTrainer }}</p>
    </div>

    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <p class="text-sm text-gray-400">Total Latihan</p>
        <p class="text-3xl font-bold mt-2">{{ $totalLatihan }}</p>
    </div>

</div>

{{-- TABEL LAPORAN --}}
<div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6 overflow-x-auto">

    <table class="min-w-full text-sm text-left">
        <thead class="border-b border-white/10 text-gray-400">
            <tr>
                <th class="py-3 pr-4">Tanggal</th>
                <th class="py-3 pr-4">Member</th>
                <th class="py-3 pr-4">Trainer</th>
                <th class="py-3 pr-4">Latihan</th>
                <th class="py-3 pr-4">Beban (kg)</th>
                <th class="py-3 pr-4">Reps</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
            @forelse($laporan as $row)
                <tr class="hover:bg-white/5">
                    <td class="py-3 pr-4">
                        {{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d M Y') }}
                    </td>
                    <td class="py-3 pr-4">{{ $row->nama_member }}</td>
                    <td class="py-3 pr-4">{{ $row->nama_trainer }}</td>
                    <td class="py-3 pr-4">{{ $row->nama_latihan }}</td>
                    <td class="py-3 pr-4">{{ $row->beban }}</td>
                    <td class="py-3 pr-4">{{ $row->reps }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="py-6 text-center text-gray-400">
                        Tidak ada data laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
