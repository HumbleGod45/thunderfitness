<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Workout;

class MemberWorkoutController extends Controller
{
    /**
     * Form input latihan
     */
    public function create()
    {
        return view('member.workouts.create', [
            'title'    => 'Input Latihan',
            'workouts' => Workout::orderBy('nama_latihan')->get(),
        ]);
    }

    /**
     * Simpan latihan member
     */
    public function store(Request $request)
{
    $member = Auth::user()->member;

    if (!$member) {
        return back()->with('error', 'Data member tidak ditemukan.');
    }

    $request->validate([
        'tanggal' => ['required', 'date'],
        'exercises' => ['required', 'array'],
        'exercises.*.workout_id' => ['required', 'exists:workouts,id_workout'],
        'exercises.*.sets' => ['required', 'array'],
        'exercises.*.sets.*.beban' => ['nullable', 'numeric'],
        'exercises.*.sets.*.reps'  => ['nullable', 'integer'],
    ]);

    DB::beginTransaction();

    try {
        foreach ($request->exercises as $exercise) {

            $jumlahSet = count($exercise['sets']);

            foreach ($exercise['sets'] as $set) {
                DB::table('workout_logs')->insert([
                    'id_member'   => $member->id_member,
                    'id_trainer'  => null, // karena member input sendiri
                    'id_workout'  => $exercise['workout_id'],
                    'tanggal'     => $request->tanggal,
                    'jumlah_set'  => $jumlahSet,
                    'beban'       => $set['beban'] ?? 0,
                    'reps'        => $set['reps'] ?? 0,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        DB::commit();

        return redirect()
            ->route('member.workouts.create')
            ->with('success', 'Latihan berhasil disimpan.');

    } catch (\Exception $e) {
        DB::rollBack();
        dd($e->getMessage());
    }
}
}
