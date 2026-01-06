<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MemberProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();
        $member = $user?->member;

        if (! $member) {
            return back()->with('error', 'Data member tidak ditemukan.');
        }

        $rules = [];
        $messages = [];

        if ($request->has('nama')) {
            $rules['nama'] = ['required', 'string', 'max:255'];
            $messages['nama.required'] = 'Nama wajib diisi.';
        }
        if ($request->has('tanggal_lahir')) {
            $rules['tanggal_lahir'] = ['nullable', 'date'];
            $messages['tanggal_lahir.date'] = 'Tanggal lahir tidak valid.';
        }
        if ($request->has('jenis_kelamin')) {
            $rules['jenis_kelamin'] = ['nullable', 'string', 'max:20'];
            $messages['jenis_kelamin.string'] = 'Jenis kelamin harus diisi.';
        }
        if ($request->has('alamat')) {
            $rules['alamat'] = ['nullable', 'string', 'max:255'];
        }
        if ($request->has('telp')) {
            $rules['telp'] = ['nullable', 'string', 'max:20'];
        }
        if ($request->has('tinggi_badan')) {
            $rules['tinggi_badan'] = ['nullable', 'integer', 'min:1'];
            $messages['tinggi_badan.integer'] = 'Tinggi badan harus berupa angka.';
            $messages['tinggi_badan.min'] = 'Tinggi badan minimal 1 cm.';
        }
        if ($request->has('berat_badan')) {
            $rules['berat_badan'] = ['nullable', 'integer', 'min:1'];
            $messages['berat_badan.integer'] = 'Berat badan harus berupa angka.';
            $messages['berat_badan.min'] = 'Berat badan minimal 1 kg.';
        }
        if ($request->hasFile('foto')) {
            $rules['foto'] = ['nullable', 'image', 'max:2048'];
            $messages['foto.image'] = 'File harus berupa gambar.';
            $messages['foto.max'] = 'Ukuran gambar maksimal 2 MB.';
        }
        if (empty($rules)) {
            return back()->with('error', 'Tidak ada data yang dapat diperbarui.');
        }
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        foreach (['tinggi_badan', 'berat_badan', 'alamat', 'telp', 'nama'] as $k) {
            if (array_key_exists($k, $data) && $data[$k] === '') {
                $data[$k] = null;
            }
        }
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $fotoPath = $file->store('members', 'public');
        }

        DB::beginTransaction();
        try {
            if (! is_null($fotoPath)) {
                if (!empty($member->foto) && Storage::disk('public')->exists($member->foto)) {
                    Storage::disk('public')->delete($member->foto);
                }
                $data['foto'] = $fotoPath;
            } else {
                if (array_key_exists('foto', $data) && is_null($data['foto'])) {
                    unset($data['foto']);
                }
            }
            $member->update($data);

            DB::commit();
            $redirect = $request->has('_from_profile') ? route('member.profile') : route('member.home');

            return redirect($redirect)->with('success', 'Profil berhasil diperbarui.');
        } catch (Throwable $e) {
            DB::rollBack();
            if (!empty($fotoPath) && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            return back()->withInput()->with('error', 'Gagal memperbarui profil. Coba lagi.');
        }
    }

    public function show()
    {
        $user = Auth::user();
        $member = $user?->member;

        if (! $member) {
            return redirect()->route('member.home')
                ->with('error', 'Data member tidak ditemukan.');
        }

        $nama        = $member->nama ?? 'Member';
        $foto        = $member->foto ?? null;
        $tanggalLahir = $member->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->format('d F Y') : null;
        $jenisKelamin = $member->jenis_kelamin ?? null;
        $alamat      = $member->alamat ?? null;
        $telp        = $member->telp ?? null;
        $tinggi      = $member->tinggi_badan ?? null;
        $berat       = $member->berat_badan ?? null;
        $idMember    = $member->id_member ?? null;
        $startMember = $member->tanggal_daftar ? \Carbon\Carbon::parse($member->tanggal_daftar) : null;
        $aktifHingga = $member->aktif_hingga ? \Carbon\Carbon::parse($member->aktif_hingga) : null;
        $personalTrainer = $member->trainer?->nama;  

        // BMI
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

        $statusText = 'Belum Aktif';
        $badgeClasses = 'bg-gray-500/20 text-gray-300';
        if ($aktifHingga) {
            if ($aktifHingga->isFuture() || $aktifHingga->isToday()) {
                $statusText = 'Aktif';
                $badgeClasses = 'bg-emerald-400/15 text-emerald-300';
            } else {
                $statusText = 'Tidak Aktif';
                $badgeClasses = 'bg-red-400/15 text-red-300';
            }
        }

        return view('member.profile', compact(
            'member','nama','foto','alamat','telp','tinggi','berat',
            'idMember','startMember','aktifHingga','personalTrainer',
            'bmi','bmiCategory','bmiPosition','statusText','badgeClasses'
        ));
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return back()->with('error', 'User tidak ditemukan.');
        }

        $validator = Validator::make($request->all(), [
            'current_password' => ['required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'Masukkan password saat ini.',
            'password.required' => 'Masukkan password baru.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.'])->withInput();
        }

        try {
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return redirect()->route('member.profile')->with('success', 'Password berhasil diperbarui.');
        } catch (Throwable $e) {
            return back()->with('error', 'Gagal memperbarui password. Coba lagi.');
        }
    }
}
