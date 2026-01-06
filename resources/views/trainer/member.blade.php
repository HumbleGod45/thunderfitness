@extends('layouts.trainer')

@section('content')
<h1 class="text-2xl md:text-3xl font-extrabold mb-6">
    Daftar Member Kamu
</h1>

<div class="space-y-6">
@forelse($members as $member)
    <article
        class="w-full rounded-2xl bg-[#0B1024] border border-white/5
               px-6 py-5 flex flex-col md:flex-row items-center gap-4
               shadow-[0_20px_60px_rgba(0,0,0,0.6)]">

        {{-- FOTO --}}
        <div class="flex-shrink-0">
            <img
                src="{{ $member->foto
                    ? asset('storage/' . $member->foto)
                    : asset('images/member-default.png') }}"
                class="w-24 h-24 rounded-xl object-cover bg-black/30">
        </div>

        {{-- INFO --}}
        <div class="flex-1 w-full">
            <h2 class="text-lg md:text-xl font-semibold">
                {{ $member->nama }}
            </h2>

            <p class="text-xs md:text-sm text-gray-400 mt-1">
                BB: {{ $member->berat_badan ?? '-' }} kg
                &nbsp; • &nbsp;
                TB: {{ $member->tinggi_badan ?? '-' }} cm
            </p>
        </div>

        {{-- AKSI --}}
        <div class="flex gap-3 mt-2 md:mt-0">
            <button
                class="px-4 py-2 rounded-full border border-white/20
                       text-sm hover:bg-white/10 transition btn-detail"
                data-id="{{ $member->id_member }}">
                Detail
            </button>

            <a href="#"
               class="px-4 py-2 rounded-full bg-emerald-500
                      text-sm font-semibold hover:bg-emerald-400 transition">
                Latihan
            </a>
        </div>
    </article>
@empty
    <div class="text-center text-gray-400 py-12">
        Belum ada member yang terdaftar ke kamu.
    </div>
@endforelse
</div>

{{-- ================= MODAL DETAIL MEMBER ================= --}}
<div id="detailModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm
            flex items-center justify-center z-50 hidden">

    <div class="relative w-full max-w-lg rounded-3xl
                bg-gradient-to-br from-[#0B1024] to-[#050816]
                border border-white/10 p-8">

        {{-- CLOSE --}}
        <button id="closeDetailModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-white">
            ✕
        </button>

        {{-- HEADER --}}
        <div class="flex flex-col items-center mb-6 text-center">
            <img id="detailFoto"
                 class="w-28 h-28 rounded-full object-cover
                        ring-4 ring-emerald-400/30 mb-4">

            <h3 id="detailNama" class="text-xl font-bold"></h3>
            <span class="text-xs text-emerald-400 tracking-widest uppercase">
                Member
            </span>
        </div>

        {{-- INFO --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-center">

            <div>
                <p class="text-gray-400">No Telepon</p>
                <p id="detailTelp" class="font-medium"></p>
            </div>

            <div>
                <p class="text-gray-400">Jenis Kelamin</p>
                <p id="detailGender" class="font-medium"></p>
            </div>

            <div>
                <p class="text-gray-400">Alamat</p>
                <p id="detailAlamat" class="font-medium"></p>
            </div>

            <div>
                <p class="text-gray-400">Tanggal Lahir</p>
                <p id="detailLahir" class="font-medium"></p>
            </div>

            <div></div>
        </div>

        {{-- TINGGI + BERAT --}}
        <div class="grid grid-cols-2 gap-4 mt-4 text-center">
            <div class="rounded-xl bg-white/5 p-4">
                <p class="text-xs text-gray-400">Tinggi Badan</p>
                <p class="text-lg font-semibold">
                    <span id="detailTinggi"></span> cm
                </p>
            </div>

            <div class="rounded-xl bg-white/5 p-4">
                <p class="text-xs text-gray-400">Berat Badan</p>
                <p class="text-lg font-semibold">
                    <span id="detailBerat"></span> kg
                </p>
            </div>
        </div>

        {{-- BMI --}}
        <div class="mt-4 rounded-xl bg-emerald-500/10
                    border border-emerald-400/20 p-4 text-center">
            <p class="text-xs uppercase tracking-widest text-emerald-300">
                Body Mass Index
            </p>
            <p class="text-lg font-bold">
                <span id="detailBMI"></span>
                <span id="detailBMICategory"
                      class="text-sm text-gray-300"></span>
            </p>
        </div>

        {{-- ACTION --}}
        <div class="mt-6 flex justify-end">
            <button id="closeDetailModalBottom"
                    class="px-5 py-2 rounded-full
                           border border-white/15 text-sm">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('detailModal');

    const close = () => modal.classList.add('hidden');
    document.getElementById('closeDetailModal').onclick = close;
    document.getElementById('closeDetailModalBottom').onclick = close;
    modal.onclick = e => e.target === modal && close();

    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.onclick = async () => {
            const id = btn.dataset.id;

            try {
                const res = await fetch(`/trainer/members/${id}`);
                if (!res.ok) throw new Error();

                const d = await res.json();

                detailFoto.src   = d.foto;
                detailNama.textContent   = d.nama;
                detailTelp.textContent   = d.telp;
                detailAlamat.textContent = d.alamat;
                detailLahir.textContent  = d.tanggal_lahir;
                detailGender.textContent = d.jenis_kelamin;
                detailTinggi.textContent = d.tinggi;
                detailBerat.textContent  = d.berat;

                // BMI
                const t = parseFloat(d.tinggi);
                const b = parseFloat(d.berat);
                if (t && b) {
                    const bmi = b / Math.pow(t / 100, 2);
                    let cat = 'Ideal';
                    if (bmi < 18.5) cat = 'Kurus';
                    else if (bmi >= 25) cat = 'Obesitas';

                    detailBMI.textContent = bmi.toFixed(1);
                    detailBMICategory.textContent = `(${cat})`;
                } else {
                    detailBMI.textContent = '-';
                    detailBMICategory.textContent = '';
                }

                modal.classList.remove('hidden');
            } catch {
                alert('Gagal memuat detail member');
            }
        };
    });
});
</script>
@endsection
