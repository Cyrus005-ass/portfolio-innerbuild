<?php

declare(strict_types=1);

$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$isLocalHost = (bool) preg_match('/^(localhost|127\\.0\\.0\\.1)(:\\d+)?$/', $host);
$projectFolder = basename(dirname(__DIR__, 2));
$basePath = $isLocalHost ? '/' . $projectFolder : '';

$httpsEnabled = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
$scheme = $httpsEnabled ? 'https' : 'http';
if (!$isLocalHost) {
    $scheme = 'https';
}

$appUrl = $scheme . '://' . $host . $basePath;

if ($isLocalHost && getenv('APP_ENV') === false) {
    putenv('APP_ENV=local');
}

$dbProfiles = [
    'local' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'innerbuild_db',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'production' => [
        'host' => 'sql100.infinityfree.com',
        'port' => 3306,
        'name' => 'if0_41706453_innerbuild_db',
        'user' => 'if0_41706453',
        'pass' => getenv('IF_DB_PASS') !== false ? (string) getenv('IF_DB_PASS') : '',
        'charset' => 'utf8mb4',
    ],
];

$selectedProfile = $isLocalHost ? 'local' : 'production';
$db = $dbProfiles[$selectedProfile];

$envOverride = getenv('APP_ENV');
if (is_string($envOverride) && $envOverride !== '') {
    if (strtolower($envOverride) === 'local') {
        $db = $dbProfiles['local'];
    } elseif (strtolower($envOverride) === 'production') {
        $db = $dbProfiles['production'];
    }
}

return [
    'app_name' => 'InnerBuild',
    'app_url' => $appUrl,
    'base_path' => $basePath,
    'env' => $isLocalHost ? 'local' : 'production',
    'timezone' => 'Africa/Porto-Novo',
    'db' => $db,
    'security' => [
        'max_upload_bytes' => 5 * 1024 * 1024,
        'allowed_image_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
        'allowed_doc_mimes' => ['application/pdf'],
    ],
    'admin' => [
        'fallback_email' => 'admin@innerbuild.local',
        'fallback_password' => 'ChangeMeNow123!',
    ],
    'analytics' => [
        'ga_measurement_id' => 'G-95W2Q21NZD',
    ],
];
