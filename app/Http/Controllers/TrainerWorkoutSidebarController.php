<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerWorkoutSidebarController extends Controller
{
    /**
     * Form input latihan dari sidebar 
     */
    public function create()
    {
        $trainer = Auth::user()->trainer;

        return view('trainer.workouts.latihan', [
            'title'    => 'Input Latihan',
            'members'  => Member::where('trainer_id', $trainer->id_trainer)
                                ->orderBy('nama')
                                ->get(),
            'workouts' => Workout::orderBy('nama_latihan')->get(),
        ]);
    }

    /**
     * Simpan latihan dari sidebar
     */
    public function store(Request $request)
    {
        $trainer = Auth::user()->trainer;

        $request->validate([
            'member_id' => ['required', 'exists:members,id_member'],
            'tanggal'   => ['required', 'date'],
            'exercises' => ['required', 'array'],

            'exercises.*.workout_id' => ['required', 'exists:workouts,id_workout'],
            'exercises.*.sets'       => ['required', 'array'],
            'exercises.*.sets.*.beban' => ['nullable', 'numeric', 'min:0'],
            'exercises.*.sets.*.reps'  => ['nullable', 'integer', 'min:0'],
        ]);

        // ambil member & pastikan milik trainer ini
        $member = Member::where('id_member', $request->member_id)
            ->where('trainer_id', $trainer->id_trainer)
            ->firstOrFail();

        DB::transaction(function () use ($request, $member, $trainer) {

            foreach ($request->exercises as $exercise) {
                $setKe = 1;

                foreach ($exercise['sets'] as $set) {
                    DB::table('workout_logs')->insert([
                        'id_member'  => $member->id_member,
                        'id_trainer' => $trainer->id_trainer,
                        'id_workout' => $exercise['workout_id'],
                        'tanggal'    => $request->tanggal,
                        'jumlah_set' => $setKe,
                        'beban'      => $set['beban'] ?? 0,
                        'reps'       => $set['reps'] ?? 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    $setKe++;
                }
            }
        });

        return redirect()
            ->route('trainer.workouts.sidebar.create')
            ->with('success', 'Latihan berhasil dicatat.');
    }
}
