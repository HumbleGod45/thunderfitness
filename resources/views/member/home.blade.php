@extends('layouts.member')

@section('content')
{{-- Judul halaman --}}
<h1 class="text-2xl md:text-3xl font-extrabold mb-6">
    HOME
</h1>

<div class="space-y-8">

    {{-- Atas: profil + status member --}}
    <div class="grid md:grid-cols-2 gap-6">
        {{-- Card profil --}}
        <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-5 md:p-6 flex gap-4">
            <div class="shrink-0">
                <div class="w-28 h-28 rounded-xl overflow-hidden bg-emerald-500/10 flex items-center justify-center">
                    @if ($foto)
                        <img src="{{ asset('storage/' . $foto) }}"
                             alt="Foto Member" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/member.png') }}"
                             alt="Avatar Member" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>

            <div class="flex-1 space-y-2">
                <p class="text-xs font-semibold tracking-[0.2em] text-emerald-400 uppercase">
                    Nama Member
                </p>
                <h2 class="text-lg md:text-xl font-semibold">
                    {{ $nama }}
                </h2>
                <div class="text-xs md:text-sm text-gray-300 space-y-1">
                    <p>Tinggi Badan: {{ $tinggi ? $tinggi . ' cm' : '-' }}</p>
                    <p>Berat Badan: {{ $berat ? $berat . ' kg' : '-' }}</p>
                </div>

                {{-- tombol edit singkat: hanya tinggi & berat --}}
                <button type="button" id="editProfileBtn"
                    class="mt-3 inline-flex items-center justify-center rounded-full bg-white/10 px-4 py-1.5 text-xs md:text-sm font-medium hover:bg-white/20">
                    Edit Tinggi & Berat
                </button>
            </div>
        </div>

        {{-- Card status membership --}}
        <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-5 md:p-6 flex flex-col justify-between">
            <div class="space-y-1 text-sm md:text-base">
                <h2 class="text-lg font-semibold mb-2">Member Aktif Hingga</h2>
                <p class="text-gray-300 text-sm">
                    ID Member:
                    <span class="font-medium text-white">
                        {{ $idMember ? 'TF-' . str_pad($idMember, 3, '0', STR_PAD_LEFT) : '-' }}
                    </span>
                </p>
                <p class="text-gray-300 text-sm">
                    Start Member:
                    <span class="font-medium text-white">
                        {{ $startMember ? $startMember->translatedFormat('d M Y') : '-' }}
                    </span>
                </p>
                <p class="text-gray-300 text-sm">
                    Aktif Hingga:
                    <span class="font-medium text-white">
                        {{ $aktifHingga ? $aktifHingga->translatedFormat('d M Y') : '-' }}
                    </span>
                </p>
                <p class="text-gray-300 text-sm">
                    Personal Trainer:
                    <span class="font-medium text-white">
                        {{ $personalTrainer ?? '-' }}
                    </span>
                </p>
            </div>

            <div class="mt-4">
                <span class="inline-block text-xs md:text-sm font-medium px-3 py-1 rounded-full {{ $badgeClasses }}">
                    {{ $statusText }}
                </span>
            </div>
        </div>
    </div>

    {{-- BMI slider --}}
    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6 md:p-8">
        <h2 class="text-sm md:text-base font-semibold text-center mb-2">
            Body Mass Index (BMI)
        </h2>

        @if ($bmi)
            <p class="text-center text-xs md:text-sm text-gray-300 mb-4">
                BMI: <span class="font-semibold text-white">{{ number_format($bmi, 1) }}</span>
                ({{ $bmiCategory }})
            </p>
        @else
            <p class="text-center text-xs md:text-sm text-gray-400 mb-4">
                Lengkapi tinggi dan berat badan untuk melihat BMI.
            </p>
        @endif

        <div class="w-full">
            <div class="relative w-full h-3 rounded-full bg-[#1f2937] overflow-hidden">
                {{-- bar slider --}}
                <div class="absolute inset-0 bg-gradient-to-r from-rose-500 via-emerald-500 to-amber-400 opacity-70"></div>
                {{-- posisi titik sekarang --}}
                <div class="absolute top-1/2 -translate-y-1/2 w-3 h-3 rounded-full bg-white shadow"
                     style="left: {{ $bmi ? $bmiPosition : 50 }}%;"></div>
            </div>

            <div class="flex justify-between text-xs text-gray-400 mt-2">
                <span>Kurus</span>
                <span>Ideal</span>
                <span>Obesitas</span>
            </div>
        </div>
    </div>

    {{-- Last workout --}}
    <div class="rounded-2xl bg-[#0A0F24] border border-white/5 p-6 md:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-4">
            <div>
                <p class="text-xs font-semibold tracking-[0.2em] text-emerald-400 uppercase">
                    Last Workout
                </p>

                @if($lastWorkoutDate)
                    <p class="text-sm md:text-base text-gray-300">
                        {{ \Carbon\Carbon::parse($lastWorkoutDate)->translatedFormat('d F Y') }}
                    </p>
                @else
                    <p class="text-sm md:text-base text-gray-300">
                        Belum ada data workout.
                    </p>
                @endif
            </div>
        </div>

        @if($lastWorkoutDate && $lastWorkout->count())

            @php
                $grouped = $lastWorkout->groupBy('nama_latihan');
            @endphp

            <div class="space-y-4">
                @foreach($grouped as $exercise => $sets)
                <div class="rounded-xl bg-[#020617] border border-white/10 p-4">
                        {{-- Nama latihan --}}
                        <p class="font-semibold mb-3">
                            {{ $exercise }}
                        </p>
                    {{-- List set --}}
                    <div class="space-y-2 text-sm text-gray-300">
                        @foreach($sets as $index => $set)
                            <div class="flex justify-between">
                                <span>Set {{ $index + 1 }}</span>
                                <span>
                                    {{ $set->reps }} reps · {{ $set->beban }} kg
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @else
            <div class="text-sm text-gray-400">
                Belum ada data latihan.
            </div>
        @endif
    </div>
