<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MemberWorkoutHistoryController extends Controller
{
    public function index()
    {
        $member = Auth::user()->member;

        if (!$member) {
            abort(403);
        }

        $logs = DB::table('workout_logs')
            ->join('workouts', 'workouts.id_workout', '=', 'workout_logs.id_workout')
            ->where('workout_logs.id_member', $member->id_member)
            ->orderBy('workout_logs.tanggal', 'desc')
            ->orderBy('workout_logs.id_workout')
            ->get();

        $histories = [];

        foreach ($logs as $log) {
            $tanggal = $log->tanggal;

            if (!isset($histories[$tanggal])) {
                $histories[$tanggal] = [];
            }

            $workoutIndex = null;

            foreach ($histories[$tanggal] as $i => $item) {
                if ($item['workout'] === $log->nama_latihan) {
                    $workoutIndex = $i;
                    break;
                }
            }
            if ($workoutIndex === null) {
                $histories[$tanggal][] = [
                    'workout' => $log->nama_latihan,
                    'sets'    => []
                ];
                $workoutIndex = count($histories[$tanggal]) - 1;
            }

            // push set
            $histories[$tanggal][$workoutIndex]['sets'][] = [
                'beban' => $log->beban,
                'reps'  => $log->reps,
            ];
        }

        return view('member.workouts.history', [
            'title'     => 'History Latihan',
            'histories' => $histories
        ]);
    }
}
