@extends('layouts.member')

@section('content')
<h1 class="text-2xl font-bold mb-6">Latihan</h1>

<form id="workoutForm" method="POST" action="{{ route('member.workouts.store') }}">
    @csrf

    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm text-gray-400">Tanggal Latihan</p>
            <input type="date" name="tanggal"
                   value="{{ now()->toDateString() }}"
                   class="mt-1 px-4 py-2 rounded-lg
                          bg-[#020617] border border-white/10 text-white">
        </div>

        <button type="button" id="addExerciseBtn"
            class="px-4 py-2 rounded-full bg-emerald-500
                   text-sm font-semibold hover:bg-emerald-400">
            + Tambah Exercise
        </button>
    </div>

    {{-- EXERCISE LIST --}}
    <div id="exerciseWrapper" class="space-y-6">

        {{-- EXERCISE ITEM --}}
        <div class="exercise-item rounded-2xl bg-[#0A0F24]
                    border border-white/10 p-5">

            {{-- PILIH LATIHAN --}}
            <div class="relative mb-4">
                <input type="text"
                       class="exercise-search w-full px-4 py-2 rounded-lg
                              bg-[#020617] border border-white/10 text-white
                              placeholder-gray-500"
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
                    <input type="number"
                           name="exercises[0][sets][0][beban]"
                           placeholder="Beban (kg)"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <input type="number"
                           name="exercises[0][sets][0][reps]"
                           placeholder="Reps"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <button type="button"
                            class="remove-set absolute -right-3 -top-3
                                   w-7 h-7 rounded-full bg-red-500/80
                                   text-white text-sm flex items-center
                                   justify-center hover:bg-red-500">
                        ✕
                    </button>
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
document.addEventListener('input', e => {
    if (!e.target.classList.contains('exercise-search')) return;

    const keyword  = e.target.value.toLowerCase();
    const dropdown = e.target.parentElement.querySelector('.exercise-dropdown');
    const options  = dropdown.querySelectorAll('.exercise-option');

    dropdown.classList.remove('hidden');

    options.forEach(opt => {
        const text = opt.innerText.toLowerCase();
        opt.style.display = text.includes(keyword) ? 'block' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', () => {

    let exerciseIndex = 0;
    const wrapper = document.getElementById('exerciseWrapper');
    const addExerciseBtn = document.getElementById('addExerciseBtn');
    addExerciseBtn.onclick = () => {
        exerciseIndex++;

        const html = `
        <div class="exercise-item rounded-2xl bg-[#0A0F24]
                    border border-white/10 p-5">

            <div class="relative mb-4">
                <input type="text"
                       class="exercise-search w-full px-4 py-2 rounded-lg
                              bg-[#020617] border border-white/10 text-white"
                       placeholder="Pilih latihan…"
                       autocomplete="off">

                <input type="hidden" name="exercises[${exerciseIndex}][workout_id]">

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
                    <input type="number"
                           name="exercises[${exerciseIndex}][sets][0][beban]"
                           placeholder="Beban (kg)"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <input type="number"
                           name="exercises[${exerciseIndex}][sets][0][reps]"
                           placeholder="Reps"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <button type="button"
                            class="remove-set absolute -right-3 -top-3
                                   w-7 h-7 rounded-full bg-red-500/80
                                   text-white text-sm flex items-center
                                   justify-center hover:bg-red-500">
                        ✕
                    </button>
                </div>
            </div>

            <button type="button"
                    class="addSetBtn mt-4 text-sm text-emerald-400 hover:underline">
                + Tambah Set
            </button>
        </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
    };
    document.addEventListener('click', e => {
        if (e.target.classList.contains('exercise-search')) {
            e.target.nextElementSibling.nextElementSibling.classList.remove('hidden');
        }
        if (e.target.classList.contains('exercise-option')) {
            const dropdown = e.target.closest('.exercise-dropdown');
            const search   = dropdown.previousElementSibling.previousElementSibling;
            const hidden   = dropdown.previousElementSibling;

            search.value = e.target.innerText;
            hidden.value = e.target.dataset.id;
            dropdown.classList.add('hidden');
        }

        if (e.target.classList.contains('addSetBtn')) {
            const setWrapper = e.target.previousElementSibling;
            const setIndex   = setWrapper.children.length;
            const exercise   = e.target.closest('.exercise-item');
            const hidden     = exercise.querySelector('input[type="hidden"]');
            const exIndex    = hidden.name.match(/\[(\d+)\]/)[1];

            setWrapper.insertAdjacentHTML('beforeend', `
                <div class="set-item grid grid-cols-2 gap-3 relative">
                    <input type="number"
                           name="exercises[${exIndex}][sets][${setIndex}][beban]"
                           placeholder="Beban (kg)"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <input type="number"
                           name="exercises[${exIndex}][sets][${setIndex}][reps]"
                           placeholder="Reps"
                           class="px-3 py-2 rounded-lg bg-[#020617]
                                  border border-white/10 text-white">

                    <button type="button"
                            class="remove-set absolute -right-3 -top-3
                                   w-7 h-7 rounded-full bg-red-500/80
                                   text-white text-sm flex items-center
                                   justify-center hover:bg-red-500">
                        ✕
                    </button>
                </div>
            `);
        }
        if (e.target.classList.contains('remove-set')) {
            e.target.closest('.set-item').remove();
        }
    });

    // ==========================
    // KONFIRMASI SUBMIT
    // ==========================
    document.getElementById('workoutForm').addEventListener('submit', e => {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan latihan?',
            text: 'Pastikan data latihan sudah benar',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#10B981',
            background: '#0A0F24',
            color: '#fff'
        }).then(res => {
            if (res.isConfirmed) e.target.submit();
        });
    });

});
</script>
@endsection
