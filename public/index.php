<?php
/**
 * Portfolio Public - Point d'entrée
 * Style Dennis Snellenberg - Minimaliste Noir/Blanc
 */
$config = require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';
require_once __DIR__ . '/../src/includes/helpers.php';

$contactSuccess = false;
$contactError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && in_array($_POST['action'], ['contact', 'contact_form'], true)) {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $contactError = 'Token de sécurité invalide.';
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $sujet = trim($_POST['sujet'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        if (empty($nom) || empty($email) || empty($message)) {
            $contactError = 'Tous les champs obligatoires doivent être remplis.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $contactError = 'Adresse email invalide.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO messages (nom, email, sujet, contenu, date_envoi) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$nom, $email, $sujet, $message]);
                $contactSuccess = true;
            } catch (Exception $e) {
                $contactError = "Une erreur est survenue. Veuillez réessayer.";
            }
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM profil WHERE id = 1 LIMIT 1");
$stmt->execute();
$profil = $stmt->fetch() ?: [];

$stmt = $pdo->query("SELECT * FROM skills ORDER BY categorie, ordre ASC");
$allSkills = $stmt->fetchAll();
$skills = [];
foreach ($allSkills as $s) {
    $skills[$s['categorie']][] = $s;
}

$stmt = $pdo->query("SELECT * FROM projets ORDER BY ordre ASC, id DESC");
$projects = $stmt->fetchAll();
$projets = $projects;

$stmt = $pdo->query("SELECT * FROM certifications ORDER BY ordre ASC, date_obtention DESC");
$certifications = $stmt->fetchAll();

$groupedSkills = $skills;
$csrf = generateCsrfToken();

require_once __DIR__ . '/../templates/header.php';
require_once __DIR__ . '/../templates/sections/hero.php';
require_once __DIR__ . '/../templates/sections/about.php';
require_once __DIR__ . '/../templates/sections/skills.php';
require_once __DIR__ . '/../templates/sections/projects.php';
require_once __DIR__ . '/../templates/sections/certifications.php';
require_once __DIR__ . '/../templates/sections/contact.php';
require_once __DIR__ . '/../templates/footer.php';
