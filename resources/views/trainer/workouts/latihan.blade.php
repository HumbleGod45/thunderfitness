@extends('layouts.trainer')

@section('content')
<h1 class="text-2xl font-bold mb-6">Input Latihan</h1>

<form id="workoutForm"
      method="POST"
      action="{{ route('trainer.sidebar.workouts.store') }}">
    @csrf

    {{-- HEADER --}}
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- PILIH MEMBER --}}
        <div>
            <p class="text-sm text-gray-400">Member</p>
            <select name="member_id"
                class="mt-1 w-full px-4 py-2 rounded-lg
                       bg-[#020617] border border-white/10 text-white"
                required>
                <option value="">-- Pilih Member --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id_member }}">
                        {{ $member->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TANGGAL --}}
        <div>
            <p class="text-sm text-gray-400">Tanggal Latihan</p>
            <input type="date"
                name="tanggal"
                min="{{ now()->toDateString() }}"
                value="{{ now()->toDateString() }}"
                class="mt-1 w-full px-4 py-2 rounded-lg
                       bg-[#020617] border border-white/10 text-white">
        </div>

        {{-- TAMBAH EXERCISE --}}
        <div class="flex items-end justify-end">
            <button type="button" id="addExerciseBtn"
                class="px-4 py-2 rounded-full bg-emerald-500
                       text-sm font-semibold hover:bg-emerald-400">
                + Tambah Exercise
            </button>
        </div>
    </div>

    {{-- EXERCISE LIST --}}
    <div id="exerciseWrapper" class="space-y-6">

        {{-- EXERCISE PERTAMA (TIDAK BISA DIHAPUS) --}}
        <div class="exercise-item relative rounded-2xl bg-[#0A0F24]
                    border border-white/10 p-5 pt-10 overflow-visible">

            {{-- PILIH LATIHAN --}}
            <div class="relative mb-4">
                <input type="text"
                       class="exercise-search w-full px-4 py-2 rounded-lg
                              bg-[#020617] border border-white/10 text-white"
                       placeholder="Pilih latihan…"
                       autocomplete="off">

                <input type="hidden" name="exercises[0][workout_id]">

                <div class="exercise-dropdown absolute z-20 mt-1 w-full
                            rounded-xl bg-[#020617] border border-white/10
                            max-h-48 overflow-y-auto hidden">
                    @foreach($workouts as $workout)
                        <div class="exercise-option px-4 py-2
                                    hover:bg-white/10 cursor-pointer text-sm"
                             data-id="{{ $workout->id_workout }}">
                            {{ $workout->nama_latihan }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SET LIST --}}
            <div class="set-wrapper space-y-3">
                <div class="set-item grid grid-cols-2 gap-3 relative">
                    <input type="number" min="1" step="1"
                        onkeydown="if(event.key === '-' || event.key === 'e') event.preventDefault()"
                        oninput="if(this.value !== '' && this.value < 1) this.value = 1"
                        name="exercises[0][sets][0][beban]"
                        placeholder="Beban (kg)"
                        class="px-3 py-2 rounded-lg bg-[#020617] border border-white/10 text-white">

                    <input type="number" min="1" step="1"
                        onkeydown="if(event.key === '-' || event.key === 'e') event.preventDefault()"
                        oninput="if(this.value !== '' && this.value < 1) this.value = 1"
                        name="exercises[0][sets][0][reps]"
                        placeholder="Reps"
                        class="px-3 py-2 rounded-lg bg-[#020617] border border-white/10 text-white">
                </div>
            </div>

            <button type="button"
                class="addSetBtn mt-4 text-sm text-emerald-400 hover:underline">
                + Tambah Set
            </button>
        </div>

    </div>

    {{-- SUBMIT --}}
    <div class="mt-10 flex justify-end">
        <button type="submit"
            class="px-6 py-3 rounded-xl bg-emerald-500
                   font-semibold hover:bg-emerald-400">
            Simpan Latihan
        </button>
    </div>
</form>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    let exerciseIndex = 0;
    const wrapper = document.getElementById('exerciseWrapper');

    // =============================
    // TAMBAH EXERCISE
    // =============================
    document.getElementById('addExerciseBtn').onclick = () => {
        exerciseIndex++;

        wrapper.insertAdjacentHTML('beforeend', `
        <div class="exercise-item relative rounded-2xl bg-[#0A0F24]
            border border-white/10 p-5 pt-10 overflow-visible">

            <button type="button"
                class="remove-exercise absolute top-3 right-3
                    px-3 py-1 rounded-full
                    border border-red-400/40 text-red-400
                    text-xs font-semibold hover:bg-red-500/10">
                Hapus
            </button>

            <div class="relative mb-4">
                <input type="text"
                    class="exercise-search w-full px-4 py-2 rounded-lg
                           bg-[#020617] border border-white/10 text-white"
                    placeholder="Pilih latihan…">

                <input type="hidden"
                    name="exercises[${exerciseIndex}][workout_id]">

                <div class="exercise-dropdown absolute z-20 mt-1 w-full
                            rounded-xl bg-[#020617] border border-white/10
                            max-h-48 overflow-y-auto hidden">
                    @foreach($workouts as $workout)
                        <div class="exercise-option px-4 py-2
                            hover:bg-white/10 cursor-pointer text-sm"
                            data-id="{{ $workout->id_workout }}">
                            {{ $workout->nama_latihan }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="set-wrapper space-y-3">
                <div class="set-item grid grid-cols-2 gap-3 relative">
                    <input type="number" min="1" step="1"
                        onkeydown="if(event.key === '-' || event.key === 'e') event.preventDefault()"
                        oninput="if(this.value !== '' && this.value < 1) this.value = 1"
                        name="exercises[0][sets][0][beban]"
                        placeholder="Beban (kg)"
                        class="px-3 py-2 rounded-lg bg-[#020617] border border-white/10 text-white">

                    <input type="number" min="1" step="1"
                        onkeydown="if(event.key === '-' || event.key === 'e') event.preventDefault()"
                        oninput="if(this.value !== '' && this.value < 1) this.value = 1"
                        name="exercises[0][sets][0][reps]"
                        placeholder="Reps"
                        class="px-3 py-2 rounded-lg bg-[#020617] border border-white/10 text-white">
                </div>
            </div>

            <button type="button"
                class="addSetBtn mt-4 text-sm text-emerald-400 hover:underline">
                + Tambah Set
            </button>
        </div>
        `);
    };

    // =============================
    // EVENT DELEGATION
    // =============================
    document.addEventListener('click', e => {
        if (!e.target.classList.contains('exercise-search') && !e.target.closest('.exercise-dropdown')) {
            document.querySelectorAll('.exercise-dropdown').forEach(d => d.classList.add('hidden'));
        }
    });
    document.addEventListener('click', e => {

        if (e.target.classList.contains('exercise-search')) {
            e.target.nextElementSibling.nextElementSibling.classList.remove('hidden');
        }

        if (e.target.classList.contains('exercise-option')) {
            const dropdown = e.target.closest('.exercise-dropdown');
            const search = dropdown.previousElementSibling.previousElementSibling;
            const hidden = dropdown.previousElementSibling;

            search.value = e.target.innerText;
            hidden.value = e.target.dataset.id;
            dropdown.classList.add('hidden');
        }

        if (e.target.classList.contains('remove-exercise')) {
            e.target.closest('.exercise-item').remove();
        }

        if (e.target.classList.contains('addSetBtn')) {
            const wrapper = e.target.previousElementSibling;
            const index = wrapper.children.length;
            const hidden = e.target.closest('.exercise-item')
                          .querySelector('input[type="hidden"]');
            const ex = hidden.name.match(/\[(\d+)\]/)[1];

            wrapper.insertAdjacentHTML('beforeend', `
                <div class="set-item grid grid-cols-2 gap-3 relative">
                    <input type="number"
                        name="exercises[${ex}][sets][${index}][beban]"
                        placeholder="Beban (kg)"
                        class="px-3 py-2 rounded-lg bg-[#020617]
                               border border-white/10 text-white">

                    <input type="number"
                        name="exercises[${ex}][sets][${index}][reps]"
                        placeholder="Reps"
                        class="px-3 py-2 rounded-lg bg-[#020617]
                               border border-white/10 text-white">
                </div>
            `);
        }
    });

    // =============================
    // VALIDASI SUBMIT
    // =============================
    document.getElementById('workoutForm').addEventListener('submit', e => {
        e.preventDefault();

        if (!document.querySelector('select[name="member_id"]').value) {
            Swal.fire('Member belum dipilih', '', 'error');
            return;
        }

        Swal.fire({
            title: 'Simpan latihan?',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            background: '#0A0F24',
            color: '#fff',
            confirmButtonColor: '#10B981'
        }).then(res => {
            if (res.isConfirmed) e.target.submit();
        });
    });

});
</script>
@endsection
