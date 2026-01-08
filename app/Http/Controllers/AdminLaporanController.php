<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLaporanController extends Controller
{
    /**
     * Halaman laporan admin
     */
    public function index(Request $request)
    {
        // filter tanggal (optional, default hari ini)
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');

        // =========================
        // SUMMARY CARD
        // =========================
        $totalMember  = DB::table('members')->count();
        $totalTrainer = DB::table('trainers')->count();
        $totalLatihan = DB::table('workout_logs')->count();

        // =========================
        // QUERY LAPORAN LATIHAN
        // =========================
        $query = DB::table('workout_logs')
            ->join('members', 'workout_logs.id_member', '=', 'members.id_member')
            ->join('trainers', 'workout_logs.id_trainer', '=', 'trainers.id_trainer')
            ->join('workouts', 'workout_logs.id_workout', '=', 'workouts.id_workout')
            ->select(
                'workout_logs.tanggal',
                'members.nama as nama_member',
                'trainers.nama as nama_trainer',
                'workouts.nama_latihan',
                'workout_logs.beban',
                'workout_logs.reps'
            )
            ->orderBy('workout_logs.tanggal', 'desc');

        // filter tanggal kalau ada
        if ($startDate && $endDate) {
            $query->whereBetween('workout_logs.tanggal', [$startDate, $endDate]);
        }

        $laporan = $query->get();

        return view('admin.laporan', [
            'title'         => 'Laporan',
            'totalMember'   => $totalMember,
            'totalTrainer'  => $totalTrainer,
            'totalLatihan'  => $totalLatihan,
            'laporan'       => $laporan,
            'startDate'     => $startDate,
            'endDate'       => $endDate,
        ]);
    }
}
