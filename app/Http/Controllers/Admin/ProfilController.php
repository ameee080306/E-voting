<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('admin.profil', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;

        if ($request->filled('password')) {
            // PASSWORD: Hashing BCrypt satu arah — BUKAN enkripsi Blowfish
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && File::exists(public_path($user->foto))) {
                File::delete(public_path($user->foto));
            }

            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/profil'), $filename);
            $user->foto = 'uploads/profil/' . $filename;
        }

        $user->save();

        return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