</div>

{{-- EDIT PROFIL SINGKAT (Hanya Tinggi & Berat) --}}
<div id="editProfileModal"
     class="fixed inset-0 bg-black/60 flex items-center justify-center z-50 hidden">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-lg p-6 md:p-7 relative">

        {{-- tombol close --}}
        <button type="button" id="closeEditProfile"
                class="absolute right-4 top-4 text-gray-400 hover:text-white">
            ✕
        </button>

        <h2 class="text-lg md:text-xl font-semibold mb-4">
            Edit Tinggi & Berat
        </h2>

        <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- menampilkan error jika ada validasi --}}
            @if ($errors->any())
                <div class="mb-2 text-sm text-red-400 space-y-1">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <p class="text-sm text-gray-400">Ubah hanya tinggi dan berat badan. Field lain dipindah ke halaman Profile.</p>

            <div class="grid md:grid-cols-2 gap-4 mt-3">
                <div>
                    <label class="block text-sm mb-1">Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan"
                           value="{{ old('tinggi_badan', $tinggi) }}"
                           min="1" step="1" inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onkeydown="if(event.key === 'e' || event.key === '-' || event.key === '+' ) event.preventDefault()"
                           class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>

                <div>
                    <label class="block text-sm mb-1">Berat Badan (kg)</label>
                    <input type="number" name="berat_badan"
                           value="{{ old('berat_badan', $berat) }}"
                           min="1" step="1" inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           onkeydown="if(event.key === 'e' || event.key === '-' || event.key === '+' ) event.preventDefault()"
                           class="w-full px-3 py-2 rounded-lg bg-[#020617] border border-gray-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 text-sm">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <button type="button" id="cancelEditProfile"
                        class="px-4 py-2 rounded-lg border border-white/10 text-sm hover:bg-white/5">
                    Batal
                </button>
                <button type="button" id="confirmUpdateBtn"
                        class="px-5 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-sm font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- SCRIPT MODAL EDIT --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const openBtn   = document.getElementById('editProfileBtn');
        const modal     = document.getElementById('editProfileModal');
        const closeBtn  = document.getElementById('closeEditProfile');
        const cancelBtn = document.getElementById('cancelEditProfile');

        if (!openBtn || !modal) return;

        const openModal = () => modal.classList.remove('hidden');
        const closeModal = () => modal.classList.add('hidden');

        openBtn.addEventListener('click', openModal);
        if (closeBtn)  closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        @if ($errors->any())
            openModal();
        @endif

        // disable mouse wheel change on number inputs inside modal (prevents negative when using scroll)
        modal.querySelectorAll('input[type=number]').forEach(input => {
            input.addEventListener('wheel', (e) => e.preventDefault(), { passive: false });
        });
    });
</script>

{{-- SCRIPT KONFIRMASI SIMPAN --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const submitBtn = document.getElementById('confirmUpdateBtn');
        if (!submitBtn) return;

        // cari form yang berada di dalam modal
        const form = submitBtn.closest('form');

        submitBtn.addEventListener('click', function () {
            // simple client-side check: pastikan angka >= 1
            const tinggi = form.querySelector('input[name="tinggi_badan"]').value;
            const berat  = form.querySelector('input[name="berat_badan"]').value;

            const errors = [];
            if (tinggi && Number(tinggi) < 1) errors.push('Tinggi minimal 1 cm.');
            if (berat  && Number(berat)  < 1) errors.push('Berat minimal 1 kg.');

            if (errors.length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Periksa kembali',
                    html: errors.join('<br>'),
                    background: '#0A0F24',
                    color: '#E5E7EB',
                    confirmButtonColor: '#10B981'
                });
                return;
            }

            Swal.fire({
                title: 'Yakin ingin mengubah?',
                text: 'Tinggi dan berat badan akan diperbarui.',
                icon: null,
                background: '#0A0F24',
                color: '#E5E7EB',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#10B981',
                cancelButtonColor: '#E11D48',
                customClass: {
                    popup: 'rounded-2xl p-6',
                    confirmButton: 'px-4 py-2 text-sm font-semibold',
                    cancelButton: 'px-4 py-2 text-sm font-semibold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

{{-- NOTIFIKASI SUKSES SETELAH UPDATE --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        title: 'Berhasil!',
        html: '{{ session("success") }}',
        background: '#0A0F24',
        color: '#ffffff',
        width: '30rem',
        timer: 2200,
        showConfirmButton: false,
        backdrop: 'rgba(0, 0, 0, 0.7)',
        didOpen: () => {
            const popup = Swal.getPopup();
            popup.style.border = '1px solid rgba(255,255,255,0.08)';
        }
    });
});
</script>
@endif
@endsection
