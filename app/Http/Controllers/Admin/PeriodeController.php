<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodePemilihan;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function index()
    {
        $periode = PeriodePemilihan::latest()->get();
        return view('admin.periode.index', compact('periode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        if ($request->status == 'Aktif') {
            PeriodePemilihan::where('status', 'Aktif')->update(['status' => 'Selesai']);
        }

        PeriodePemilihan::create($request->all());

        return back()->with('success', 'Periode pemilihan berhasil ditambahkan.');
    }

    public function update(Request $request, PeriodePemilihan $periode)
    {
        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        if ($request->status == 'Aktif') {
            PeriodePemilihan::where('id', '!=', $periode->id)->update(['status' => 'Selesai']);
        }

        $periode->update($request->all());

        return back()->with('success', 'Periode pemilihan berhasil diperbarui.');
    }

    public function destroy(PeriodePemilihan $periode)
    {
        $periode->delete();
        return back()->with('success', 'Periode pemilihan berhasil dihapus.');
    }
}
