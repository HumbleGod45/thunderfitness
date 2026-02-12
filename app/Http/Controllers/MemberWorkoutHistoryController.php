<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MemberWorkoutHistoryController extends Controller
{
    private function checkMemberStatus($member)
    {
        if (!$member) return false;
        $aktifHingga = $member->aktif_hingga ? Carbon::parse($member->aktif_hingga) : null;
        return $aktifHingga && ($aktifHingga->isFuture() || $aktifHingga->isToday());
    }
    public function index()
{
    $member = Auth::user()->member;

    if (!$member) {
        abort(403);
    }
    if (!$this->checkMemberStatus($member)) {
            return redirect()->route('member.home')->with('error', 'Akses dibatasi. Silakan perpanjang keanggotaan Anda untuk mengakses fitur Latihan.');
        }
    $logs = DB::table('workout_logs')
        ->join('workouts', 'workouts.id_workout', '=', 'workout_logs.id_workout')
        ->where('workout_logs.id_member', $member->id_member)
        ->orderBy('workout_logs.tanggal', 'desc')
        ->orderBy('workout_logs.created_at', 'desc') // Urutkan berdasarkan waktu input
        ->get();

    $histories = [];

    foreach ($logs as $log) {
        $tanggal = $log->tanggal;
        $sessionKey = $log->created_at; 

        if (!isset($histories[$tanggal])) {
            $histories[$tanggal] = [];
        }

        $workoutIndex = null;
        foreach ($histories[$tanggal] as $i => $item) {
            if ($item['workout'] === $log->nama_latihan && $item['time'] === $log->created_at) {
                $workoutIndex = $i;
                break;
            }
        }

        if ($workoutIndex === null) {
            $histories[$tanggal][] = [
                'workout' => $log->nama_latihan,
                'time'    => $log->created_at, 
                'sets'    => []
            ];
            $workoutIndex = count($histories[$tanggal]) - 1;
        }

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
