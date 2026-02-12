@extends('layouts.main', ['pageTitle' => 'Register — Thunder Fitness'])

@section('content')
<section class="min-h-screen py-10 flex items-center justify-center bg-[#050816] text-white px-4">
    {{-- Container utama dibuat fleksibel dengan max-width yang lebih besar (max-w-2xl) --}}
    <div class="w-full max-w-2xl bg-[#0f172a] rounded-3xl p-6 sm:p-10 border border-white/10 shadow-[0_20px_60px_rgba(0,0,0,0.7)] transition-all">

        {{-- TITLE --}}
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl font-black mb-2 tracking-tight">
                Daftar <span class="text-emerald-400">Member</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-400">
                Lengkapi data diri untuk bergabung dengan Thunder Fitness
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-red-500/10 border border-red-500/20 px-4 py-3 text-xs text-red-300">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- GRID SECTION 1: Akun --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                        class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama sesuai KTP"
                        class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all text-sm outline-none">
                </div>
            </div>

            {{-- GRID SECTION 2: Keamanan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                        <button type="button" data-toggle="password" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-emerald-400">
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                        <button type="button" data-toggle="password_confirmation" class="absolute inset-y-0 right-4 flex items-center text-gray-500 hover:text-emerald-400">
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- GRID SECTION 3: Detail Fisik & Kontak --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">No Telepon</label>
                    <input type="text" name="telp" id="telp"value="{{ old('telp') }}" required placeholder="08xx..."inputmode="numeric"oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                        class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                        <option value="">- Pilih -</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                @php
                    $minAge = now()->subYears(15)->toDateString();
                @endphp
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required max="{{ $minAge }}" value="{{ $minAge }}" class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                        <p class="text-[10px] text-gray-500 mt-1 italic">*Minimal usia pendaftaran adalah 15 tahun.</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-2 text-gray-500">Tinggi (cm)</label>
                        <input type="number" name="tinggi_badan" placeholder="170" min="1" required
                            oninput="validity.valid||(value='');"
                            class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase mb-2 text-gray-500">Berat (kg)</label>
                        <input type="number" name="berat_badan" placeholder="65" min="1" required
                            oninput="validity.valid||(value='');"
                            class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none">
                    </div>
                </div>
            </div>

            {{-- ALAMAT --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider mb-2 text-gray-400">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" placeholder="Masukkan alamat lengkap Anda"
                    class="w-full px-4 py-3 rounded-xl bg-[#020617] border border-gray-700 focus:border-emerald-500 transition-all text-sm outline-none resize-none">{{ old('alamat') }}</textarea>
            </div>

            {{-- FOTO PROFIL --}}
            <div class="space-y-3">
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-400">Foto Profil <span class="text-gray-600 normal-case italic font-normal">(Opsional)</span></label>
                <div class="flex items-center gap-4 p-4 rounded-xl bg-[#020617]/50 border border-dashed border-gray-700 group hover:border-emerald-500/50 transition-colors">
                    <div id="previewContainer" class="shrink-0 w-14 h-14 rounded-full bg-gray-900 flex items-center justify-center border-2 border-white/5 overflow-hidden shadow-inner">
                        <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <input type="file" name="foto" id="fotoInput" accept="image/*"
                            class="block w-full text-xs text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-[10px] file:font-black file:uppercase
                                   file:bg-emerald-500 file:text-[#050816]
                                   hover:file:bg-emerald-400 cursor-pointer">
                        <p class="mt-2 text-[10px] text-gray-500 italic">Format: JPG, PNG. Max 2MB.</p>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full py-4 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-[#050816] font-black text-sm uppercase tracking-widest transition-all shadow-lg shadow-emerald-500/25 active:scale-[0.98]">
                Konfirmasi Pendaftaran
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-gray-500">
            Sudah terdaftar? 
            <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:text-emerald-300 transition-colors">
                Login ke Dashboard
            </a>
        </p>
    </div>
</section>

{{-- SCRIPT --}}
<script>
// Toggle Password
document.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.toggle);
        const open = btn.querySelector('.eye-open');
        const closed = btn.querySelector('.eye-closed');
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        open.classList.toggle('hidden', !isPassword);
        closed.classList.toggle('hidden', isPassword);
    });
});

// Real-time Photo Preview
document.getElementById('fotoInput').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        const container = document.getElementById('previewContainer');
        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            container.classList.add('border-emerald-500/50');
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>
@endsection