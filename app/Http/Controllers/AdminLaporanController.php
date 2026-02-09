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
    $today = now()->toDateString();

    $totalMember  = DB::table('members')->count();
    $totalTrainer = DB::table('trainers')->count();
    $totalLatihan = DB::table('workout_logs')->count();

    $memberAktif = DB::table('members')
    ->whereNotNull('aktif_hingga')
    ->whereDate('aktif_hingga', '>=', $today)
    ->count();

    // Member Belum Aktif / Tidak Aktif: 
    $memberBelumAktif = DB::table('members')
        ->where(function($query) use ($today) {
            $query->whereNull('aktif_hingga') 
                ->orWhereDate('aktif_hingga', '<', $today); 
        })
        ->count();

    // ==========================================
    // QUERY LAPORAN 
    // ==========================================
    $laporan = collect(); // Default kosong
    
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
        'isFiltering'      => $isFiltering 
    ]);
}
}