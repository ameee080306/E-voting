<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Sistem E-Voting ini menggunakan BCrypt sebagai mekanisme hashing password.
    |
    | PENTING: Password TIDAK dienkripsi menggunakan algoritma Blowfish yang
    | diimplementasikan dalam BlowfishService. Blowfish hanya digunakan untuk
    | mengenkripsi data suara (kandidat ID) di tabel `votings`.
    |
    | Password menggunakan hashing satu arah (one-way) dengan BCrypt sehingga
    | tidak dapat dikembalikan ke bentuk aslinya (irreversible), berbeda dengan
    | enkripsi Blowfish yang bersifat dua arah (dapat didekripsi).
    |
    | Supported drivers: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | BCrypt Options
    |--------------------------------------------------------------------------
    |
    | BCrypt adalah algoritma hashing password yang aman dan telah teruji.
    |
    | Cost factor (rounds) menentukan seberapa lambat proses hashing —
    | semakin tinggi nilainya, semakin sulit untuk di-brute-force, namun
    | semakin lama waktu komputasinya.
    |
    | Nilai 12 rounds sudah sangat aman untuk keperluan produksi.
    | Nilai default Laravel adalah 10; proyek ini menggunakan 12 (lebih aman).
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),

        // Verifikasi bahwa hash yang tersimpan tidak memiliki cost terlalu rendah.
        // Laravel akan otomatis rehash jika cost di bawah nilai ini.
        'verify' => env('BCRYPT_VERIFY', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options (tidak digunakan, hanya sebagai referensi)
    |--------------------------------------------------------------------------
    */

    'argon' => [
        'memory' => env('ARGON_MEMORY', 65536),
        'threads' => env('ARGON_THREADS', 1),
        'time' => env('ARGON_TIME', 4),
    ],

];
