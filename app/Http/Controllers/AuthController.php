<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================
    // LOGIN
    // =========================
    public function showLoginForm()
    {
        return view('auth.login', [
            'title' => 'Login | Thunder Fitness'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('admin.home');
            } elseif ($role === 'trainer') {
                return redirect()->route('trainer.home');
            }

            return redirect()->route('member.home');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // =========================
    // REGISTER MEMBER
    // =========================
    public function showRegisterForm()
    {
        return view('auth.register', [
            'title' => 'Daftar Member | Thunder Fitness',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'min:6', 'confirmed'],
            'nama'             => ['required', 'string', 'max:255'],
            'tanggal_lahir'    => ['nullable', 'date'],
            'jenis_kelamin'   => ['nullable', 'string', 'max:20', 'before_or_equal:' . now()->subYears(15)->toDateString()],
            'alamat'           => ['nullable', 'string', 'max:255'],
            'telp'             => ['nullable', 'string', 'max:20'],
            'tinggi_badan'     => ['nullable', 'integer'],
            'berat_badan'      => ['nullable', 'integer'],
            'foto'             => ['nullable', 'image', 'max:2048'],
        ]);

        // === CREATE USER ===
        $user = User::create([
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'member',
        ]);
        // === UPLOAD FOTO ===
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('members', 'public');
        }

        // === CREATE MEMBER ===
        Member::create([
            'Users_id_user' => $user->id_user,
            'nama'          => $data['nama'],
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null, 
            'jenis_kelamin'  => $data['jenis_kelamin'] ?? null,
            'alamat'        => $data['alamat'] ?? null,
            'telp'          => $data['telp'] ?? null,
            'tinggi_badan'  => $data['tinggi_badan'] ?? null,
            'berat_badan'   => $data['berat_badan'] ?? null,
            'foto'          => $fotoPath,
        ]);

        // === AUTO LOGIN ===
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('member.home');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function updatePasswordSimple(Request $request)
    {
    // 1. Validasi input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        // 2. Cari user berdasarkan email dan update password-nya
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return back()->with('status', 'Password berhasil diperbarui. Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Gagal memperbarui password.']);
    }
}
