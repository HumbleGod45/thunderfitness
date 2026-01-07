@extends('layouts.main', ['pageTitle' => 'Register — Thunder Fitness'])

@section('content')
<section class="min-h-screen flex items-center justify-center bg-[#050816] text-white px-4">
    <div class="w-full max-w-lg bg-[#0f172a] rounded-2xl
                p-6 sm:p-8
                border border-white/10
                shadow-[0_20px_60px_rgba(0,0,0,0.7)]">

        {{-- TITLE --}}
        <h1 class="text-xl sm:text-2xl font-extrabold mb-2 text-center">
            Daftar Member Thunder Fitness
        </h1>
        <p class="text-xs sm:text-sm text-gray-400 text-center mb-6">
            Buat akun untuk mulai perjalanan fitness kamu
        </p>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-5 rounded-lg bg-red-500/10 border border-red-500/20
                        px-4 py-3 text-xs sm:text-sm text-red-300 space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data"
              class="space-y-5 sm:space-y-6">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                           focus:ring-2 focus:ring-emerald-500 text-sm text-white">
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2.5 pr-11 rounded-lg bg-[#020617] border border-gray-700
                               focus:ring-2 focus:ring-emerald-500 text-sm text-white">

                    <button type="button" data-toggle="password"
                        class="absolute inset-y-0 right-3 flex items-center
                               text-gray-400 hover:text-emerald-400">
                        <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                                     c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7
                                     -4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- PASSWORD CONFIRM --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">Konfirmasi Password</label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-3 py-2.5 pr-11 rounded-lg bg-[#020617] border border-gray-700
                               focus:ring-2 focus:ring-emerald-500 text-sm text-white">

                    <button type="button" data-toggle="password_confirmation"
                        class="absolute inset-y-0 right-3 flex items-center
                               text-gray-400 hover:text-emerald-400">
                        <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.458 12C3.732 7.943 7.523 5 12 5
                                     c4.478 0 8.268 2.943 9.542 7
                                     -1.274 4.057-5.064 7-9.542 7
                                     -4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3l18 18"/>
                        </svg>
                    </button>
                </div>
            </div>

            <hr class="border-white/10">

            {{-- NAMA --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required
                    class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                           focus:ring-2 focus:ring-emerald-500 text-sm text-white">
            </div>

            {{-- NO TELP --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">No Telepon</label>
                <input type="text" name="telp" value="{{ old('telp') }}"
                    class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                           focus:ring-2 focus:ring-emerald-500 text-sm text-white">
            </div>

            {{-- TGL LAHIR + JK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs sm:text-sm mb-1 text-gray-300">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                        class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                               focus:ring-2 focus:ring-emerald-500 text-sm text-white">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm mb-1 text-gray-300">Jenis Kelamin</label>
                    <select name="jenis_kelamin"
                        class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                               focus:ring-2 focus:ring-emerald-500 text-sm text-white">
                        <option value="">- Pilih -</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>
                    </select>
                </div>
            </div>

            {{-- ALAMAT --}}
            <div>
                <label class="block text-xs sm:text-sm mb-1 text-gray-300">Alamat</label>
                <textarea name="alamat" rows="3"
                    class="w-full px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700
                           focus:ring-2 focus:ring-emerald-500 text-sm text-white">{{ old('alamat') }}</textarea>
            </div>

            {{-- TINGGI + BERAT --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <input type="number" name="tinggi_badan" placeholder="Tinggi (cm)"
                    class="px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700 text-sm text-white">
                <input type="number" name="berat_badan" placeholder="Berat (kg)"
                    class="px-3 py-2.5 rounded-lg bg-[#020617] border border-gray-700 text-sm text-white">
            </div>

            {{-- FOTO --}}
            <input type="file" name="foto" accept="image/*"
                class="text-xs sm:text-sm file:mr-4 file:py-2 file:px-4
                       file:rounded-lg file:border-0
                       file:bg-emerald-500 file:text-white
                       hover:file:bg-emerald-400">

            <button type="submit"
                class="w-full py-2.5 rounded-lg bg-emerald-500 hover:bg-emerald-400
                       font-semibold text-sm">
                Daftar Sebagai Member
            </button>
        </form>

        <p class="mt-5 text-center text-xs text-gray-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-emerald-400 hover:underline">
                Login di sini
            </a>
        </p>
    </div>
</section>

{{-- SCRIPT TOGGLE PASSWORD --}}
<script>
document.querySelectorAll('[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
        const input = document.getElementById(btn.dataset.toggle);
        const open = btn.querySelector('.eye-open');
        const closed = btn.querySelector('.eye-closed');

        const show = input.type === 'password';
        input.type = show ? 'text' : 'password';

        open.classList.toggle('hidden', show);
        closed.classList.toggle('hidden', !show);
    });
});
</script>
@endsection
