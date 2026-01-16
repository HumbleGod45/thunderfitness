<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminTrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with([
                'user',
                'members' // ⬅️ WAJIB untuk popup daftar member
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.trainer', [
            'trainers' => $trainers
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|string|min:6',
            'nama'             => 'required|string|max:255',
            'spesialis'        => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0',
            'telp'             => 'required|string|max:20',
            'foto'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'email.unique' => 'Email sudah terdaftar.',
            'foto.image'   => 'File harus berupa gambar.',
            'foto.max'     => 'Ukuran foto maksimal 2MB.',
        ]);

        DB::beginTransaction();

        try {
            // 1. Buat user trainer
            $user = User::create([
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role'     => 'trainer',
            ]);

            // 2. Upload foto (jika ada)
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('trainers', 'public');
            }

            // 3. Buat data trainer
            Trainer::create([
                'users_id_user'    => $user->id_user,
                'nama'             => $validated['nama'],
                'spesialis'        => $validated['spesialis'],
                'pengalaman_tahun' => $validated['pengalaman_tahun'],
                'telp'             => $validated['telp'],
                'foto'             => $fotoPath,
            ]);

            DB::commit();

            return back()->with('success', 'Trainer berhasil ditambahkan.');
        } catch (\Throwable $e) {
            DB::rollBack();

            if (!empty($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return back()->with('error', 'Gagal menambahkan trainer.');
        }
    }
    public function update(Request $request, Trainer $trainer)
    {
        $data = $request->validate([
            'nama'             => 'required|string|max:255',
            'spesialis'        => 'required|string|max:255',
            'pengalaman_tahun' => 'required|integer|min:0',
            'telp'             => 'required|string|max:20',
            'foto'             => 'nullable|image|max:2048',
        ]);
        // handle foto baru
        if ($request->hasFile('foto')) {
            if ($trainer->foto) {
                Storage::disk('public')->delete($trainer->foto);
            }

            $data['foto'] = $request->file('foto')
                ->store('trainers', 'public');
        }

        $trainer->update($data);

        return back()->with('success', 'Data trainer berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $trainer = Trainer::findOrFail($id);
        $user = User::find($trainer->users_id_user); // Ambil user terkait

        DB::beginTransaction();
        try {
            // 1. Hapus foto jika ada
            if ($trainer->foto) {
                Storage::disk('public')->delete($trainer->foto);
            }

            // 2. Hapus data trainer
            $trainer->delete();

            // 3. Hapus data user (agar email bisa didaftarkan lagi nantinya)
            if ($user) {
                $user->delete();
            }

            DB::commit();
            return back()->with('success', 'Trainer dan akun aksesnya berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
