@extends('layouts.admin')

@section('content')
@php use Carbon\Carbon; @endphp

<h1 class="text-xl sm:text-2xl font-bold mb-6 tracking-wide">
    Kelola Member
</h1>

<div class="rounded-2xl bg-[#0A0F24] border border-white/10
            shadow-[0_20px_60px_rgba(0,0,0,0.6)] overflow-hidden">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between
            gap-3 px-4 sm:px-6 py-4 sm:py-5 border-b border-white/10">

    <h2 class="text-base sm:text-lg font-semibold">
        Data Member
    </h2>

    {{-- SEARCH --}}
    <div class="relative w-full sm:w-64">
        <input
            type="text"
            id="searchMember"
            placeholder="Cari member..."
            class="w-full px-4 py-2 rounded-xl
                   bg-[#020617] border border-white/10
                   text-sm text-white
                   focus:outline-none focus:ring-2 focus:ring-emerald-500"
        >

        <svg xmlns="http://www.w3.org/2000/svg"
             class="absolute right-3 top-1/2 -translate-y-1/2
                    h-4 w-4 text-gray-400 pointer-events-none"
             fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
        </svg>
    </div>
</div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-[900px] w-full text-sm">
            <thead class="bg-white/5 border-b border-white/10">
                <tr>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">ID</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">Nama</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">No Telp</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">Expired</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">PT</th>
                    <th class="px-4 sm:px-5 py-3 text-left font-semibold">Aksi</th>
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
                        <td class="px-4 sm:px-5 py-3 whitespace-nowrap">
                            {{ 'TF-' . str_pad($member->id_member, 3, '0', STR_PAD_LEFT) }}
                        </td>

                        <td class="px-4 sm:px-5 py-3 font-medium whitespace-nowrap">
                            {{ $member->nama }}
                        </td>

                        <td class="px-4 sm:px-5 py-3 whitespace-nowrap">
                            @if($member->telp)
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $member->telp);
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $cleanPhone }}" 
                                    target="_blank" 
                                    class="text-blue-400 hover:text-blue-300 flex items-center gap-1 transition-colors">
                                    {{ $member->telp }}
                                </a>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>

                        <td class="px-4 sm:px-5 py-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="px-4 sm:px-5 py-3 whitespace-nowrap">
                            {{ $expired ? $expired->translatedFormat('d/m/Y') : '-' }}
                        </td>

                        <td class="px-4 sm:px-5 py-3 whitespace-nowrap">
                            {{ $member->trainer?->nama ?? '-' }}
                        </td>

                        <td class="px-4 sm:px-5 py-3">
                            <div class="flex items-center gap-3 whitespace-nowrap">

                                <button
                                    class="text-emerald-400 text-xs font-semibold hover:underline editMemberBtn"
                                    data-id="{{ $member->id_member }}"
                                    data-nama="{{ $member->nama }}"
                                    data-telp="{{ $member->telp }}"
                                    data-tanggal_daftar="{{ $member->tanggal_daftar ? Carbon::parse($member->tanggal_daftar)->format('Y-m-d') : '' }}"
                                    data-aktif_hingga="{{ $member->aktif_hingga ? Carbon::parse($member->aktif_hingga)->format('Y-m-d') : '' }}"
                                    data-trainer_id="{{ $member->trainer_id }}">
                                    Edit
                                </button>
                                @if($canDelete)
                                    <button
                                        class="text-red-400 text-xs font-semibold hover:underline deleteMemberBtn"
                                        data-id="{{ $member->id_member }}"
                                        data-nama="{{ $member->nama }}">
                                        Hapus
                                    </button>
                                @else
                                    <span class="text-gray-500 text-xs cursor-not-allowed">
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
    {{--PAGINATION AREA--}}
    @if($members->hasPages())
        <div class="px-6 py-4 border-t border-white/10 bg-white/5">
            <div class="custom-pagination">
                {{ $members->links() }}
            </div>
        </div>
    @endif
</div>

{{-- MODAL --}}
<div id="editMemberModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm
            flex items-center justify-center z-50 hidden px-4">

    <div class="bg-[#0A0F24] rounded-2xl border border-white/10
                w-full max-w-xl p-5 sm:p-6 relative">

        <button id="closeEditMember"
                class="absolute right-4 top-4 text-gray-400 hover:text-white text-xl">
            ✕
        </button>

        <h2 class="text-base sm:text-lg font-semibold mb-6">
            Edit Data Member
        </h2>

        <form id="editMemberForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs text-gray-400 mb-1">Nama</label>
                <input type="text" name="nama" id="editMemberNama" required readonly
                       class="w-full px-4 py-2 rounded-xl bg-[#020617]
                              border border-white/10 text-white
                              focus:ring-2 focus:ring-emerald-500">
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">No Telp</label>
                <input type="text" name="telp" id="editMemberTelp" readonly
                       class="w-full px-4 py-2 rounded-xl bg-[#020617]
                              border border-white/10 text-white">
            </div>

            <div>
            <label class="block text-xs text-gray-400 mb-1">
                Ganti Password <span class="text-[10px] italic">(Kosongkan jika tidak ingin ganti)</span>
            </label>
            <div class="relative">
                <input type="password" name="password" id="editMemberPassword"
                    placeholder="Masukkan password baru"
                class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-white/10 text-white focus:ring-2 focus:ring-emerald-500 pr-10">
        
            {{-- TOMBOL MATA --}}
            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-emerald-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    {{-- Icon Mata Terbuka --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>
    </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs text-gray-400 mb-1">Tanggal Awal</label>
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
    const form = document.getElementById('editMemberForm');
    const deleteForm = document.getElementById('deleteMemberForm');
    const searchInput = document.getElementById('searchMember');
    const rows = document.querySelectorAll('tbody tr');

    // --- LOGIKA TOGGLE PASSWORD (EYE BUTTON) ---
    const passwordInput = document.getElementById('editMemberPassword');
    const toggleBtn = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    toggleBtn.addEventListener('click', () => {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';

        if (isPassword) {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
            `;
        } else {
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            `;
        }
    });

    // Fungsi Reset Form Password
    const resetPasswordFields = () => {
        passwordInput.value = '';
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
    };

    // --- LOGIKA SEARCH ---
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase().trim();
        rows.forEach(row => {
            const rowText = row.innerText.toLowerCase().replace(/\s+/g, ' ');
            const words = keyword.split(' ').filter(Boolean);
            const matched = words.every(word => rowText.includes(word));
            row.style.display = matched ? '' : 'none';
        });
    });

    // --- LOGIKA MODAL EDIT ---
    document.querySelectorAll('.editMemberBtn').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            form.action = `/admin/members/${id}`;
            
            // Isi data ke input modal
            document.getElementById('editMemberNama').value = btn.dataset.nama || '';
            document.getElementById('editMemberTelp').value = btn.dataset.telp || '';
            document.getElementById('editMemberTanggalDaftar').value = btn.dataset.tanggal_daftar || '';
            document.getElementById('editMemberAktifHingga').value = btn.dataset.aktif_hingga || '';
            document.getElementById('editMemberTrainer').value = btn.dataset.trainer_id || '';

            resetPasswordFields();

            modal.classList.remove('hidden');
        };
    });

    // Tutup Modal
    const closeModal = () => {
        modal.classList.add('hidden');
        resetPasswordFields(); 
    };

    document.getElementById('closeEditMember').onclick = closeModal;
    document.getElementById('cancelEditMember').onclick = closeModal;

    // --- LOGIKA DELETE ---
    document.querySelectorAll('.deleteMemberBtn').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
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
