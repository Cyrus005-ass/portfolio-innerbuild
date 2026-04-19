<?php

declare(strict_types=1);

return [
    'app_name' => 'InnerBuild',
    'app_url' => 'http://localhost/inner/public',
    'timezone' => 'Africa/Porto-Novo',
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'innerbuild_db',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
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
