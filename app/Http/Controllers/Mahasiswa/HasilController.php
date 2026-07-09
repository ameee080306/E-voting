<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\HasilVoting;
use App\Models\PeriodePemilihan;

class HasilController extends Controller
{
    public function index()
    {
        $periode = PeriodePemilihan::where('status', 'Aktif')->first();
        if ($periode) {
            return view('mahasiswa.hasil_pending', compact('periode'));
        }

        $hasil = HasilVoting::with('kandidat')->orderBy('jumlah_suara', 'desc')->get();
        return view('mahasiswa.hasil', compact('hasil'));
    }
}
