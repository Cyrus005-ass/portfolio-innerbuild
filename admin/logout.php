<?php
require_once __DIR__ . '/../src/includes/security.php';

// Détruire les variables de session
session_unset();

// Détruire la session
session_destroy();

// Supprimer le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Rediriger vers le site principal
header("Location: ../public/index.php");
exit();
