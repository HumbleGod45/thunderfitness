<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerWorkoutHistoryController extends Controller
{
    /**
     * Halaman awal history
     * Menampilkan dropdown member milik trainer
     */
    public function index()
    {
        $trainer = Auth::user()->trainer;

        $members = Member::where('trainer_id', $trainer->id_trainer)
            ->orderBy('nama')
            ->get();

        return view('trainer.history', [
            'title'   => 'History Latihan',
            'members' => $members,
            'logs'    => null, 
            'member'  => null,
        ]);
    }

    /**
     * Tampilkan history latihan per member
     */
    public function show(Member $member)
    {
        $trainer = Auth::user()->trainer;
        if ($member->trainer_id !== $trainer->id_trainer) {
            abort(403);
        }
        $members = Member::where('trainer_id', $trainer->id_trainer)
            ->orderBy('nama')
            ->get();

        // ambil log latihan
        $logs = DB::table('workout_logs')
            ->join('workouts', 'workout_logs.id_workout', '=', 'workouts.id_workout')
            ->where('workout_logs.id_member', $member->id_member)
            ->where('workout_logs.id_trainer', $trainer->id_trainer)
            ->select(
                'workout_logs.tanggal',
                'workouts.nama_latihan',
                'workout_logs.jumlah_set',
                'workout_logs.beban',
                'workout_logs.reps'
            )
            ->orderBy('workout_logs.tanggal', 'desc')
            ->orderBy('workout_logs.jumlah_set')
            ->get()
            ->groupBy('tanggal')
            ->map(function ($items) {
                return $items->groupBy('nama_latihan');
            });

        return view('trainer.history', [
            'title'   => 'History Latihan',
            'members' => $members,
            'member'  => $member,
            'logs'    => $logs,
        ]);
    }
}
