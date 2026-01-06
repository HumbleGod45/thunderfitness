@extends('layouts.trainer')

@section('content')
<h1 class="text-2xl md:text-3xl font-extrabold mb-6">Profile</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ================= LEFT: AVATAR ================= --}}
    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <div class="flex flex-col items-center">

            <div class="w-32 h-32 rounded-full overflow-hidden
                        ring-4 ring-emerald-400/30 shadow-lg">
                <img
                    src="{{ $trainer->foto
                        ? asset('storage/'.$trainer->foto)
                        : asset('images/trainer-default.png') }}"
                    class="w-full h-full object-cover">
            </div>

            <h3 class="mt-4 text-lg font-semibold">{{ $trainer->nama }}</h3>
            <p class="text-xs text-emerald-400 tracking-widest uppercase mt-1">
                Trainer
            </p>

            <div class="mt-6 w-full space-y-3">
                <button id="openEditTrainer"
                    class="w-full py-2 rounded-full bg-white/10 hover:bg-white/20
                           text-sm font-medium transition">
                    Edit Profil
                </button>

                <button id="openResetPassword"
                    class="w-full py-2 rounded-full bg-white/5 hover:bg-white/10
                           text-sm border border-white/10 transition">
                    Reset Password
                </button>
            </div>
        </div>
    </div>

    {{-- ================= RIGHT: INFO ================= --}}
    <div class="lg:col-span-2 rounded-2xl bg-[#0A0F24] border border-white/5 p-6">
        <h2 class="text-lg font-semibold mb-6">Informasi Pribadi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-6 text-sm">

            <div>
                <p class="text-gray-400 mb-1">Nama Lengkap</p>
                <p class="font-medium">{{ $trainer->nama }}</p>
            </div>

            <div>
                <p class="text-gray-400 mb-1">Email</p>
                <p class="font-medium">{{ $user->email }}</p>
            </div>

            <div>
                <p class="text-gray-400 mb-1">No Telepon</p>
                <p class="font-medium">{{ $trainer->telp ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400 mb-1">Pengalaman</p>
                <p class="font-medium">{{ $trainer->pengalaman_tahun ?? '-' }} Tahun</p>
            </div>

            <div class="sm:col-span-2">
                <p class="text-gray-400 mb-1">Spesialisasi</p>
                <p class="font-medium">{{ $trainer->spesialis ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400 mb-1">Bergabung Sejak</p>
                <p class="font-medium">
                    {{ optional($trainer->created_at)->translatedFormat('d M Y') }}
                </p>
            </div>

            <div>
                <p class="text-gray-400 mb-1">Jumlah Member</p>
                <p class="font-medium">{{ $trainer->members()->count() }} Member</p>
            </div>

        </div>
    </div>
</div>

{{-- ================= MODAL EDIT PROFIL ================= --}}
<div id="editTrainerModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm
            flex items-center justify-center z-50 hidden">

    <div class="relative w-full max-w-lg rounded-3xl
                bg-gradient-to-br from-[#0B1024] to-[#050816]
                border border-white/10 p-8">

        <button id="closeEditTrainer"
            class="absolute top-4 right-4 w-9 h-9 rounded-full
                   flex items-center justify-center
                   text-gray-400 hover:text-white hover:bg-white/10">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-6">Edit Profil</h3>

        <form action="{{ route('trainer.profile.update') }}"
              method="POST" enctype="multipart/form-data"
              class="space-y-4">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full overflow-hidden">
                    <img src="{{ $trainer->foto ? asset('storage/'.$trainer->foto) : asset('images/trainer-default.png') }}"
                         class="w-full h-full object-cover">
                </div>
                <input type="file" name="foto" accept="image/*"
                       class="w-full text-sm file:mr-3 file:px-4 file:py-2
                              file:rounded-lg file:border-0
                              file:bg-emerald-500 file:text-white">
            </div>

            <input type="text" name="nama" value="{{ old('nama', $trainer->nama) }}"
                class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700"
                placeholder="Nama Lengkap">

            <input type="text" name="telp" value="{{ old('telp', $trainer->telp) }}"
                class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700"
                placeholder="No Telepon">

            <input type="text" name="spesialis" value="{{ old('spesialis', $trainer->spesialis) }}"
                class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700"
                placeholder="Spesialisasi">

            <input type="number" min="0" name="pengalaman_tahun"
                value="{{ old('pengalaman_tahun', $trainer->pengalaman_tahun) }}"
                class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700"
                placeholder="Pengalaman (Tahun)">

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" id="cancelEditTrainer"
                    class="px-4 py-2 rounded-full border border-white/15 text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-emerald-500 text-sm font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL RESET PASSWORD ================= --}}
<div id="resetPasswordModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm
            flex items-center justify-center z-50 hidden">

    <div class="relative w-full max-w-md rounded-3xl
                bg-gradient-to-br from-[#0B1024] to-[#050816]
                border border-white/10 p-8">

        <button id="closeResetPassword"
            class="absolute top-4 right-4 w-9 h-9 rounded-full
                   flex items-center justify-center
                   text-gray-400 hover:text-white hover:bg-white/10">
            ✕
        </button>

        <h3 class="text-lg font-semibold mb-6">Reset Password</h3>

        <form method="POST" action="{{ route('trainer.profile.reset-password') }}"
              class="space-y-4">
            @csrf
            @method('PUT')

            @foreach ([
                'current_password' => 'Password Saat Ini',
                'password' => 'Password Baru',
                'password_confirmation' => 'Konfirmasi Password Baru'
            ] as $name => $label)

            <div class="relative">
                <label class="text-sm">{{ $label }}</label>

                <input type="password" name="{{ $name }}"
                    class="password-input w-full px-3 py-2 pr-11 rounded-lg
                           bg-[#020617] border border-gray-700">

                <button type="button"
                    class="toggle-password absolute right-3 top-9
                           text-gray-400 hover:text-emerald-400 transition">

                    {{-- eye closed --}}
                    <svg class="eye-closed w-5 h-5"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M3 3l18 18"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M10.58 10.58a3 3 0 004.24 4.24"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                               c4.478 0 8.268 2.943 9.542 7"/>
                    </svg>

                    {{-- eye open --}}
                    <svg class="eye-open w-5 h-5 hidden"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                               c4.478 0 8.268 2.943 9.542 7
                               -1.274 4.057-5.064 7-9.542 7
                               -4.477 0-8.268-2.943-9.542-7z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                </button>
            </div>
            @endforeach

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" id="cancelResetPassword"
                    class="px-4 py-2 rounded-full border border-white/15 text-sm">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-emerald-500 text-sm font-semibold">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= SWEETALERT ================= --}}
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
    color: '#fff'
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', () => {

    const editModal  = document.getElementById('editTrainerModal');
    const resetModal = document.getElementById('resetPasswordModal');

    openEditTrainer.onclick  = () => editModal.classList.remove('hidden');
    closeEditTrainer.onclick = cancelEditTrainer.onclick =
        () => editModal.classList.add('hidden');

    openResetPassword.onclick  = () => resetModal.classList.remove('hidden');
    closeResetPassword.onclick = cancelResetPassword.onclick =
        () => resetModal.classList.add('hidden');

    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = btn.closest('.relative').querySelector('.password-input');
            const open  = btn.querySelector('.eye-open');
            const close = btn.querySelector('.eye-closed');

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            open.classList.toggle('hidden', !isHidden);
            close.classList.toggle('hidden', isHidden);
        });
    });
});
</script>
@endsection
