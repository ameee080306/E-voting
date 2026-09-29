<?php

/**
 * Pindahkan directory penyimpanan (storage) Laravel ke `/tmp` 
 * karena Vercel menggunakan file system serverless yang bersifat read-only
 * kecuali folder `/tmp`.
 */
$tmpStorage = '/tmp/storage';

if (!file_exists($tmpStorage)) {
    mkdir($tmpStorage, 0777, true);
    mkdir($tmpStorage . '/app', 0777, true);
    mkdir($tmpStorage . '/framework', 0777, true);
    mkdir($tmpStorage . '/framework/cache', 0777, true);
    mkdir($tmpStorage . '/framework/cache/data', 0777, true);
    mkdir($tmpStorage . '/framework/sessions', 0777, true);
    mkdir($tmpStorage . '/framework/views', 0777, true);
    mkdir($tmpStorage . '/logs', 0777, true);
}

// Override environment variable agar Laravel membaca folder yang baru
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';

// Load the normal index file
require __DIR__ . '/../public/index.php';
