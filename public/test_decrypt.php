<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$key = \App\Services\BlowfishService::getKey();
$ciphertext = 'K5c4b7CjwX+8F5Bw7pYccw==';
$plaintext = \App\Services\BlowfishService::decrypt($ciphertext);

echo "BERHASIL DEKRIPSI!\n";
echo "Ciphertext: " . $ciphertext . "\n";
echo "Hasil / ID Kandidat: " . $plaintext . "\n";
