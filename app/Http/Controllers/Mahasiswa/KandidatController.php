<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;

class KandidatController extends Controller
{
    public function index()
    {
        $kandidats = Kandidat::all();
        return view('mahasiswa.kandidat', compact('kandidats'));
    }
}
