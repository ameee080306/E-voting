<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\BlowfishService;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $users = User::all();
        $authenticatedUser = null;

        foreach ($users as $user) {
            $decNim = BlowfishService::decrypt($user->nim) ?: $user->nim;
            $decEmail = BlowfishService::decrypt($user->email) ?: $user->email;

            if ($decNim === $request->login || $decEmail === $request->login) {
                if (Hash::check($request->password, $user->password)) {
                    $authenticatedUser = $user;
                    break;
                }
            }
        }

        if ($authenticatedUser) {
            Auth::login($authenticatedUser);
            $request->session()->regenerate();
            if ($authenticatedUser->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors([
            'login' => 'Kredensial tidak cocok dengan data kami.',
        ]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nim'      => 'required|string',
            'nama'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Validasi unik manual karena data di DB terenkripsi
        $allUsers = User::all();
        foreach ($allUsers as $u) {
            $decNim = BlowfishService::decrypt($u->nim) ?: $u->nim;
            $decEmail = BlowfishService::decrypt($u->email) ?: $u->email;

            if ($decNim === $request->nim) {
                return back()->withErrors(['nim' => 'NIM sudah terdaftar.'])->withInput();
            }
            if ($decEmail === $request->email) {
                return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
            }
        }

        $user = User::create([
            'nim'           => BlowfishService::encrypt($request->nim),
            'nama'          => $request->nama,
            'email'         => BlowfishService::encrypt($request->email),
            'password'      => Hash::make($request->password),
            'role'          => 'mahasiswa',
            'status_memilih'=> 0,
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login menggunakan akun yang baru saja dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
