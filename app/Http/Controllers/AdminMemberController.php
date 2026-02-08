<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Trainer;
use Illuminate\Http\Request;

class AdminMemberController extends Controller
{
    /**
     * Halaman list member
     */
    public function index()
    {
        $members = Member::with('trainer')
            ->orderByRaw('aktif_hingga IS NOT NULL') 
            ->orderBy('aktif_hingga', 'asc')
            ->orderBy('id_member', 'desc')
            ->paginate(15); 

        $trainers = Trainer::orderBy('nama')->get();

        return view('admin.members', [
            'title'    => 'Kelola Member | Thunder Fitness',
            'members'  => $members,
            'trainers' => $trainers,
        ]);
    }

    /**
     * Update data member
     */
    public function update(Request $request, Member $member)
    {
        // 1. Validasi data
        $data = $request->validate([
            'nama'           => ['required', 'string', 'max:255'],
            'telp'           => ['nullable', 'string', 'max:20'],
            'tanggal_daftar' => ['nullable', 'date'],
            'aktif_hingga'   => ['nullable', 'date'],
            'trainer_id'     => ['nullable', 'exists:trainers,id_trainer'],
            'password'       => ['nullable', 'string', 'min:6'], 
        ]);

        if (array_key_exists('trainer_id', $data) && $data['trainer_id'] === '') {
            $data['trainer_id'] = null;
        }
        $member->update(collect($data)->except('password')->toArray());

        if ($request->filled('password')) {
            if ($member->user) {
                $member->user->update([
                    'password' => \Illuminate\Support\Facades\Hash::make($request->password)
                ]);
            }
        }

        return back()->with('success', 'Data member dan password berhasil diperbarui.');
    }
    /**
     * Hapus data member
     */
    public function destroy(Member $member)
    {
        if ($member->aktif_hingga && now()->lessThanOrEqualTo($member->aktif_hingga)) {
            return back()->with('error', 'Member masih aktif dan tidak dapat dihapus.');
        }

        try {
            $member->delete();
            return back()->with('success', 'Data member berhasil dihapus.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghapus data member.');
        }
    }
}