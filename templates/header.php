<?php
$publicTheme = 'midnight';
if (isset($pdo)) {
    try {
        $themeCheck = $pdo->query("SHOW COLUMNS FROM profil LIKE 'site_theme'");
        if ($themeCheck && $themeCheck->fetch()) {
            $themeRow = $pdo->query("SELECT site_theme FROM profil WHERE id = 1 LIMIT 1")->fetch();
            if (!empty($themeRow['site_theme'])) {
                $publicTheme = (string) $themeRow['site_theme'];
            }
        }
    } catch (Exception $e) {
        $publicTheme = 'midnight';
    }
}
$allowedPublicThemes = ['midnight', 'ocean', 'sunset', 'forest'];
if (!in_array($publicTheme, $allowedPublicThemes, true)) {
    $publicTheme = 'midnight';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Développeur web full-stack orienté backend, je conçois des applications web robustes, sécurisées et performantes. J’allie compétences techniques et sens du design pour créer des expériences digitales efficaces et soignées. Passionné par les défis, j’aime repousser mes limites à travers des projets complexes, tout en poursuivant un apprentissage continu, notamment dans le domaine de la cybersécurité.">
    <meta property="og:title" content="Cyrus-y ASSOGBA | Développeur Web Full-Stack & UI/UX Designer au Bénin" />
    <meta property="og:description"
        content="Développeur web full-stack (backend & UI/UX), je crée des applications et sites web modernes, performants et sur mesure. Passionné par les défis et les nouvelles technologies." />
    <meta property="og:image" content="../assets/img/cyr.png">
    <meta property="og:site_name" content="Cyrus-y ASSOGBA Portfolio">
    <meta property="og:type" content="website" />
    <title>Cyrus-y ASSOGBA | Développeur web full-stack</title>
    <meta property="og:locale" content="fr">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/cyr.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../assets/img/cyr.png">
    <link rel="apple-touch-icon" href="../assets/img/cyr.png">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-95W2Q21NZD"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-95W2Q21NZD');
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <!-- CSS (Locomotive Scroll + Custom CSS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.css">
    <link rel="stylesheet" href="<?= htmlspecialchars($config['app_url'] ?? '') ?>/../assets/css/style.css">
    <style>
        body[data-theme="midnight"] {
            --accent: #8eb8ff;
            --accent-2: #c5dcff;
            --bg-dark: #0b0f16;
        }

        body[data-theme="ocean"] {
            --accent: #5fd2ff;
            --accent-2: #b6f0ff;
            --bg-dark: #07131b;
        }

        body[data-theme="sunset"] {
            --accent: #ffad66;
            --accent-2: #ffd3ad;
            --bg-dark: #1a120d;
        }

        body[data-theme="forest"] {
            --accent: #72d89a;
            --accent-2: #c1f1d5;
            --bg-dark: #0d1711;
        }
    </style>
</head>

<body data-theme="<?= htmlspecialchars($publicTheme) ?>">

    <!-- Custom Cursor -->
    <div class="cursor"></div>

    
    <div class="loading-container">
        <div class="loading-screen">
            <div class="loading-words">
                <h2>Hello<div class="dot"></div></h2>
                <h2>Bonjour<div class="dot"></div></h2>
                <h2>Hola<div class="dot"></div></h2>
                <h2>Salut<div class="dot"></div></h2>
                <h2>Cyrus-y<div class="dot"></div></h2>
                <h2>ASSOGBA<div class="dot"></div></h2>
            </div>
        </div>
    </div>

    <!-- Loader/Spinner pourrait être ajouté ici -->

    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="#" class="logo-link">
                    <span class="logo-avatar" aria-hidden="true">
                        <img src="../assets/img/cyr.png" alt="">
                    </span>
                    <span>C-Y Ass</span>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#hero">Accueil</a></li>
                <li><a href="#about">À propos</a></li>
                <li><a href="#skills">Compétences</a></li>
                <li><a href="#projects">Projets</a></li>
                <li><a href="#certifications">Certifications</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <button class="menu-toggle" aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>

    <!-- Wrapper principal pour Locomotive Scroll -->
    <main data-scroll-container id="main-container">
