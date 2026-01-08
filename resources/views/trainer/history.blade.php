@extends('layouts.trainer')

@section('content')
<h1 class="text-2xl font-bold mb-6">History Latihan Member</h1>

{{-- PILIH MEMBER --}}
<form method="GET"
      action="{{ isset($member)
            ? route('trainer.history.show', $member)
            : route('trainer.history.index') }}"
      class="mb-8">

    <label class="block text-sm text-gray-400 mb-2">
        Pilih Member
    </label>

    <select onchange="if(this.value) window.location.href = this.value"
        class="w-full max-w-md px-4 py-2 rounded-xl
               bg-[#020617] border border-white/10 text-white">

        <option value="">-- Pilih Member --</option>

        @foreach($members as $m)
            <option value="{{ route('trainer.history.show', $m) }}"
                {{ isset($member) && $member->id_member === $m->id_member ? 'selected' : '' }}>
                {{ $m->nama }}
            </option>
        @endforeach
    </select>
</form>

{{-- BELUM PILIH MEMBER --}}
@if(!$member)
    <div class="rounded-xl border border-white/10
                bg-[#0A0F24] p-6 text-gray-400">
        Silakan pilih member untuk melihat history latihan.
    </div>
@endif

{{-- HISTORY --}}
@if($member && $logs && $logs->count())
    <div class="space-y-8">

        @foreach($logs as $tanggal => $exercises)
            <div class="rounded-2xl bg-[#0A0F24]
                        border border-white/10 p-6">

                {{-- TANGGAL --}}
                <h2 class="text-lg font-semibold mb-4">
                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                </h2>

                {{-- EXERCISE --}}
                <div class="space-y-6">
                    @foreach($exercises as $namaLatihan => $sets)
                        <div class="rounded-xl bg-[#020617]
                                    border border-white/10 p-4">

                            <h3 class="font-semibold mb-3">
                                {{ $namaLatihan }}
                            </h3>

                            {{-- SET --}}
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-gray-300">
                                    <thead class="text-gray-400">
                                        <tr>
                                            <th class="text-left py-2">Set</th>
                                            <th class="text-left py-2">Beban (kg)</th>
                                            <th class="text-left py-2">Reps</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sets as $set)
                                            <tr class="border-t border-white/10">
                                                <td class="py-2">
                                                    {{ $set->jumlah_set }}
                                                </td>
                                                <td class="py-2">
                                                    {{ $set->beban }}
                                                </td>
                                                <td class="py-2">
                                                    {{ $set->reps }}
                                                </td>
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
    <div class="rounded-xl border border-white/10
                bg-[#0A0F24] p-6 text-gray-400">
        Belum ada history latihan untuk member ini.
    </div>
@endif
@endsection
