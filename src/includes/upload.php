<?php
/**
 * Utilitaire d'upload securise.
 */

function ensureUploadDirectory(string $destinationDir): void
{
    if (!is_dir($destinationDir) && !mkdir($destinationDir, 0755, true) && !is_dir($destinationDir)) {
        throw new RuntimeException('Impossible de preparer le dossier de destination.');
    }
}

function createImageFromMime(string $tmpPath, string $mimeType)
{
    return match ($mimeType) {
        'image/jpeg' => @imagecreatefromjpeg($tmpPath),
        'image/png' => @imagecreatefrompng($tmpPath),
        'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmpPath) : false,
        'image/gif' => @imagecreatefromgif($tmpPath),
        default => false,
    };
}

function writeOptimizedWebp($sourceImage, int $sourceWidth, int $sourceHeight, string $destinationPath): bool
{
    if (!function_exists('imagewebp')) {
        return false;
    }

    $maxWidth = 2200;
    $maxHeight = 2200;
    $scale = min(1, $maxWidth / max(1, $sourceWidth), $maxHeight / max(1, $sourceHeight));
    $targetWidth = max(1, (int) round($sourceWidth * $scale));
    $targetHeight = max(1, (int) round($sourceHeight * $scale));

    $target = imagecreatetruecolor($targetWidth, $targetHeight);
    if (!$target) {
        return false;
    }

    imagealphablending($target, true);
    imagesavealpha($target, true);

    if (!imagecopyresampled($target, $sourceImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $sourceWidth, $sourceHeight)) {
        imagedestroy($target);
        return false;
    }

    $written = imagewebp($target, $destinationPath, 80);
    imagedestroy($target);

    return (bool) $written;
}

/**
 * Gere l'upload d'une image de facon securisee et optimisee.
 */
function handleImageUpload($file, $destinationDir)
{
    if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 5000000) {
        throw new RuntimeException('Le fichier est trop volumineux (max 5MB).');
    }

    $tmpPath = $file['tmp_name'] ?? '';
    if ($tmpPath === '' || !is_uploaded_file($tmpPath)) {
        throw new RuntimeException('Upload invalide.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = (string) $finfo->file($tmpPath);

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];

    if (!in_array($mimeType, $allowedMimeTypes, true)) {
        throw new RuntimeException('Format de fichier non valide. Seules les images sont autorisees.');
    }

    ensureUploadDirectory($destinationDir);

    $baseName = sha1_file($tmpPath) . '_' . bin2hex(random_bytes(4));
    $newFileName = $baseName . '.webp';
    $destinationPath = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . $newFileName;

    $sourceImage = createImageFromMime($tmpPath, $mimeType);
    if ($sourceImage !== false) {
        $sourceWidth = (int) imagesx($sourceImage);
        $sourceHeight = (int) imagesy($sourceImage);
        $optimized = writeOptimizedWebp($sourceImage, $sourceWidth, $sourceHeight, $destinationPath);
        imagedestroy($sourceImage);

        if ($optimized) {
            return $newFileName;
        }
    }

    $fallbackExt = match ($mimeType) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        default => 'webp',
    };

    $newFileName = $baseName . '.' . $fallbackExt;
    $destinationPath = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . $newFileName;

    if (!move_uploaded_file($tmpPath, $destinationPath)) {
        throw new RuntimeException('Echec du deplacement du fichier telecharge.');
    }

    return $newFileName;
}

/**
 * Gere l'upload d'un fichier (PDF, DOCX).
 */
function handleFileUpload($file, $destinationDir)
{
    if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 10000000) {
        throw new RuntimeException('Le fichier est trop volumineux (max 10MB).');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = (string) $finfo->file($file['tmp_name']);

    $allowedMimeTypes = [
        'pdf' => 'application/pdf',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'doc' => 'application/msword',
    ];

    $ext = array_search($mimeType, $allowedMimeTypes, true);
    if ($ext === false) {
        throw new RuntimeException('Format de fichier non valide. Seuls les PDF et DOCX sont autorises.');
    }

    ensureUploadDirectory($destinationDir);

    $newFileName = sprintf('cv_%s.%s', bin2hex(random_bytes(6)), $ext);
    $destinationPath = rtrim($destinationDir, '/\\') . DIRECTORY_SEPARATOR . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        throw new RuntimeException('Echec du deplacement du fichier telecharge.');
    }

    return $newFileName;
}
