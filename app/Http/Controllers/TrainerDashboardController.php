<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use Carbon\Carbon;

class TrainerDashboardController extends Controller
{
    public function home()
    {
        $user = Auth::user();

        // ambil data trainer dari user login
        $trainer = $user->trainer;

        // ambil member binaan trainer
        $members = $trainer
            ? $trainer->members()->orderBy('nama')->get()
            : collect();

        return view('trainer.member', [
            'title'   => 'Dashboard Trainer',
            'trainer' => $trainer,
            'members' => $members,
        ]);
    }

    /**
     * DETAIL MEMBER (dipanggil via AJAX)
     */
    public function detail(Member $member)
    {
        $trainer = Auth::user()->trainer;

        // SECURITY: pastikan member ini memang milik trainer tsb
        if (! $trainer || $member->trainer_id !== $trainer->id_trainer) {
            abort(403, 'Tidak punya akses ke member ini');
        }

        return response()->json([
            'nama' => $member->nama,
            'foto' => $member->foto
                ? asset('storage/' . $member->foto)
                : asset('images/member-default.png'),

            'telp' => $member->telp ?? '-',
            'alamat' => $member->alamat ?? '-',

            'tanggal_lahir' => $member->tanggal_lahir
                ? Carbon::parse($member->tanggal_lahir)->translatedFormat('d M Y')
                : '-',

            'jenis_kelamin' => $member->jenis_kelamin === 'L'
                ? 'Laki-laki'
                : ($member->jenis_kelamin === 'P' ? 'Perempuan' : '-'),

            'tinggi' => $member->tinggi_badan ?? '-',
            'berat'  => $member->berat_badan ?? '-',
        ]);
    }
}
