<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kandidats = \App\Models\Kandidat::all();
foreach ($kandidats as $k) {
    echo "ID: " . $k->id . " - Nomor Urut: " . $k->nomor_urut . " - Nama: " . $k->nama_ketua . "\n";
}
