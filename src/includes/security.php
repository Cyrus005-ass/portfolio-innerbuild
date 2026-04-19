<?php
/**
 * Fichier de sécurité (Protection CSRF, Sessions)
 */

// Démarrer la session de manière sécurisée si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    // Configurations de session sécurisées pour la production
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Passer à 1 si en HTTPS
    session_start();
}

/**
 * Génère un token CSRF et le stocke en session
 */
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Vérifie si le token CSRF soumis correspond à celui en session
 */
function verifyCsrfToken($token) {
    if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token)) {
        return true;
    }
    return false;
}

/**
 * Sécurise les entrées utilisateur contre les attaques XSS
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
