<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class TrainerProfileController extends Controller
{
    /**
     * Tampilkan halaman profile trainer
     */
    public function index()
    {
        $user    = Auth::user();
        $trainer = $user->trainer;

        return view('trainer.profile', [
            'title'   => 'Profile Trainer',
            'trainer' => $trainer,
            'user'    => $user,
        ]);
    }
    /**
     * Update profil trainer
     */
    public function update(Request $request)
    {
        $trainer = Auth::user()->trainer;

        if (! $trainer) {
            return redirect()->back()
                ->with('error', 'Data trainer tidak ditemukan');
        }

        $validated = $request->validate([
            'nama'               => 'required|string|max:255',
            'telp'               => 'nullable|string|max:20',
            'spesialis'          => 'nullable|string|max:255',
            'pengalaman_tahun'   => 'nullable|integer|min:0|max:50',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            // ================= FOTO =================
            if ($request->hasFile('foto')) {

                // hapus foto lama (kecuali default)
                if ($trainer->foto && Storage::disk('public')->exists($trainer->foto)) {
                    Storage::disk('public')->delete($trainer->foto);
                }

                $validated['foto'] = $request
                    ->file('foto')
                    ->store('trainer', 'public');
            }

            // ================= UPDATE DATA =================
            $trainer->update($validated);

            return redirect()->back()
                ->with('success', 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profil');
        }
    }
    /**
     * Reset password trainer
     */
    public function resetPassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);
        // cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        Auth::logout();
        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah, silakan login ulang');
    }
}