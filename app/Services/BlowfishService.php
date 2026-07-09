<?php

namespace App\Services;

/**
 * BlowfishService — Layer enkripsi/dekripsi Blowfish untuk sistem E-Voting
 *
 * Menggunakan implementasi PHP murni (BlowfishPHP) agar tidak bergantung
 * pada OpenSSL, karena OpenSSL 3.0+ (XAMPP modern) menonaktifkan cipher
 * Blowfish (bf-cbc) secara default sebagai cipher legacy.
 *
 * Mode     : CBC (Cipher Block Chaining) dengan IV acak per enkripsi
 * Block    : 64-bit (8 byte)
 * IV       : 8 byte acak (dihasilkan per enkripsi)
 * Padding  : PKCS#7
 * Output   : Base64( IV (8 byte) || Ciphertext )
 *
 * Non-deterministic: plaintext yang sama → ciphertext berbeda (IV berbeda setiap kali)
 */
class BlowfishService
{
    const IV_LENGTH = 8; // Blowfish block size = 64-bit = 8 byte

    // =========================================================================
    // ENKRIPSI
    // =========================================================================

    /**
     * Enkripsi data menggunakan Blowfish-CBC (pure PHP)
     *
     * Langkah:
     * 1. Ambil secret key dari .env
     * 2. Generate IV acak 8 byte
     * 3. Enkripsi plaintext dengan BlowfishPHP (CBC + PKCS7 padding)
     * 4. Gabungkan IV + ciphertext, encode Base64
     *
     * @param  string $plaintext  Data asli (ID kandidat)
     * @return string             Base64(IV || Ciphertext)
     */
    public static function encrypt(string $plaintext): string
    {
        $key    = self::getKey();
        $iv     = random_bytes(self::IV_LENGTH);
        $cipher = new BlowfishPHP($key);
        $raw    = $cipher->encryptCBC($plaintext, $iv);

        return base64_encode($iv . $raw);
    }

    // =========================================================================
    // DEKRIPSI (hanya admin)
    // =========================================================================

    /**
     * Dekripsi data Blowfish-CBC (hanya dapat diakses oleh admin)
     *
     * Langkah:
     * 1. Decode Base64
     * 2. Pisahkan IV (8 byte pertama) dari ciphertext
     * 3. Dekripsi dengan BlowfishPHP menggunakan key + IV yang sama
     *
     * @param  string       $ciphertext  Base64(IV || Ciphertext)
     * @return string|false              Plaintext asli, atau false jika gagal
     */
    public static function decrypt(?string $ciphertext): string|false
    {
        if (empty($ciphertext)) {
            return false;
        }

        $key = self::getKey();

        $decoded = base64_decode($ciphertext, true);
        if ($decoded === false || strlen($decoded) <= self::IV_LENGTH) {
            return false; // format tidak valid (data lama pra-Blowfish)
        }

        $iv     = substr($decoded, 0, self::IV_LENGTH);
        $raw    = substr($decoded, self::IV_LENGTH);
        $cipher = new BlowfishPHP($key);

        return $cipher->decryptCBC($raw, $iv);
    }

    // =========================================================================
    // KEY MANAGEMENT
    // =========================================================================

    /**
     * Ambil BLOWFISH_KEY dari file .env
     * Membaca langsung dari file (bukan via config cache) agar selalu up-to-date.
     */
    public static function getKey(): string
    {
        $default = 'evoting2026secure';

        $path = base_path('.env');
        if (!file_exists($path)) {
            return $default;
        }

        $envContent = file_get_contents($path);
        if (preg_match('/^BLOWFISH_KEY=(.+)$/m', $envContent, $matches)) {
            $key = trim($matches[1], " \t\r\n\"'");
            if (strlen($key) >= 4) {
                return $key;
            }
        }

        return $default;
    }

    // =========================================================================
    // INFO ALGORITMA
    // =========================================================================

    /**
     * Informasi detail algoritma untuk halaman analisis kriptografi
     */
    public static function getAlgorithmInfo(): array
    {
        $key = self::getKey();
        return [
            'algoritma'     => 'Blowfish',
            'implementasi'  => 'Pure PHP (tanpa OpenSSL)',
            'mode'          => 'CBC (Cipher Block Chaining)',
            'block_size'    => '64-bit (8 byte)',
            'iv_size'       => self::IV_LENGTH . ' byte (64-bit, acak per enkripsi)',
            'key_length'    => strlen($key) . ' karakter (' . (strlen($key) * 8) . ' bit)',
            'key_range'     => '32–448 bit (4–56 karakter)',
            'rounds'        => '16 putaran Feistel Network',
            'padding'       => 'PKCS#7',
            'output_format' => 'Base64( IV (8 byte) || Ciphertext )',
        ];
    }
}
