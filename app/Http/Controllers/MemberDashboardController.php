<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;
use Carbon\Carbon;

class MemberDashboardController extends Controller
{
    public function home()
    {
        $user   = Auth::user();
        $member = $user?->member;

        // ===== BASIC MEMBER DATA =====
        $nama        = $member->nama ?? 'Member';
        $tinggi      = $member->tinggi_badan ?? null;
        $berat       = $member->berat_badan ?? null;
        $idMember    = $member->id_member ?? null;
        $startMember = $member->tanggal_daftar
            ? Carbon::parse($member->tanggal_daftar)
            : null;
        $aktifHingga = $member->aktif_hingga
            ? Carbon::parse($member->aktif_hingga)
            : null;
        $personalTrainer = $member->trainer?->nama;
        $foto = $member->foto ?? null;

        // ===== BMI =====
        $bmi = null;
        $bmiCategory = null;
        $bmiPosition = 50;

        if ($tinggi && $berat && $tinggi > 0) {
            $bmi = $berat / pow($tinggi / 100, 2);

            if ($bmi < 18.5) {
                $bmiCategory = 'Kurus';
                $bmiPosition = 15;
            } elseif ($bmi < 25) {
                $bmiCategory = 'Ideal';
                $bmiPosition = 50;
            } else {
                $bmiCategory = 'Obesitas';
                $bmiPosition = 85;
            }
        }

        // ===== STATUS MEMBER =====
        $statusText   = 'Belum Aktif';
        $statusColor  = 'gray';
        $badgeClasses = 'bg-gray-700/30 text-gray-200 border border-white/10';

        if ($aktifHingga) {
            if ($aktifHingga->isFuture() || $aktifHingga->isToday()) {
                $statusText   = 'Aktif';
                $statusColor  = 'green';
                $badgeClasses = 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/10';
            } else {
                $statusText   = 'Tidak Aktif';
                $statusColor  = 'gray';
                $badgeClasses = 'bg-gray-700/40 text-gray-200 border border-white/10';
            }
        } else {
            $statusText   = 'Belum Aktif';
            $badgeClasses = 'bg-yellow-600/10 text-yellow-300 border border-yellow-600/10';
        }

        // ===== LAST WORKOUT =====
        $lastWorkoutDate = null;
        $lastWorkout     = collect();

        if ($member) {
            $lastWorkoutDate = DB::table('workout_logs')
                ->where('id_member', $member->id_member)
                ->max('tanggal');

            if ($lastWorkoutDate) {
                $lastWorkout = DB::table('workout_logs')
                    ->join('workouts', 'workout_logs.id_workout', '=', 'workouts.id_workout')
                    ->where('workout_logs.id_member', $member->id_member)
                    ->where('workout_logs.tanggal', $lastWorkoutDate)
                    ->orderBy('workout_logs.id_workout_log')
                    ->get();
            }
        }

        $announcement = Announcement::where('is_active', 1)
            ->whereIn('target', ['all', 'member'])
            ->latest()
            ->first();
         
        $showRenewalNotice = false;

        if ($aktifHingga) {
            if ($aktifHingga->isFuture() || $aktifHingga->isToday()) {
                $statusText   = 'Aktif';
                $badgeClasses = 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/10';
            } else {
                $statusText   = 'Tidak Aktif';
                $badgeClasses = 'bg-gray-700/40 text-gray-200 border border-white/10';
                $showRenewalNotice = true; 
            }
        } else {
            $statusText   = 'Belum Aktif';
            $badgeClasses = 'bg-yellow-600/10 text-yellow-300 border border-yellow-600/10';
            $showRenewalNotice = true; 
        }

        return view('member.home', compact(
            'member',
            'nama',
            'tinggi',
            'berat',
            'idMember',
            'startMember',
            'aktifHingga',
            'personalTrainer',
            'bmi',
            'bmiCategory',
            'bmiPosition',
            'statusText',
            'statusColor',
            'badgeClasses',
            'foto',
            'lastWorkoutDate',
            'lastWorkout',
            'announcement',
            'showRenewalNotice'
        ));
    }
}
