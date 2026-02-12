<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');
        $memberId  = $request->get('member_id');

        $allMembers = DB::table('members')->select('id_member', 'nama')->orderBy('nama')->get();

        // ==========================================
        // STATISTIK DASAR
        // ==========================================
        $today = now()->toDateString();
        $totalMember  = DB::table('members')->count();
        $totalTrainer = DB::table('trainers')->count();
        $totalLatihan = DB::table('workout_logs')->count();

        $memberAktif = DB::table('members')
            ->whereNotNull('aktif_hingga')
            ->whereDate('aktif_hingga', '>=', $today)
            ->count();

        $memberBelumAktif = DB::table('members')
            ->where(function($query) use ($today) {
                $query->whereNull('aktif_hingga') 
                    ->orWhereDate('aktif_hingga', '<', $today); 
            })
            ->count();

        // ==========================================
        // DYNAMIC CHART DATA (GRAFIK PENGUNJUNG)
        // ==========================================
        $chartStart = $startDate ? Carbon::parse($startDate) : now()->subDays(6);
        $chartEnd   = $endDate ? Carbon::parse($endDate) : now();
        $diffInDays = $chartStart->diffInDays($chartEnd);

        $labels = [];
        $dataPoints = [];

        if ($diffInDays <= 90) {
            // MODE HARIAN
            $chartRaw = DB::table('workout_logs')
                ->select(DB::raw('DATE(tanggal) as date'), DB::raw('COUNT(DISTINCT id_member) as total'))
                ->whereBetween('tanggal', [$chartStart->toDateString(), $chartEnd->toDateString()])
                ->groupBy('date')
                ->get();

            for ($date = $chartStart->copy(); $date->lte($chartEnd); $date->addDay()) {
                $labels[] = $date->translatedFormat('d M');
                $found = $chartRaw->firstWhere('date', $date->toDateString());
                $dataPoints[] = $found ? $found->total : 0;
            }
        } else {
            // MODE BULANAN
            $chartRaw = DB::table('workout_logs')
                ->select(DB::raw('DATE_FORMAT(tanggal, "%Y-%m") as month'), DB::raw('COUNT(DISTINCT id_member) as total'))
                ->whereBetween('tanggal', [$chartStart->toDateString(), $chartEnd->toDateString()])
                ->groupBy('month')
                ->orderBy('month', 'asc')
                ->get();

            for ($date = $chartStart->copy()->startOfMonth(); $date->lte($chartEnd); $date->addMonth()) {
                $labels[] = $date->translatedFormat('F Y');
                $found = $chartRaw->firstWhere('month', $date->format('Y-m'));
                $dataPoints[] = $found ? $found->total : 0;
            }
        }

        // ==========================================
        // DYNAMIC TOP 5 MEMBERS 
        // ==========================================
        $topQuery = DB::table('workout_logs')
            ->join('members', 'workout_logs.id_member', '=', 'members.id_member')
            ->select(
                'members.nama', 
                'members.foto', 
                DB::raw('COUNT(DISTINCT workout_logs.tanggal) as total_aktivitas')
            );

        if ($startDate && $endDate) {
            $topQuery->whereBetween('workout_logs.tanggal', [$startDate, $endDate]);
            $leaderboardTitle = "Leaderboard: " . Carbon::parse($startDate)->format('d/m/y') . " - " . Carbon::parse($endDate)->format('d/m/y');
        } else {
            $topQuery->whereMonth('workout_logs.tanggal', Carbon::now()->month)
                     ->whereYear('workout_logs.tanggal', Carbon::now()->year);
            $leaderboardTitle = "Leaderboard Bulan Ini";
        }

        $topMembers = $topQuery->groupBy('members.id_member', 'members.nama', 'members.foto')
            ->orderBy('total_aktivitas', 'desc')
            ->limit(5)
            ->get();

        // ==========================================
        // QUERY LAPORAN (TABEL DETAIL)
        // ==========================================
        $laporan = collect(); 
        $showDetailLaporan = $memberId ? true : false;
        $isFiltering = ($startDate || $endDate || $memberId);

        if ($showDetailLaporan) {
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

            $query->where('workout_logs.id_member', $memberId);
            if ($startDate && $endDate) {
                $query->whereBetween('workout_logs.tanggal', [$startDate, $endDate]);
            }

            $laporan = $query->orderBy('workout_logs.tanggal', 'desc')
                             ->orderBy('workout_logs.created_at', 'desc')
                             ->get();
        }

        // 1. Tentukan rentang filter (Default: Bulan ini jika filter kosong)
        $filterStart = $startDate ? Carbon::parse($startDate)->startOfDay() : now()->startOfMonth();
        $filterEnd   = $endDate ? Carbon::parse($endDate)->endOfDay() : now()->endOfMonth();

        // 2. Ambil data member yang 'tanggal_daftar'-nya masuk dalam rentang filter
        $membersKeuangan = DB::table('members')
            ->whereBetween('tanggal_daftar', [$filterStart->toDateString(), $filterEnd->toDateString()])
            ->whereNotNull('aktif_hingga')
            ->get();

        $totalOmzet = 0;

        foreach ($membersKeuangan as $m) {
            $tglAwal = \Carbon\Carbon::parse($m->tanggal_daftar)->startOfDay();
            $tglAkhir = \Carbon\Carbon::parse($m->aktif_hingga)->startOfDay();

            $selisihHari = $tglAwal->diffInDays($tglAkhir);
            if ($selisihHari >= 25 && $selisihHari <= 32) {
                $totalOmzet += 175000;
            } elseif ($selisihHari >= 1 && $selisihHari < 25) {
                $totalOmzet += ($selisihHari * 30000);
            } elseif ($selisihHari > 32) {
                $jumlahBulan = floor($selisihHari / 30);
                $totalOmzet += ($jumlahBulan * 175000);
            }
        }

        $pendapatanTitle = $startDate && $endDate 
            ? "Pendapatan: " . Carbon::parse($startDate)->format('d/m/y') . " - " . Carbon::parse($endDate)->format('d/m/y')
            : "Estimasi Pendapatan Bulan Ini";

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
            'isFiltering'      => $isFiltering,
            'topMembers'       => $topMembers,
            'leaderboardTitle' => $leaderboardTitle,
            'chartLabels'      => $labels,
            'chartData'        => $dataPoints,
            'showDetailLaporan'=> $showDetailLaporan,
            'pendapatan' => $totalOmzet,
            'pendapatanTitle' => $pendapatanTitle,
        ]);
    }
}