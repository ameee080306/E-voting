<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class KandidatController extends Controller
{
    public function index()
    {
        $kandidat = Kandidat::orderBy('nomor_urut')->get();
        return view('admin.kandidat.index', compact('kandidat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_urut' => 'required|integer|unique:kandidats',
            'nama_ketua' => 'required|string|max:100',
            'nama_wakil' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kandidat'), $filename);
            $fotoPath = 'uploads/kandidat/' . $filename;
        }

        Kandidat::create([
            'nomor_urut' => $request->nomor_urut,
            'nama_ketua' => $request->nama_ketua,
            'nama_wakil' => $request->nama_wakil,
            'foto' => $fotoPath,
            'visi' => $request->visi,
            'misi' => $request->misi,
        ]);

        return back()->with('success', 'Data kandidat berhasil ditambahkan.');
    }

    public function update(Request $request, Kandidat $kandidat)
    {
        $request->validate([
            'nomor_urut' => 'required|integer|unique:kandidats,nomor_urut,' . $kandidat->id,
            'nama_ketua' => 'required|string|max:100',
            'nama_wakil' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($kandidat->foto && File::exists(public_path($kandidat->foto))) {
                File::delete(public_path($kandidat->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/kandidat'), $filename);
            $kandidat->foto = 'uploads/kandidat/' . $filename;
        }

        $kandidat->update([
            'nomor_urut' => $request->nomor_urut,
            'nama_ketua' => $request->nama_ketua,
            'nama_wakil' => $request->nama_wakil,
            'visi' => $request->visi,
            'misi' => $request->misi,
        ]);

        return back()->with('success', 'Data kandidat berhasil diperbarui.');
    }

    public function destroy(Kandidat $kandidat)
    {
        if ($kandidat->foto && File::exists(public_path($kandidat->foto))) {
            File::delete(public_path($kandidat->foto));
        }
        $kandidat->delete();
        return back()->with('success', 'Data kandidat berhasil dihapus.');
    }
}
