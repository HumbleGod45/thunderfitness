@extends('layouts.admin')

@section('content')
@php use Carbon\Carbon; @endphp

<h1 class="text-2xl font-bold mb-6 tracking-wide">Kelola Member</h1>

<div class="rounded-2xl bg-[#0A0F24] border border-white/10
            shadow-[0_20px_60px_rgba(0,0,0,0.6)] overflow-hidden">

    <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
        <h2 class="text-lg font-semibold">Data Member</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-white/5 border-b border-white/10">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold">ID</th>
                    <th class="px-5 py-3 text-left font-semibold">Nama</th>
                    <th class="px-5 py-3 text-left font-semibold">No Telp</th>
                    <th class="px-5 py-3 text-left font-semibold">Status</th>
                    <th class="px-5 py-3 text-left font-semibold">Expired</th>
                    <th class="px-5 py-3 text-left font-semibold">PT</th>
                    <th class="px-5 py-3 text-left font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/10">
                @forelse($members as $member)

                    @php
                        $expired = $member->aktif_hingga
                            ? Carbon::parse($member->aktif_hingga)
                            : null;

                        if (!$expired) {
                            $statusLabel = 'Belum Aktif';
                            $badgeClass  = 'bg-gray-500/20 text-gray-300';
                            $canDelete   = true;
                        } elseif ($expired->isFuture() || $expired->isToday()) {
                            $statusLabel = 'Aktif';
                            $badgeClass  = 'bg-emerald-400/15 text-emerald-300';
                            $canDelete   = false;
                        } else {
                            $statusLabel = 'Tidak Aktif';
                            $badgeClass  = 'bg-red-400/15 text-red-300';
                            $canDelete   = true;
                        }
                    @endphp

                    <tr class="hover:bg-white/5">
                        <td class="px-5 py-3">
                            {{ 'TF-' . str_pad($member->id_member, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-5 py-3 font-medium">
                            {{ $member->nama }}
                        </td>

                        <td class="px-5 py-3">
                            {{ $member->telp ?? '-' }}
                        </td>

                        <td class="px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="px-5 py-3">
                            {{ $expired ? $expired->translatedFormat('d/m/Y') : '-' }}
                        </td>

                        <td class="px-5 py-3">
                            {{ $member->trainer?->nama ?? '-' }}
                        </td>

                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">

                                {{-- EDIT --}}
                                <button
                                    class="text-emerald-400 text-xs font-semibold hover:underline editMemberBtn"
                                    data-id="{{ $member->id_member }}"
                                    data-nama="{{ $member->nama }}"
                                    data-telp="{{ $member->telp }}"
                                    data-tanggal_daftar="{{ $member->tanggal_daftar }}"
                                    data-aktif_hingga="{{ $member->aktif_hingga }}"
                                    data-trainer_id="{{ $member->trainer_id }}">
                                    Edit
                                </button>

                                {{-- DELETE --}}
                                @if($canDelete)
                                    <button
                                        class="text-red-400 text-xs font-semibold hover:underline deleteMemberBtn"
                                        data-id="{{ $member->id_member }}"
                                        data-nama="{{ $member->nama }}">
                                        Hapus
                                    </button>
                                @else
                                    <span
                                        class="text-gray-500 text-xs cursor-not-allowed"
                                        title="Member masih aktif">
                                        Hapus
                                    </span>
                                @endif

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-6 text-center text-gray-400">
                            Belum ada data member.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL EDIT MEMBER ================= --}}
<div id="editMemberModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm
            flex items-center justify-center z-50 hidden">

    <div class="bg-[#0A0F24] rounded-2xl border border-white/10
                w-full max-w-xl p-6 relative">

        <button id="closeEditMember"
                class="absolute right-4 top-4 text-gray-400 hover:text-white text-xl">
            ✕
        </button>

        <h2 class="text-lg font-semibold mb-6">Edit Data Member</h2>

        <form id="editMemberForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-gray-400 mb-1">Nama</label>
                <input type="text" name="nama" id="editMemberNama" required
                       class="w-full px-4 py-2 rounded-xl bg-[#020617]
                              border border-white/10 text-white
                              focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">No Telp</label>
                <input type="text" name="telp" id="editMemberTelp"
                       class="w-full px-4 py-2 rounded-xl bg-[#020617]
                              border border-white/10 text-white
                              focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Tanggal Daftar</label>
                    <input type="date" name="tanggal_daftar" id="editMemberTanggalDaftar"
                           class="date-input w-full px-4 py-2 rounded-xl bg-[#020617]
                                  border border-white/10 text-white">
                </div>

                <div>
                    <label class="block text-xs text-gray-400 mb-1">Aktif Hingga</label>
                    <input type="date" name="aktif_hingga" id="editMemberAktifHingga"
                           class="date-input w-full px-4 py-2 rounded-xl bg-[#020617]
                                  border border-white/10 text-white">
                </div>
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Personal Trainer</label>
                <select name="trainer_id" id="editMemberTrainer"
                        class="w-full px-4 py-2 rounded-xl bg-[#020617]
                               border border-white/10 text-white">
                    <option value="">-</option>
                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->id_trainer }}">
                            {{ $trainer->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-6">
                <button type="button" id="cancelEditMember"
                        class="px-4 py-2 rounded-xl border border-white/10 text-gray-300">
                    Batal
                </button>

                <button type="submit"
                        class="px-6 py-2 rounded-xl bg-emerald-500
                               font-semibold text-white hover:bg-emerald-400">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- FORM DELETE --}}
<form id="deleteMemberForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

{{-- FIX ICON DATE --}}
<style>
.date-input::-webkit-calendar-picker-indicator {
    filter: invert(1);
    opacity: .85;
    cursor: pointer;
}
</style>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    title: 'Berhasil',
    text: {!! json_encode(session('success')) !!},
    icon: 'success',
    background: '#0A0F24',
    color: '#fff',
    timer: 2200,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    title: 'Gagal',
    text: {!! json_encode(session('error')) !!},
    icon: 'error',
    background: '#0A0F24',
    color: '#fff',
    confirmButtonColor: '#EF4444'
});
</script>
@endif

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('editMemberModal');
    const form  = document.getElementById('editMemberForm');
    const deleteForm = document.getElementById('deleteMemberForm');

    document.querySelectorAll('.editMemberBtn').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;

            form.action = `/admin/members/${id}`;
            editMemberNama.value          = btn.dataset.nama || '';
            editMemberTelp.value          = btn.dataset.telp || '';
            editMemberTanggalDaftar.value = btn.dataset.tanggal_daftar || '';
            editMemberAktifHingga.value   = btn.dataset.aktif_hingga || '';
            editMemberTrainer.value       = btn.dataset.trainer_id || '';

            modal.classList.remove('hidden');
        };
    });

    closeEditMember.onclick =
    cancelEditMember.onclick = () => modal.classList.add('hidden');

    document.querySelectorAll('.deleteMemberBtn').forEach(btn => {
        btn.onclick = () => {
            const id   = btn.dataset.id;
            const nama = btn.dataset.nama;

            Swal.fire({
                title: 'Yakin mau menghapus member?',
                text: `Member "${nama}" akan dihapus permanen.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#6B7280',
                background: '#0A0F24',
                color: '#fff'
            }).then(res => {
                if (res.isConfirmed) {
                    deleteForm.action = `/admin/members/${id}`;
                    deleteForm.submit();
                }
            });
        };
    });
});
</script>

@endsection
