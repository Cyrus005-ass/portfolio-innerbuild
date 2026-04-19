<?php
/**
 * Utilitaire d'upload sécurisé
 */

/**
 * Gère l'upload d'une image de façon sécurisée
 * 
 * @param array $file $_FILES['input_name']
 * @param string $destinationDir Dossier de destination absolu
 * @return string|false Le nom du fichier généré ou false en cas d'erreur
 */
function handleImageUpload($file, $destinationDir) {
    // Vérifier les erreurs natives de PHP
    if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // Vérifier la taille (max 5 MB)
    if ($file['size'] > 5000000) {
        throw new RuntimeException('Le fichier est trop volumineux.');
    }

    // Vérifier le type MIME réel (la confiance en $_FILES['type'] est dangereuse)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    $allowedMimeTypes = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'webp' => 'image/webp'
    ];

    $ext = array_search($mimeType, $allowedMimeTypes, true);

    if ($ext === false) {
        throw new RuntimeException('Format de fichier non valide. Seules les images sont autorisées.');
    }

    // Générer un nom de fichier unique de manière sécurisée
    $newFileName = sprintf('%s.%s', sha1_file($file['tmp_name']) . '_' . uniqid(), $ext);
    
    // S'assurer que le dossier existe
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0755, true);
    }

    $destinationPath = $destinationDir . '/' . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        throw new RuntimeException('Échec du déplacement du fichier téléchargé.');
    }

    return $newFileName;
}

/**
 * Gère l'upload d'un fichier (PDF, DOCX)
 */
function handleFileUpload($file, $destinationDir) {
    if (!isset($file['error']) || is_array($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    if ($file['size'] > 10000000) { // 10 MB
        throw new RuntimeException('Le fichier est trop volumineux (max 10MB).');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    $allowedMimeTypes = [
        'pdf' => 'application/pdf',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'doc' => 'application/msword'
    ];

    $ext = array_search($mimeType, $allowedMimeTypes, true);

    if ($ext === false) {
        throw new RuntimeException('Format de fichier non valide. Seuls les PDF et DOCX sont autorisés.');
    }

    $newFileName = sprintf('cv_%s.%s', uniqid(), $ext); // On garde un nom parlant pour le CV
    
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0755, true);
    }

    $destinationPath = $destinationDir . '/' . $newFileName;

    if (!move_uploaded_file($file['tmp_name'], $destinationPath)) {
        throw new RuntimeException('Échec du déplacement du fichier téléchargé.');
    }

    return $newFileName;
}
