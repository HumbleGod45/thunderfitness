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

            <div class="flex gap-2">
                <a href="{{ route('admin.announcements.edit', $a) }}"
                   class="px-3 py-1 text-sm rounded bg-yellow-500/20 text-yellow-300">
                    Edit
                </a>

                <form method="POST"
                      action="{{ route('admin.announcements.destroy', $a) }}">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-3 py-1 text-sm rounded bg-red-500/20 text-red-300"
                        onclick="return confirm('Hapus pengumuman?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
