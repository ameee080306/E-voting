<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HasilVoting;
use App\Models\Kandidat;
use App\Models\PeriodePemilihan;
use App\Models\User;
use App\Models\Voting;
use App\Services\BlowfishService;

class DashboardController extends Controller
{
    public function index()
    {
        // --- Statistik Mahasiswa ---
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $totalKandidat  = Kandidat::count();
        $sudahMemilih   = User::where('role', 'mahasiswa')->where('status_memilih', 1)->count();
        $belumMemilih   = $totalMahasiswa - $sudahMemilih;
        $persentase     = $totalMahasiswa > 0 ? round(($sudahMemilih / $totalMahasiswa) * 100, 2) : 0;

        // --- Periode Aktif ---
        $periodeAktif = PeriodePemilihan::where('status', 'Aktif')->first();

        // --- Data Keamanan Sistem (Blowfish) ---
        $totalSuaraTerenkripsi = Voting::count();
        $algoInfo              = BlowfishService::getAlgorithmInfo();

        // --- Rekapitulasi Suara Sementara ---
        $hasilVoting = HasilVoting::with('kandidat')
            ->orderBy('jumlah_suara', 'desc')
            ->get();

        // --- Aktivitas Voting Terbaru (5 terakhir, tanpa ciphertext) ---
        $recentVotings = Voting::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMahasiswa',
            'totalKandidat',
            'sudahMemilih',
            'belumMemilih',
            'persentase',
            'periodeAktif',
            'totalSuaraTerenkripsi',
            'algoInfo',
            'hasilVoting',
            'recentVotings'
        ));
    }
}
