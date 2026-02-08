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
    $startDate = $request->get('start_date');
    $endDate   = $request->get('end_date');
    $memberId  = $request->get('member_id');

    // Data untuk dropdown filter
    $allMembers = DB::table('members')->select('id_member', 'nama')->orderBy('nama')->get();

    // ==========================================
    // STATISTIK UNTUK SUMMARY CARDS
    // ==========================================
    $totalMember  = DB::table('members')->count();
    $totalTrainer = DB::table('trainers')->count();
    $totalLatihan = DB::table('workout_logs')->count();

    // Member Aktif: Member yang ID-nya ada di workout_logs
    $memberAktif = DB::table('workout_logs')->distinct('id_member')->count('id_member');
    
    // Member Belum Aktif: Total - Aktif
    $memberBelumAktif = $totalMember - $memberAktif;

    // ==========================================
    // QUERY LAPORAN (Hanya dieksekusi jika ada filter)
    // ==========================================
    $laporan = collect(); // Default kosong
    
    // Cek apakah user sedang melakukan filter
    $isFiltering = $startDate || $endDate || $memberId;

    if ($isFiltering) {
        $query = DB::table('workout_logs')
            ->join('members', 'workout_logs.id_member', '=', 'members.id_member')
            ->join('workouts', 'workout_logs.id_workout', '=', 'workouts.id_workout')
            ->leftJoin('trainers', 'workout_logs.id_trainer', '=', 'trainers.id_trainer')
            ->select(
                'workout_logs.tanggal',
                'workout_logs.created_at',
                'members.nama as nama_member',
                'trainers.nama as nama_trainer',
                'workouts.nama_latihan',
                'workout_logs.beban',
                'workout_logs.reps'
            );

        if ($memberId) $query->where('workout_logs.id_member', $memberId);
        if ($startDate && $endDate) $query->whereBetween('workout_logs.tanggal', [$startDate, $endDate]);

        $laporan = $query->orderBy('workout_logs.tanggal', 'desc')
                         ->orderBy('workout_logs.created_at', 'desc')
                         ->get();
    }

    return view('admin.laporan', [
        'title'            => 'Laporan Aktivitas',
        'totalMember'      => $totalMember,
        'totalTrainer'     => $totalTrainer,
        'totalLatihan'     => $totalLatihan,
        'memberAktif'      => $memberAktif,
        'memberBelumAktif' => $memberBelumAktif,
        'laporan'          => $laporan,
        'allMembers'       => $allMembers,
        'startDate'        => $startDate,
        'endDate'          => $endDate,
        'isFiltering'      => $isFiltering // Kirim status filter ke Blade
    ]);
}
}