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
        {{-- HAPUS (Tambahkan ini) --}}
        <button
            class="px-3 py-1 text-xs rounded-lg border border-red-500/30 text-red-400 hover:bg-red-500/10 deleteTrainerBtn"
            data-id="{{ $trainer->id_trainer }}"
            data-nama="{{ $trainer->nama }}">
            Hapus
        </button>
    </div>
</div>
@empty
<p class="text-gray-400">Belum ada trainer.</p>
@endforelse


{{-- ================= MODAL ADD TRAINER (REVISED) ================= --}}
<div id="addTrainerModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden px-4">
    <div class="bg-[#0A0F24] rounded-2xl border border-white/10 w-full max-w-2xl p-6 sm:p-8 relative max-h-[95vh] overflow-y-auto">
        
        {{-- Tombol Close --}}
        <button id="closeAddTrainer" class="absolute right-5 top-5 text-gray-400 hover:text-white transition-colors text-xl">✕</button>

        <h2 class="text-xl font-bold mb-8 text-white tracking-tight">Tambah Personal Trainer</h2>

        <form action="{{ route('admin.trainer.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                {{-- BAGIAN FOTO (KIRI) --}}
                <div class="flex flex-col items-center gap-4">
                    <div class="relative group">
                        <div class="w-32 h-32 rounded-2xl bg-emerald-500/5 border-2 border-dashed border-emerald-500/20 overflow-hidden flex items-center justify-center transition-all group-hover:border-emerald-500/50">
                            <img id="previewTrainerFoto" src="{{ asset('images/trainer-default.png') }}"
                                 class="w-full h-full object-cover">
                        </div>
                        {{-- Overlay Upload --}}
                        <label for="fotoInput" class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer rounded-2xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </label>
                    </div>
                    <p class="text-[10px] text-gray-500 text-center uppercase tracking-widest font-bold">Foto Profil</p>
                    <input id="fotoInput" type="file" name="foto" class="hidden" onchange="previewTrainerImage(event)">
                </div>

                {{-- BAGIAN FORM (KANAN) --}}
                <div class="md:col-span-2 space-y-5">
                    
                    {{-- Baris 1: Email & Password --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Email Login</label>
                            <input type="email" name="email" required placeholder="email@gym.com" 
                                   class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Password</label>
                            <input type="password" name="password" required placeholder="••••••••" 
                                   class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Baris 2: Nama --}}
                    <div>
                        <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" required placeholder="Contoh: Arnold Schwarzenegger" 
                               class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                    </div>

                    {{-- Baris 3: Spesialis & Pengalaman --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Spesialisasi</label>
                            <input type="text" name="spesialis" required placeholder="Contoh: Fat Loss" 
                                   class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                        </div>
                        <div>
                            <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Pengalaman (Tahun)</label>
                            <input type="number" name="pengalaman_tahun" required placeholder="5" 
                                   class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Baris 4: No Telp --}}
                    <div>
                        <label class="text-[11px] text-gray-500 uppercase font-bold ml-1">Nomor Telepon</label>
                        <input type="text" name="telp" required placeholder="08xx xxxx xxxx" 
                               class="w-full mt-1.5 px-4 py-2.5 rounded-xl bg-[#020617] border border-white/5 text-white text-sm focus:ring-2 focus:ring-emerald-500/50 outline-none transition-all">
                    </div>
                </div>
            </div>

            {{-- FOOTER TOMBOL --}}
            <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-white/5">
                <button type="button" id="cancelAddTrainer" 
                        class="px-6 py-2.5 rounded-xl border border-white/10 text-gray-400 font-semibold hover:bg-white/5 hover:text-white transition-all text-sm">
                    Batal
                </button>
                <button type="submit" 
                        class="px-8 py-2.5 rounded-xl bg-emerald-500 text-[#050816] font-bold hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20 text-sm">
                    Simpan Trainer
                </button>
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
{{-- FORM DELETE TERSEMBUNYI --}}
<form id="deleteTrainerForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>


{{-- ================= SWEETALERT ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    const addModal = document.getElementById('addTrainerModal');
    const editModal = document.getElementById('editTrainerModal');
    const editForm = document.getElementById('editTrainerForm');
    const deleteForm = document.getElementById('deleteTrainerForm');

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
   document.querySelectorAll('.deleteTrainerBtn').forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const nama = btn.dataset.nama;

            Swal.fire({
                title: 'Hapus Trainer?',
                text: `Yakin ingin menghapus "${nama}"? Data akses login juga akan terhapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#374151',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#0A0F24',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Sekarang deleteForm sudah dikenal karena didefinisikan di atas
                    deleteForm.action = `/admin/trainer/${id}`;
                    deleteForm.submit();
                }
            });
        };
    });
    document.querySelectorAll('.showMembersBtn').forEach(btn => {
    btn.onclick = () => {
        const members = JSON.parse(btn.dataset.members);
        Swal.fire({
            title: `Member Trainer ${btn.dataset.trainer}`,
            html: members.length
                ? `<div class="text-left space-y-2 mt-4 max-h-60 overflow-y-auto pr-2">
                    ${members.map(m => `<div class="p-3 bg-white/5 rounded-xl border border-white/5 text-sm text-gray-200">👤 ${m.nama}</div>`).join('')}
                   </div>`
                : '<p class="text-gray-500 mt-4 italic text-sm">Belum ada member yang dibimbing.</p>',
            background: '#0A0F24', // Samakan warnanya
            color: '#fff',         // Teks putih
            confirmButtonColor: '#10B981', // Tombol OK warna emerald
            confirmButtonText: 'Tutup'
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
    icon: 'success',
    background: '#0A0F24',
    color: '#fff',        
    timer: 2000,
    showConfirmButton: false,
    iconColor: '#10B981'  
});
</script>
@endif
@endsection
