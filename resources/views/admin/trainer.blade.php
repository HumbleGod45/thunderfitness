@extends('layouts.admin')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold tracking-wide">
        PERSONAL TRAINER
    </h1>

    <button id="openAddTrainer"
        class="px-4 py-2 rounded-lg bg-emerald-500 text-white text-sm font-semibold hover:bg-emerald-400">
        + Tambah Trainer
    </button>
</div>

{{-- ================= LIST TRAINER ================= --}}
@forelse($trainers as $trainer)
<div class="rounded-2xl bg-[#0A0F24] border border-white/10 p-5 flex items-center justify-between gap-4 mb-4">

    {{-- KIRI --}}
    <div class="flex gap-4 items-start">
        <div class="w-20 h-20 rounded-xl bg-emerald-500/10 overflow-hidden">
            <img src="{{ $trainer->foto ? asset('storage/'.$trainer->foto) : asset('images/trainer-default.png') }}"
                 class="w-full h-full object-cover">
        </div>

        <div>
            <h3 class="font-semibold text-white">{{ $trainer->nama }}</h3>

            <p class="text-sm text-gray-400 mt-1">
                Spesialis: <span class="text-gray-200">{{ $trainer->spesialis }}</span>
            </p>

            <p class="text-xs text-gray-400 mt-2">
                Pengalaman: {{ $trainer->pengalaman_tahun }} tahun <br>
                Telp: {{ $trainer->telp }}
            </p>
        </div>
    </div>

    {{-- KANAN --}}
    <div class="flex gap-2">

        {{-- MEMBER --}}
        <button
            class="px-3 py-1 text-xs rounded-full bg-sky-500/15 text-sky-300 hover:bg-sky-500/25 showMembersBtn"
            data-trainer="{{ $trainer->nama }}"
            data-members='@json($trainer->members)'>
            Member ({{ $trainer->members->count() }})
        </button>

        {{-- EDIT --}}
        <button
            class="px-3 py-1 text-xs rounded-lg border border-white/10 text-gray-300 hover:bg-white/5 editTrainerBtn"
            data-id="{{ $trainer->id_trainer }}"
            data-nama="{{ $trainer->nama }}"
            data-spesialis="{{ $trainer->spesialis }}"
            data-pengalaman="{{ $trainer->pengalaman_tahun }}"
            data-telp="{{ $trainer->telp }}"
            data-foto="{{ $trainer->foto ? asset('storage/'.$trainer->foto) : asset('images/trainer-default.png') }}">
            Edit
        </button>
    </div>
</div>
@empty
<p class="text-gray-400">Belum ada trainer.</p>
@endforelse


{{-- ================= MODAL ADD TRAINER ================= --}}
<div id="addTrainerModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-lg p-6 relative">
        <button id="closeAddTrainer" class="absolute right-4 top-4 text-gray-400 hover:text-white">✕</button>

        <h2 class="text-lg font-semibold mb-4">Tambah Personal Trainer</h2>

        <form action="{{ route('admin.trainer.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="flex gap-4">
                <div class="w-20 h-20 rounded-xl bg-emerald-500/10 overflow-hidden">
                    <img id="previewTrainerFoto" src="{{ asset('images/trainer-default.png') }}"
                         class="w-full h-full object-cover">
                </div>
                <input type="file" name="foto" onchange="previewTrainerImage(event)">
            </div>

            <input type="email" name="email" placeholder="Email Login" required class="input-dark">
            <input type="password" name="password" placeholder="Password" required class="input-dark">
            <input type="text" name="nama" placeholder="Nama Trainer" required class="input-dark">
            <input type="text" name="spesialis" placeholder="Spesialis" required class="input-dark">
            <input type="number" name="pengalaman_tahun" placeholder="Pengalaman (tahun)" required class="input-dark">
            <input type="text" name="telp" placeholder="No Telp" required class="input-dark">

            <div class="flex justify-end gap-3">
                <button type="button" id="cancelAddTrainer" class="btn-outline">Batal</button>
                <button type="submit" class="btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>


