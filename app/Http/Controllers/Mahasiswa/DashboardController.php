<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\PeriodePemilihan;

class DashboardController extends Controller
{
    public function index()
    {
        $periode = PeriodePemilihan::where('status', 'Aktif')->first();
        $totalKandidat = Kandidat::count();

        return view('mahasiswa.dashboard', compact('periode', 'totalKandidat'));
    }
}
