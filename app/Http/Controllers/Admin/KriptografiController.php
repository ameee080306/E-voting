<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kandidat;
use App\Models\Voting;
use App\Services\BlowfishService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class KriptografiController extends Controller
{
    /**
     * Halaman Analisis Kriptografi — hanya dapat diakses Admin
     * Menampilkan:
     *  - Key Management (4.7)
     *  - Simulator enkripsi/dekripsi (4.4 / 5.5.1)
     *  - Data suara terenkripsi + hasil dekripsi dari DB (4.3 / 5.1)
     *  - Info detail algoritma Blowfish-CBC
     */
    public function index()
    {
        // --- Info Kunci ---
        $key = BlowfishService::getKey();

        // --- Info Detail Algoritma ---
        $algoInfo = BlowfishService::getAlgorithmInfo();

        // --- Ambil data voting dari DB dan lakukan dekripsi ---
        $votings = Voting::with('user')->orderBy('created_at', 'desc')->get();
        $kandidats = Kandidat::all()->keyBy('id'); // Map by ID untuk lookup cepat

        $decryptedVotings  = [];
        $totalWaktuDekripsi = 0;
        $berhasilDekripsi  = 0;
        $gagalDekripsi     = 0;

        foreach ($votings as $vote) {
            $start     = microtime(true);
            $decrypted = BlowfishService::decrypt($vote->suara_terenkripsi);
            $time      = (microtime(true) - $start) * 1000; // ms
            $totalWaktuDekripsi += $time;

            // Cari nama kandidat berdasarkan ID hasil dekripsi
            $kandidatId   = $decrypted !== false ? (int) $decrypted : null;
            $kandidat     = ($kandidatId && isset($kandidats[$kandidatId])) ? $kandidats[$kandidatId] : null;
            $namaKandidat = $kandidat
                ? "No.{$kandidat->nomor_urut} — {$kandidat->nama_ketua} & {$kandidat->nama_wakil}"
                : 'Tidak Dikenal';

            if ($decrypted !== false && $decrypted !== '') {
                $berhasilDekripsi++;
            } else {
                $gagalDekripsi++;
            }

            $decryptedVotings[] = [
                'user'          => $vote->user->nama ?? 'Unknown',
                'nim'           => $vote->user->nim  ?? '-',
                'terenkripsi'   => $vote->suara_terenkripsi,
                'dekripsi'      => $decrypted ?: '',
                'nama_kandidat' => $namaKandidat,
                'waktu_ms'      => round($time, 4),
                'waktu_memilih' => $vote->waktu_memilih ?? $vote->created_at,
            ];
        }

        // --- 5.5 Analisis Kinerja ---
        $totalVoting        = count($votings);
        $rataRataDekripsi   = $totalVoting > 0 ? round($totalWaktuDekripsi / $totalVoting, 4) : 0;

        return view('admin.kriptografi.index', compact(
            'key',
            'algoInfo',
            'decryptedVotings',
            'rataRataDekripsi',
            'totalVoting',
            'berhasilDekripsi',
            'gagalDekripsi'
        ));
    }

    /**
     * Halaman Blowfish Playground — uji coba interaktif dengan visualisasi
     * Sama seperti simulate() tapi dengan tampilan yang lebih visual & edukatif
     */
    public function playground()
    {
        $key      = BlowfishService::getKey();
        $algoInfo = BlowfishService::getAlgorithmInfo();

        return view('admin.kriptografi.playground', compact('key', 'algoInfo'));
    }

    /**
     * 4.7 Pengelolaan Kunci (Key Management)
     * Update BLOWFISH_KEY di file .env
     */
    public function updateKey(Request $request)
    {
        $request->validate([
            'key' => 'required|string|min:4|max:56'
        ]);

        $path = base_path('.env');
        if (file_exists($path)) {
            $envContent = file_get_contents($path);
            if (strpos($envContent, 'BLOWFISH_KEY') !== false) {
                $envContent = preg_replace(
                    '/^BLOWFISH_KEY=.*$/m',
                    'BLOWFISH_KEY="' . $request->key . '"',
                    $envContent
                );
            } else {
                $envContent .= "\nBLOWFISH_KEY=\"" . $request->key . "\"";
            }
            file_put_contents($path, $envContent);

            // Bersihkan cache config agar kunci baru langsung terbaca
            Artisan::call('config:clear');
        }

        return redirect()->back()->with(
            'success',
            'Kunci Blowfish berhasil diperbarui! ⚠️ PERHATIAN: Data suara yang dienkripsi dengan kunci lama tidak dapat didekripsi dengan kunci baru.'
        );
    }

    /**
     * 4.4 Simulator Enkripsi & Dekripsi — 5.5.1 Analisis Waktu
     * Endpoint AJAX untuk menguji enkripsi/dekripsi secara langsung
     */
    public function simulate(Request $request)
    {
        $request->validate([
            'plain_text' => 'required|string'
        ]);

        $plainText = $request->plain_text;
        $algoInfo  = BlowfishService::getAlgorithmInfo();

        // --- Enkripsi ---
        $startEnc  = microtime(true);
        $encrypted = BlowfishService::encrypt($plainText);
        $timeEnc   = round((microtime(true) - $startEnc) * 1000, 4);

        // --- Dekripsi ---
        $startDec  = microtime(true);
        $decrypted = BlowfishService::decrypt($encrypted);
        $timeDec   = round((microtime(true) - $startDec) * 1000, 4);

        // Hitung ukuran untuk analisis
        $rawBytes    = base64_decode($encrypted);
        $ivHex       = bin2hex(substr($rawBytes, 0, 8));
        $cipherHex   = bin2hex(substr($rawBytes, 8));

        return response()->json([
            'plain_text'    => $plainText,
            'encrypted'     => $encrypted,
            'decrypted'     => $decrypted,
            'time_enc_ms'   => $timeEnc,
            'time_dec_ms'   => $timeDec,
            'iv_hex'        => $ivHex,
            'cipher_hex'    => $cipherHex,
            'cipher_length' => strlen($encrypted),
            'plain_length'  => strlen($plainText),
            'algo_info'     => $algoInfo,
        ]);
    }
}
