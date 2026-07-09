<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\PeriodePemilihan;
use App\Models\Voting;
use App\Models\HasilVoting;
use App\Services\BlowfishService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->status_memilih) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memberikan suara.');
        }

        $periode = PeriodePemilihan::where('status', 'Aktif')->first();
        if (!$periode) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Tidak ada periode pemilihan yang sedang aktif.');
        }

        $kandidats = Kandidat::all();
        return view('mahasiswa.voting', compact('kandidats', 'periode'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->status_memilih) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Anda sudah memberikan suara.');
        }

        $periode = PeriodePemilihan::where('status', 'Aktif')->first();
        if (!$periode) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Tidak ada periode pemilihan yang sedang aktif.');
        }

        $request->validate([
            'kandidat_id' => 'required|exists:kandidats,id'
        ]);

        DB::transaction(function () use ($user, $request) {
            // === PROSES ENKRIPSI BLOWFISH (CBC + IV) ===
            // Enkripsi ID kandidat menggunakan Blowfish-CBC dengan secret key dari server.
            // Hanya ciphertext yang disimpan ke database — data pilihan asli tidak disimpan.
            // Cari kandidat untuk mendapatkan nomor urutnya
            $kandidat = Kandidat::find($request->kandidat_id);
            
            $startEnc = microtime(true);
            $suaraTerenkripsi = BlowfishService::encrypt((string) $kandidat->nomor_urut);
            $waktuEnkripsi = round((microtime(true) - $startEnc) * 1000, 4);

            // Log proses enkripsi untuk audit trail (tanpa menyimpan plaintext)
            Log::info('Blowfish Encryption', [
                'user_id'       => $user->id,
                'algoritma'     => 'bf-cbc',
                'waktu_enc_ms'  => $waktuEnkripsi,
                'ciphertext_len'=> strlen($suaraTerenkripsi),
            ]);

            // Simpan hanya ciphertext ke tabel votings
            Voting::create([
                'user_id'          => $user->id,
                'suara_terenkripsi'=> $suaraTerenkripsi,
                'waktu_memilih'    => now(),
            ]);

            // Tandai mahasiswa sudah memilih
            $user->status_memilih = 1;
            $user->save();

            // Update rekapitulasi suara (HasilVoting) — menggunakan kandidat_id plaintext
            // yang berasal dari input yang sudah divalidasi, bukan dari dekripsi.
            // Ini memungkinkan penghitungan suara tanpa perlu dekripsi setiap rekord.
            $hasil = HasilVoting::firstOrCreate(['kandidat_id' => $request->kandidat_id]);
            $hasil->increment('jumlah_suara');
        });

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Voting berhasil! Terima kasih atas partisipasi Anda.');
    }
}
