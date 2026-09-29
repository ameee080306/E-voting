<?php

/**
 * Pindahkan directory penyimpanan (storage) Laravel ke `/tmp` 
 * karena Vercel menggunakan file system serverless yang bersifat read-only.
 */
$tmpStorage = '/tmp/storage';
$tmpCache = '/tmp/cache';

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

if (!file_exists($tmpCache)) {
    mkdir($tmpCache, 0777, true);
}

// Override path penyimpanan Vercel
putenv('VIEW_COMPILED_PATH=' . $tmpStorage . '/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = $tmpStorage . '/framework/views';

// Override bootstrap cache path
putenv('APP_SERVICES_CACHE=' . $tmpCache . '/services.php');
putenv('APP_PACKAGES_CACHE=' . $tmpCache . '/packages.php');
putenv('APP_CONFIG_CACHE=' . $tmpCache . '/config.php');
putenv('APP_ROUTES_CACHE=' . $tmpCache . '/routes.php');
putenv('APP_EVENTS_CACHE=' . $tmpCache . '/events.php');

$_ENV['APP_SERVICES_CACHE'] = $tmpCache . '/services.php';
$_ENV['APP_PACKAGES_CACHE'] = $tmpCache . '/packages.php';
$_ENV['APP_CONFIG_CACHE'] = $tmpCache . '/config.php';
$_ENV['APP_ROUTES_CACHE'] = $tmpCache . '/routes.php';
$_ENV['APP_EVENTS_CACHE'] = $tmpCache . '/events.php';

// Memastikan base application load dengan storage path di /tmp
$app = require __DIR__ . '/../bootstrap/app.php';

if (method_exists($app, 'useStoragePath')) {
    $app->useStoragePath($tmpStorage);
}

$app->handleRequest(Illuminate\Http\Request::capture());
