<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\WorkoutLog;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutLogController extends Controller
{
    /**
     * Form input latihan
     * Bisa dipakai trainer atau member
     */
    public function create(Member $member)
    {
        $user = Auth::user();

        // ambil semua master workout
        $workouts = Workout::orderBy('nama_latihan')->get();

        return view('workout_logs.create', [
            'member'   => $member,
            'workouts' => $workouts,
            'user'     => $user,
        ]);
    }

    /**
     * Simpan catatan latihan
     */
    public function store(Request $request, Member $member)
    {
        $data = $request->validate([
            'id_workout' => ['required', 'exists:workouts,id_workout'],
            'tanggal'    => ['required', 'date'],
            'jumlah_set' => ['required', 'integer', 'min:1'],
            'reps'       => ['required', 'integer', 'min:1'],
            'beban'      => ['nullable', 'numeric', 'min:0'],
            'catatan'    => ['nullable', 'string'],
        ]);

        $user = Auth::user();

        WorkoutLog::create([
            'id_member'  => $member->id_member,
            'id_trainer' => $user->role === 'trainer'
                                ? $user->trainer->id_trainer
                                : null,
            'id_workout' => $data['id_workout'],
            'tanggal'    => $data['tanggal'],
            'jumlah_set' => $data['jumlah_set'],
            'reps'       => $data['reps'],
            'beban'      => $data['beban'],
            'catatan'    => $data['catatan'],
        ]);

        return back()->with('success', 'Latihan berhasil dicatat.');
    }

    /**
     * Riwayat latihan member
     */
    public function index(Member $member)
    {
        $logs = WorkoutLog::with(['workout', 'trainer'])
            ->where('id_member', $member->id_member)
            ->orderByDesc('tanggal')
            ->get();

        return view('workout_logs.index', [
            'member' => $member,
            'logs'   => $logs,
        ]);
    }
}
