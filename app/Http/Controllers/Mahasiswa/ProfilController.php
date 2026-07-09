<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    public function index()
    {
        return view('mahasiswa.profil');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->nama = $request->nama;
        if ($request->password) {
            // PASSWORD: Hashing BCrypt satu arah — BUKAN enkripsi Blowfish
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            if ($user->foto && File::exists(public_path($user->foto))) {
                File::delete(public_path($user->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profil'), $filename);
            $user->foto = 'uploads/profil/' . $filename;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