{{-- ================= MODAL EDIT TRAINER ================= --}}
<div id="editTrainerModal"
     class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 hidden">

    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-2xl p-6 relative">

        {{-- CLOSE --}}
        <button id="closeEditTrainer"
            class="absolute right-4 top-4 text-gray-400 hover:text-white text-xl">
            ✕
        </button>

        <h2 class="text-lg font-semibold mb-6 text-white">
            Edit Personal Trainer
        </h2>

        <form id="editTrainerForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- FOTO --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="w-28 h-28 rounded-xl overflow-hidden bg-emerald-500/10 border border-white/10">
                        <img id="editPreviewFoto"
                             class="w-full h-full object-cover">
                    </div>

                    <label
                        class="px-4 py-2 text-xs rounded-lg bg-white/10 text-gray-300 cursor-pointer hover:bg-white/20 transition">
                        Ganti Foto
                        <input type="file" name="foto" class="hidden"
                               onchange="previewEditTrainerImage(event)">
                    </label>
                </div>

                {{-- FORM --}}
                <div class="md:col-span-2 space-y-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="text-xs text-gray-400">Nama Trainer</label>
                            <input type="text" name="nama" id="editNama"
                                   class="w-full mt-1 px-3 py-2 rounded-lg bg-[#020617]
                                          border border-gray-700 text-white text-sm">
                        </div>

                        <div>
                            <label class="text-xs text-gray-400">Spesialis</label>
                            <input type="text" name="spesialis" id="editSpesialis"
                                   class="w-full mt-1 px-3 py-2 rounded-lg bg-[#020617]
                                          border border-gray-700 text-white text-sm">
                        </div>

                        <div>
                            <label class="text-xs text-gray-400">Pengalaman (tahun)</label>
                            <input type="number" name="pengalaman_tahun" id="editPengalaman"
                                   class="w-full mt-1 px-3 py-2 rounded-lg bg-[#020617]
                                          border border-gray-700 text-white text-sm">
                        </div>

                        <div>
                            <label class="text-xs text-gray-400">No Telepon</label>
                            <input type="text" name="telp" id="editTelp"
                                   class="w-full mt-1 px-3 py-2 rounded-lg bg-[#020617]
                                          border border-gray-700 text-white text-sm">
                        </div>

                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="flex justify-end gap-3 mt-8">
                <button type="button" id="cancelEditTrainer"
                        class="px-4 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5">
                    Batal
                </button>

                <button type="submit"
                        class="px-6 py-2 rounded-lg bg-emerald-500 text-white font-semibold hover:bg-emerald-400">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>



{{-- ================= SWEETALERT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const addModal = document.getElementById('addTrainerModal');
    const editModal = document.getElementById('editTrainerModal');
    const editForm = document.getElementById('editTrainerForm');

    openAddTrainer.onclick = () => addModal.classList.remove('hidden');
    closeAddTrainer.onclick = cancelAddTrainer.onclick = () => addModal.classList.add('hidden');

    closeEditTrainer.onclick = cancelEditTrainer.onclick = () => editModal.classList.add('hidden');

    document.querySelectorAll('.editTrainerBtn').forEach(btn => {
        btn.onclick = () => {
            editForm.action = `/admin/trainer/${btn.dataset.id}`;
            editNama.value = btn.dataset.nama;
            editSpesialis.value = btn.dataset.spesialis;
            editPengalaman.value = btn.dataset.pengalaman;
            editTelp.value = btn.dataset.telp;
            editPreviewFoto.src = btn.dataset.foto;
            editModal.classList.remove('hidden');
        };
    });

    document.querySelectorAll('.showMembersBtn').forEach(btn => {
        btn.onclick = () => {
            const members = JSON.parse(btn.dataset.members);
            Swal.fire({
                title: `Member Trainer ${btn.dataset.trainer}`,
                html: members.length
                    ? members.map(m => `<p>${m.nama}</p>`).join('')
                    : 'Belum ada member',
                background: '#0A0F24',
                color: '#E5E7EB'
            });
        };
    });
});

function previewTrainerImage(e) {
    previewTrainerFoto.src = URL.createObjectURL(e.target.files[0]);
}
function previewEditTrainerImage(event) {
    const reader = new FileReader();
    reader.onload = () => {
        document.getElementById('editPreviewFoto').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@if(session('success'))
<script>
Swal.fire({
    title: 'Berhasil 🎉',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@endsection
