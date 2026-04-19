<?php
/**
 * Fichier vérifiant l'authentification
 * À inclure en tête de tous les fichiers du dossier admin/ (sauf login.php)
 */

require_once __DIR__ . '/../../src/includes/security.php';

// Si l'utilisateur n'est pas connecté ou s'il n'est pas admin, on le redirige vers le login
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_role'])) {
    header("Location: login.php");
    exit();
}

// Timeout d'inactivité (ex: 30 minutes)
$timeout_duration = 1800;
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();     // Vider la session
    session_destroy();   // Détruire la session
    header("Location: login.php?msg=timeout");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time(); // Met à jour l'heure de dernière activité
