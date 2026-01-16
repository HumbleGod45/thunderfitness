@extends('layouts.admin')

@section('content')
<h1 class="text-2xl font-bold mb-6">Pengumuman</h1>

<a href="{{ route('admin.announcements.create') }}"
   class="mb-4 inline-block px-4 py-2 rounded-lg bg-emerald-500 text-white">
   + Tambah Pengumuman
</a>

<div class="space-y-4">
@foreach($announcements as $a)
    <div class="p-4 rounded-xl bg-[#0A0F24] border border-white/10">
        <div class="flex justify-between">
            <div>
                <h3 class="font-semibold text-lg">{{ $a->judul }}</h3>
                <p class="text-sm text-gray-400">
                    Target: {{ strtoupper($a->target) }} |
                    Status: {{ $a->status }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.announcements.edit', $a) }}"
                    class="px-3 py-1.5 text-sm rounded-lg
                           border border-yellow-400/30
                         text-yellow-400
                         hover:bg-yellow-400/10
                           transition">
                    Edit
                </a>

                <form method="POST"
                    action="{{ route('admin.announcements.destroy', $a) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Hapus pengumuman?')"
                        class="px-3 py-1.5 text-sm rounded-lg
                               border border-red-400/30
                             text-red-400
                             hover:bg-red-400/10
                               transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
