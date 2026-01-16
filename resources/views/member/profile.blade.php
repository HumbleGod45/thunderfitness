@extends('layouts.member')

@section('content')
<style>
    /* Custom scrollbar untuk modal agar terlihat modern */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1f2937;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #10B981;
    }
</style>

<h1 class="text-2xl md:text-3xl font-extrabold mb-6">Profile</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Avatar & Basic Info --}}
    <div class="col-span-1 rounded-2xl bg-[#0A0F24] border border-white/5 p-6 h-fit">
        <div class="flex flex-col items-center">
            <div class="w-32 h-32 rounded-full overflow-hidden shadow-[0_0_30px_rgba(16,185,129,0.25)] border-2 border-emerald-500/20">
                @if($foto)
                    <img src="{{ asset('storage/' . $foto) }}" alt="Foto Member" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/member.png') }}" alt="Avatar Member" class="w-full h-full object-cover">
                @endif
            </div>

            <h3 class="mt-4 text-lg font-semibold text-center">{{ $nama }}</h3>
            <p class="text-xs text-emerald-400 tracking-[0.2em] mt-1 uppercase">Member</p>

            <div class="mt-5 w-full space-y-2">
                <button id="openEditBtn" class="w-full inline-flex items-center justify-center rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-4 py-2 text-sm font-medium hover:bg-emerald-500 hover:text-white transition-all">
                    Edit Profil
                </button>

                <button id="openResetBtn" class="w-full inline-flex items-center justify-center rounded-full bg-white/5 px-4 py-2 text-sm font-medium hover:bg-white/10 border border-white/5 transition-all">
                    Reset Password
                </button>
            </div>
        </div>
    </div>

    {{-- Detail Profil --}}
    <div class="col-span-2 rounded-2xl bg-[#0A0F24] border border-white/5 p-6 space-y-4">
        <h2 class="text-lg font-semibold border-b border-white/5 pb-3">Informasi Pribadi</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Nama Lengkap</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $nama }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">ID Member</p>
                <p class="mt-1 text-sm text-white font-medium">
                    {{ $idMember ? 'TF-' . str_pad($idMember, 3, '0', STR_PAD_LEFT) : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">No Telepon</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $member->telp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Alamat</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $member->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Tinggi Badan</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $tinggi ? $tinggi . ' cm' : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Tanggal Lahir</p>
                <p class="mt-1 text-sm font-medium">
                    {{ $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Jenis Kelamin</p>
                <p class="mt-1 text-sm font-medium">
                    {{ $member->jenis_kelamin === 'L' ? 'Laki-laki' : ($member->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Berat Badan</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $berat ? $berat . ' kg' : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Start Member</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $startMember ? $startMember->translatedFormat('d M Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wider">Aktif Hingga</p>
                <p class="mt-1 text-sm text-white font-medium">{{ $aktifHingga ? $aktifHingga->translatedFormat('d M Y') : '-' }}</p>
            </div>
        </div>

        <div class="mt-4">
            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $badgeClasses }}">
                {{ $statusText }}
            </span>
        </div>

        {{-- BMI Section --}}
        <div class="mt-6 rounded-xl bg-black/20 border border-white/5 p-4 flex items-center justify-between">
            <div>
                <p class="text-xs text-gray-400">Body Mass Index (BMI)</p>
                <p class="text-sm font-bold text-white mt-1">
                    @if($bmi)
                        {{ number_format($bmi,1) }} <span class="text-emerald-400 font-normal ml-1">({{ $bmiCategory }})</span>
                    @else
                        <span class="text-gray-500 font-normal italic">Data belum lengkap</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

{{-- MODAL EDIT PROFIL --}}
<div id="editProfileModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-lg max-h-[90vh] flex flex-col relative shadow-2xl">
        {{-- Sticky Header --}}
        <div class="p-5 border-b border-white/5 flex justify-between items-center bg-[#0A0F24] rounded-t-2xl">
            <h3 class="text-lg font-semibold text-white">Edit Profil</h3>
            <button id="closeEditModal" class="text-gray-400 hover:text-white transition-colors p-1">✕</button>
        </div>

        {{-- Scrollable Body --}}
        <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
            <form id="editProfileForm" action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl border border-white/5">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-emerald-500/30 shrink-0">
                        <img src="{{ $foto ? asset('storage/'.$foto) : asset('images/member.png') }}" class="w-full h-full object-cover">
                    </div>
                    <div class="flex-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Ganti Foto Profil</label>
                        <input type="file" name="foto" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-1 file:px-3 file:rounded-full file:border-0 file:bg-emerald-500 file:text-white hover:file:bg-emerald-400 cursor-pointer">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $nama) }}" required class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">No Telepon</label>
                        <input type="text" name="telp" value="{{ old('telp', $member->telp) }}" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ $member->tanggal_lahir }}" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">{{ old('alamat', $member->alamat) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Gender</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                            <option value="L" {{ $member->jenis_kelamin === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $member->jenis_kelamin === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Tinggi (cm)</label>
                        <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $tinggi) }}" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Berat (kg)</label>
                        <input type="number" name="berat_badan" value="{{ old('berat_badan', $berat) }}" class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white focus:border-emerald-500 outline-none transition-all">
                    </div>
                </div>
            </form>
        </div>

        {{-- Sticky Footer --}}
        <div class="p-5 border-t border-white/5 flex justify-end gap-3 bg-[#0A0F24] rounded-b-2xl">
            <button type="button" id="cancelEdit" class="px-5 py-2 rounded-xl border border-white/10 text-sm text-gray-300 hover:bg-white/5 transition-all">Batal</button>
            <button type="submit" form="editProfileForm" class="px-6 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-sm font-bold text-white shadow-lg shadow-emerald-500/20 transition-all">Simpan Perubahan</button>
        </div>
    </div>
</div>

{{-- MODAL RESET PASSWORD --}}
<div id="resetPasswordModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-md relative shadow-2xl">
        <div class="p-5 border-b border-white/5 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">Reset Password</h3>
            <button id="closeResetModal" class="text-gray-400 hover:text-white p-1">✕</button>
        </div>

        <div class="p-6">
            @if($errors->hasAny(['current_password', 'password']))
                <div class="mb-4 p-3 rounded-lg bg-red-500/10 border border-red-500/20 text-xs text-red-400">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form id="resetPasswordForm" action="{{ route('member.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Password Baru</label>
                    <input type="password" name="password" required class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-xl bg-[#020617] border border-gray-700 text-white text-sm outline-none focus:border-emerald-500">
                </div>
            </form>
        </div>

        <div class="p-5 border-t border-white/5 flex justify-end gap-3">
            <button type="button" id="cancelReset" class="px-5 py-2 rounded-xl border border-white/10 text-sm text-gray-300 hover:bg-white/5">Batal</button>
            <button type="button" id="confirmResetBtn" class="px-6 py-2 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-sm font-bold text-white transition-all">Update Password</button>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Modal Selectors
    const modals = {
        edit: {
            el: document.getElementById('editProfileModal'),
            open: document.getElementById('openEditBtn'),
            close: [document.getElementById('closeEditModal'), document.getElementById('cancelEdit')]
        },
        reset: {
            el: document.getElementById('resetPasswordModal'),
            open: document.getElementById('openResetBtn'),
            close: [document.getElementById('closeResetModal'), document.getElementById('cancelReset')]
        }
    };

    // Toggle Logic
    const toggleModal = (modal, show) => {
        if(show) modal.classList.remove('hidden');
        else modal.classList.add('hidden');
    };

    // Event Listeners
    Object.values(modals).forEach(m => {
        if(m.open) m.open.onclick = () => toggleModal(m.el, true);
        m.close.forEach(btn => { if(btn) btn.onclick = () => toggleModal(m.el, false); });
        m.el.onclick = (e) => { if(e.target === m.el) toggleModal(m.el, false); };
    });

    // Password Reset Confirmation
    const confirmResetBtn = document.getElementById('confirmResetBtn');
    const resetForm = document.getElementById('resetPasswordForm');

    if (confirmResetBtn && resetForm) {
        confirmResetBtn.onclick = () => {
            Swal.fire({
                title: 'Ganti Password?',
                text: 'Pastikan Anda mengingat password yang baru.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ganti',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#1f2937',
                background: '#0A0F24',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) resetForm.submit();
            });
        };
    }

    // Auto-open Reset Modal if there are errors
    @if($errors->hasAny(['current_password', 'password']))
        toggleModal(modals.reset.el, true);
    @endif
});
</script>

{{-- Notifications --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "{{ session('success') }}",
        background: '#0A0F24',
        color: '#fff',
        timer: 3000,
        showConfirmButton: false
    });
</script>
@endif
@endsection