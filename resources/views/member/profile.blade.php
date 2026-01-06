@extends('layouts.member')

@section('content')
<h1 class="text-2xl md:text-3xl font-extrabold mb-6">Profile</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- avatar + basic --}}
    <div class="col-span-1 rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <div class="flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.25)]">
                @if($foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Member" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/member.png') }}" alt="Avatar Member" class="w-full h-full object-cover">
                @endif
            </div>

            <h3 class="mt-4 text-lg font-semibold text-center">{{ $nama }}</h3>
            <p class="text-xs text-emerald-400 tracking-[0.2em] mt-1 uppercase">Member</p>

            <div class="mt-5 w-full space-y-2">
                <button id="openEditBtn" class="w-full inline-flex items-center justify-center rounded-full bg-white/10 px-4 py-2 text-sm font-medium hover:bg-white/20">
                    Edit Profil
                </button>

                <button id="openResetBtn" class="w-full inline-flex items-center justify-center rounded-full bg-white/6 px-4 py-2 text-sm font-medium hover:bg-white/10 border border-white/5">
                    Reset Password
                </button>
            </div>
        </div>
    </div>

    {{-- detail profil --}}
    <div class="col-span-2 rounded-2xl bg-[#0A0F24] border border-white/5 p-6 space-y-4">
        <h2 class="text-lg font-semibold">Informasi Pribadi</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400">Nama Lengkap</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $nama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">ID Member</p>
                <p class="mt-1 text-sm text-white font-medium">
                    {{ $idMember ? 'TF-' . str_pad($idMember, 3, '0', STR_PAD_LEFT) : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">No Telepon</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $member->telp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Alamat</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $member->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tinggi Badan</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $tinggi ? $tinggi . ' cm' : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Tanggal Lahir</p>
                <p class="mt-1 text-sm font-medium">
                    {{ $member->tanggal_lahir
                        ? \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d M Y')
                        : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Jenis Kelamin</p>
                <p class="mt-1 text-sm font-medium">
                    @if($member->jenis_kelamin === 'L')
                        Laki-laki
                    @elseif($member->jenis_kelamin === 'P')
                        Perempuan
                    @else
                        -
                    @endif
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Berat Badan</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $berat ? $berat . ' kg' : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Start Member</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $startMember ? $startMember->translatedFormat('d M Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Aktif Hingga</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $aktifHingga ? $aktifHingga->translatedFormat('d M Y') : '-' }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-xs text-gray-400">Personal Trainer</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $personalTrainer ?? '-' }}</p>
            </div>
        </div>
        {{-- badge status --}}
        <div class="mt-4">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClasses }}">
                {{ $statusText }}
            </span>
        </div>

        {{-- BMI ringkasan --}}
        <div class="mt-6 rounded-lg bg-[#081024] border border-white/5 p-4">
            <p class="text-sm font-semibold text-center">Body Mass Index (BMI)</p>
            <p class="text-center text-xs text-gray-300 mt-2">
                @if($bmi)
                    BMI: <span class="font-semibold text-white">{{ number_format($bmi,1) }}</span> ({{ $bmiCategory }})
                @else
                    Lengkapi tinggi & berat badan untuk melihat BMI.
                @endif
            </p>
        </div>
    </div>
</div>

    {{-- Modal edit--}}
    <div id="editProfileModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
        <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-lg p-6 relative">
            <button id="closeEditModal" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>
            <h3 class="text-lg font-semibold mb-4">Edit Profil</h3>

        <form action="{{ route('member.profile.update') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-4">
                @csrf
                @method('PUT')

            {{-- FOTO --}}
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full overflow-hidden">
                    <img src="{{ $foto ? asset('storage/'.$foto) : asset('images/member.png') }}"
                        class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <label class="block text-sm mb-1">Ganti Foto</label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-sm
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                       file:bg-emerald-500 file:text-white
                       hover:file:bg-emerald-400">
                    <p class="text-xs text-gray-400 mt-1">
                        Kosongkan jika tidak ingin mengubah.
                    </p>
                </div>
            </div>

            {{-- NAMA --}}
            <div>
                <label class="block text-sm mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $nama) }}" required
                    class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700">
            </div>

            {{-- TELP --}}
            <div>
                <label class="block text-sm mb-1">No Telepon</label>
                <input type="text" name="telp" value="{{ old('telp', $member->telp) }}"
                    class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700">
            </div>
            {{-- ALAMAT --}}
            <div>
                <label class="block text-sm mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700">{{ old('alamat', $member->alamat) }}</textarea>
            </div>

            {{-- TANGGAL LAHIR + JENIS KELAMIN --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm mb-1">Tanggal Lahir</label>
                    <input type="date"
                        name="tanggal_lahir"
                        value="{{ $member->tanggal_lahir }}"
                        class="w-full px-3 py-2 pr-12 rounded-lg
                        bg-[#020617] border border-gray-700
                            text-sm text-white
                            focus:ring-2 focus:ring-emerald-500
                            cursor-pointer"/>
                </div>
                <div>
                    <label class="block text-sm mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full px-3 py-2 rounded-lg
                            bg-[#020617] border border-gray-700
                            text-sm text-white
                            focus:ring-2 focus:ring-emerald-500">
                        <option value="">-</option>
                        <option value="L" {{ $member->jenis_kelamin === 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="P" {{ $member->jenis_kelamin === 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>
            </div>
        {{-- TINGGI + BERAT --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Tinggi Badan (cm)</label>
                <input type="number" name="tinggi_badan" min="1"
                   value="{{ old('tinggi_badan', $tinggi) }}"
                   class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700">
            </div>

            <div>
                <label class="block text-sm mb-1">Berat Badan (kg)</label>
                <input type="number" name="berat_badan" min="1"
                   value="{{ old('berat_badan', $berat) }}"
                   class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700">
            </div>
        </div>
        {{-- ACTION --}}
        <div class="flex justify-end gap-3 mt-6">
            <button type="button" id="cancelEdit"
                class="px-4 py-2 rounded-lg border border-white/10 text-sm">
                    Batal
            </button>
            <button type="submit"
                class="px-5 py-2 rounded-lg bg-emerald-500 text-sm font-semibold">
                    Simpan
            </button>
        </div>
        </form>
    </div>
</div>

{{-- Modal reset password --}}
<div id="resetPasswordModal" class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-md p-6 relative">
        <button id="closeResetModal" class="absolute top-4 right-4 text-gray-400 hover:text-white">✕</button>

        <h3 class="text-lg font-semibold mb-4">Reset Password</h3>

        {{-- Tampilkan pesan error khusus password --}}
        @if($errors->has('current_password') || $errors->has('password'))
            <div class="mb-3 text-sm text-red-400">
                @foreach($errors->getMessages() as $field => $msgs)
                    @if(in_array($field, ['current_password','password','password_confirmation']))
                        @foreach($msgs as $m)
                            <p>• {{ $m }}</p>
                        @endforeach
                    @endif
                @endforeach
            </div>
        @endif

        <form id="resetPasswordForm" action="{{ route('member.password.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm mb-1">Password Saat Ini</label>
                <input type="password" name="current_password" required class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700 text-sm" autocomplete="current-password">
            </div>

            <div>
                <label class="block text-sm mb-1">Password Baru</label>
                <input type="password" name="password" required minlength="6" class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700 text-sm" autocomplete="new-password">
            </div>

            <div>
                <label class="block text-sm mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" required minlength="6" class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700 text-sm" autocomplete="new-password">
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancelReset" class="px-4 py-2 rounded-lg border border-white/10 text-sm">Batal</button>
                <button type="button" id="confirmResetBtn" class="px-5 py-2 rounded-lg bg-emerald-500 text-sm font-semibold">Reset</button>
            </div>
        </form>
    </div>
</div>

{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const openEditBtn = document.getElementById('openEditBtn');
    const editModal = document.getElementById('editProfileModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEdit = document.getElementById('cancelEdit');

    const openEdit = () => editModal.classList.remove('hidden');
    const closeEdit = () => editModal.classList.add('hidden');

    if (openEditBtn) openEditBtn.addEventListener('click', openEdit);
    if (closeEditModal) closeEditModal.addEventListener('click', closeEdit);
    if (cancelEdit) cancelEdit.addEventListener('click', closeEdit);

    const openResetBtn = document.getElementById('openResetBtn');
    const resetModal = document.getElementById('resetPasswordModal');
    const closeResetModal = document.getElementById('closeResetModal');
    const cancelReset = document.getElementById('cancelReset');
    const confirmResetBtn = document.getElementById('confirmResetBtn');
    const resetForm = document.getElementById('resetPasswordForm');

    const openReset = () => resetModal.classList.remove('hidden');
    const closeReset = () => resetModal.classList.add('hidden');

    if (openResetBtn) openResetBtn.addEventListener('click', openReset);
    if (closeResetModal) closeResetModal.addEventListener('click', closeReset);
    if (cancelReset) cancelReset.addEventListener('click', closeReset);
    [editModal, resetModal].forEach(mod => {
        if (!mod) return;
        mod.addEventListener('click', (e) => {
            if (e.target === mod) mod.classList.add('hidden');
        });
    });

    // Konfirmasi sebelum reset password
    if (confirmResetBtn && resetForm) {
        confirmResetBtn.addEventListener('click', () => {
            Swal.fire({
                title: 'Yakin ingin mengganti password?',
                text: 'Password lama akan diganti dengan yang baru.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, ganti',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#6B7280',
                background: '#0A0F24',
                color: '#E5E7EB',
                customClass: { popup: 'rounded-2xl p-6' }
            }).then((res) => {
                if (res.isConfirmed) {
                    resetForm.submit();
                }
            });
        });
    }
    @if($errors->has('current_password') || $errors->has('password') || $errors->has('password_confirmation'))
        openReset();
    @endif
});
</script>

{{-- Notifikasi sukses dari session --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            title: 'Berhasil',
            html: {!! json_encode(session('success')) !!},
            background: '#0A0F24',
            color: '#ffffff',
            timer: 2200,
            showConfirmButton: false,
            backdrop: 'rgba(0,0,0,0.6)'
        });
    });
</script>
@endif
@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            title: 'Error',
            html: {!! json_encode(session('error')) !!},
            icon: 'error',
            background: '#0A0F24',
            color: '#ffffff',
            confirmButtonColor: '#EF4444'
        });
    });
</script>
@endif

@endsection
