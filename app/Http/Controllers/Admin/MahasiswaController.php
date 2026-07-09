<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Services\BlowfishService;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = User::where('role', 'mahasiswa')->get();
        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function update(Request $request, User $mahasiswa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $mahasiswa->update([
            'nama' => $request->nama,
        ]);

        if ($request->filled('password')) {
            $mahasiswa->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

}
