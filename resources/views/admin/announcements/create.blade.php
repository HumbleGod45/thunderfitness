@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Tambah Pengumuman</h1>

<form method="POST" action="{{ route('admin.announcements.store') }}">
    @csrf

    <div class="space-y-6 bg-[#0A0F24] border border-white/10 rounded-2xl p-6">

        {{-- JUDUL --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Judul Pengumuman</label>
            <input type="text" name="judul" required
                   class="w-full px-4 py-2 rounded-lg bg-[#020617]
                          border border-white/10 text-white"
                   placeholder="Masukkan judul pengumuman">
        </div>

        {{-- TARGET --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Ditujukan Untuk</label>
            <select name="target" required
                    class="w-full px-4 py-2 rounded-lg bg-[#020617]
                           border border-white/10 text-white">
                <option value="all">Semua</option>
                <option value="member">Member</option>
                <option value="trainer">Trainer</option>
            </select>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-sm text-gray-400 mb-1">Status</label>
            <select name="is_active" required
                    class="w-full px-4 py-2 rounded-lg bg-[#020617]
                           border border-white/10 text-white">
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>

        {{-- ISI --}}
        <div>
            <label class="block text-sm text-gray-400 mb-2">Isi Pengumuman</label>
            <textarea name="isi" id="editor" rows="6"
                      class="w-full rounded-lg bg-[#020617]
                             border border-white/10 text-white"></textarea>
        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.announcements.index') }}"
               class="px-5 py-2 rounded-lg border border-white/20
                      text-gray-300 hover:bg-white/10">
                Batal
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-lg bg-emerald-500
                           font-semibold hover:bg-emerald-400">
                Simpan
            </button>
        </div>

    </div>
</form>

{{-- CKEDITOR --}}
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => console.error(error));
</script>
@endsection
