<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilVoting;
use App\Models\PeriodePemilihan;

class HasilVotingController extends Controller
{
    public function index()
    {
        $periodeAktif = PeriodePemilihan::where('status', 'Aktif')->first();
        $hasil = HasilVoting::with('kandidat')->orderBy('jumlah_suara', 'desc')->get();
        
        return view('admin.hasil.index', compact('hasil', 'periodeAktif'));
    }
}
