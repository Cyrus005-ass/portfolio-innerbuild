<?php
/**
 * Helpers - Fonctions utilitaires globales
 */

function e($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

function getWhatsAppLink($phone, $text = '')
{
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return 'https://wa.me/' . $phone . (!empty($text) ? '?text=' . urlencode($text) : '');
}

function formatDate($date, $format = 'M Y')
{
    if (empty($date)) {
        return '';
    }

    return date($format, strtotime($date));
}

function appBasePath(): string
{
    global $config;

    $basePath = $config['base_path'] ?? '';
    return rtrim((string) $basePath, '/');
}

function resolveMediaPath(?string $fileName, string $fallback = '/assets/img/cyr.png'): string
{
    $fileName = trim((string) $fileName);
    $basePath = appBasePath();

    if ($fileName === '') {
        return $basePath . $fallback;
    }

    if (preg_match('#^https?://#i', $fileName)) {
        return $fileName;
    }

    $safeName = basename($fileName);
    $uploadPath = __DIR__ . '/../uploads/' . $safeName;
    if (is_file($uploadPath)) {
        return $basePath . '/src/uploads/' . rawurlencode($safeName);
    }

    $assetPath = __DIR__ . '/../../assets/img/' . $safeName;
    if (is_file($assetPath)) {
        return $basePath . '/assets/img/' . rawurlencode($safeName);
    }

    return $basePath . $fallback;
}
