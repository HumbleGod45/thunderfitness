<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerWorkoutController extends Controller
{
    /**
     * Form input latihan oleh trainer
     */
    public function create(Member $member)
    {
        $trainer = Auth::user()->trainer;

        // security: pastikan member ini milik trainer tsb
        if ($member->trainer_id !== $trainer->id_trainer) {
            abort(403);
        }

        return view('trainer.workouts.create', [
            'title'    => 'Input Latihan Member',
            'member'   => $member,
            'workouts' => Workout::orderBy('nama_latihan')->get(),
        ]);
    }

    /**
     * Simpan latihan oleh trainer
     */
    public function store(Request $request, Member $member)
    {
        $trainer = Auth::user()->trainer;

        if ($member->trainer_id !== $trainer->id_trainer) {
            abort(403);
        }

        $request->validate([
            'tanggal' => ['required', 'date'],
            'exercises' => ['required', 'array'],
            'exercises.*.workout_id' => ['required', 'exists:workouts,id_workout'],
            'exercises.*.sets' => ['required', 'array'],
            'exercises.*.sets.*.beban' => ['nullable', 'numeric'],
            'exercises.*.sets.*.reps'  => ['nullable', 'integer'],
        ]);

        DB::transaction(function () use ($request, $member, $trainer) {

            foreach ($request->exercises as $exercise) {
                $setKe = 1;

                foreach ($exercise['sets'] as $set) {
                    DB::table('workout_logs')->insert([
                        'id_member'   => $member->id_member,
                        'id_trainer'  => $trainer->id_trainer,
                        'id_workout'  => $exercise['workout_id'],
                        'tanggal'     => $request->tanggal,
                        'jumlah_set'  => $setKe,
                        'beban'       => $set['beban'] ?? 0,
                        'reps'        => $set['reps'] ?? 0,
                        'created_at'  => now(),
                        'updated_at'  => now(),
                    ]);

                    $setKe++;
                }
            }
        });

        return redirect()
            ->route('trainer.members.detail', $member)
            ->with('success', 'Latihan berhasil dicatat.');
    }
}
