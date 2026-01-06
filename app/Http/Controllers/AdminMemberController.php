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
            ->orderBy('id_member')
            ->get();

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
        $data = $request->validate([
            'nama'           => ['required', 'string', 'max:255'],
            'telp'           => ['nullable', 'string', 'max:20'],
            'tanggal_daftar' => ['nullable', 'date'],
            'aktif_hingga'   => ['nullable', 'date'],
            'trainer_id'     => ['nullable', 'exists:trainers,id_trainer'],
        ]);

        // kalau dropdown pilih "-" (string kosong)
        if (array_key_exists('trainer_id', $data) && $data['trainer_id'] === '') {
            $data['trainer_id'] = null;
        }

        $member->update($data);

        return back()->with('success', 'Data member berhasil diperbarui.');
    }

    /**
     * Hapus data member
     */
    public function destroy(Member $member)
{
    // Cegah hapus jika member masih aktif
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