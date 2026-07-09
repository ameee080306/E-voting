<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilVoting;
use App\Models\PeriodePemilihan;
use App\Models\User;

class LaporanController extends Controller
{
    public function index()
    {
        $periodeTerakhir = PeriodePemilihan::latest()->first();
        $hasil = HasilVoting::with('kandidat')->orderBy('jumlah_suara', 'desc')->get();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $sudahMemilih = User::where('role', 'mahasiswa')->where('status_memilih', 1)->count();
        $belumMemilih = $totalMahasiswa - $sudahMemilih;

        return view('admin.laporan.index', compact('periodeTerakhir', 'hasil', 'totalMahasiswa', 'sudahMemilih', 'belumMemilih'));
    }
}
