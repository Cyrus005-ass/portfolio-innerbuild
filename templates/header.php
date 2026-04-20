<?php
$publicTheme = 'midnight';
$siteFont = 'outfit';
$titleScale = 1.0;
$textScale = 1.0;
$accentColor = '#8EB8FF';
$accentSoftColor = '#C5DCFF';
$bgColor = '#0B0F16';
$surfaceColor = '#131A25';
$basePath = rtrim((string) ($config['base_path'] ?? ''), '/');
$stylePath = dirname(__DIR__) . '/assets/css/style.css';
$styleVersion = is_file($stylePath) ? (string) filemtime($stylePath) : (string) time();

if (isset($profil) && is_array($profil)) {
    $publicTheme = !empty($profil['site_theme']) ? (string) $profil['site_theme'] : 'midnight';
    $siteFont = !empty($profil['site_font']) ? (string) $profil['site_font'] : 'outfit';
    $titleScale = isset($profil['title_scale']) ? (float) $profil['title_scale'] : 1.0;
    $textScale = isset($profil['text_scale']) ? (float) $profil['text_scale'] : 1.0;
    $accentColor = !empty($profil['accent_color']) ? (string) $profil['accent_color'] : '#8EB8FF';
    $accentSoftColor = !empty($profil['accent_soft_color']) ? (string) $profil['accent_soft_color'] : '#C5DCFF';
    $bgColor = !empty($profil['bg_color']) ? (string) $profil['bg_color'] : '#0B0F16';
    $surfaceColor = !empty($profil['surface_color']) ? (string) $profil['surface_color'] : '#131A25';
}

$allowedPublicThemes = ['midnight', 'ocean', 'sunset', 'forest'];
if (!in_array($publicTheme, $allowedPublicThemes, true)) {
    $publicTheme = 'midnight';
}

$fontMap = [
    'outfit' => 'Outfit:wght@300;400;500;600;700;800',
    'syne' => 'Syne:wght@400;500;600;700;800',
    'sora' => 'Sora:wght@300;400;500;600;700;800',
    'manrope' => 'Manrope:wght@300;400;500;600;700;800',
];

if (!isset($fontMap[$siteFont])) {
    $siteFont = 'outfit';
}

$titleScale = max(0.8, min(1.4, $titleScale));
$textScale = max(0.9, min(1.2, $textScale));

$colorRegex = '/^#[0-9A-Fa-f]{6}$/';
$accentColor = preg_match($colorRegex, $accentColor) ? strtoupper($accentColor) : '#8EB8FF';
$accentSoftColor = preg_match($colorRegex, $accentSoftColor) ? strtoupper($accentSoftColor) : '#C5DCFF';
$bgColor = preg_match($colorRegex, $bgColor) ? strtoupper($bgColor) : '#0B0F16';
$surfaceColor = preg_match($colorRegex, $surfaceColor) ? strtoupper($surfaceColor) : '#131A25';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Developpeur web full-stack oriente backend, je concois des applications web robustes, securisees et performantes.">
    <meta property="og:title" content="Portfolio - Developpeur Web Full-Stack" />
    <meta property="og:description" content="Applications et sites web modernes, performants et sur mesure." />
    <meta property="og:image" content="<?= htmlspecialchars($basePath . '/assets/img/cyr.png') ?>">
    <meta property="og:site_name" content="Portfolio">
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="fr">
    <title>Portfolio | Developpeur web full-stack</title>

    <link rel="icon" type="image/png" sizes="32x32" href="<?= htmlspecialchars($basePath . '/assets/img/cyr.png') ?>">
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($basePath . '/assets/img/cyr.png') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?= htmlspecialchars($fontMap[$siteFont]) ?>&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= htmlspecialchars($basePath . '/assets/css/style.css?v=' . $styleVersion) ?>">

    <style>
        body {
            --accent: <?= htmlspecialchars($accentColor) ?>;
            --accent-2: <?= htmlspecialchars($accentSoftColor) ?>;
            --bg-dark: <?= htmlspecialchars($bgColor) ?>;
            --bg-elev: <?= htmlspecialchars($surfaceColor) ?>;
            --title-scale: <?= htmlspecialchars((string) $titleScale) ?>;
            --text-scale: <?= htmlspecialchars((string) $textScale) ?>;
            --font-main: '<?= htmlspecialchars(ucfirst($siteFont)) ?>', sans-serif;
        }

        body[data-theme="midnight"] { --theme-tint: #1d2f4a; }
        body[data-theme="ocean"] { --theme-tint: #0f3440; }
        body[data-theme="sunset"] { --theme-tint: #3a2413; }
        body[data-theme="forest"] { --theme-tint: #1a3523; }
    </style>
</head>

<body data-theme="<?= htmlspecialchars($publicTheme) ?>">
    <div class="loading-container">
        <div class="loading-screen">
            <div class="loading-words">
                <h2>Hello<div class="dot"></div></h2>
                <h2>Bonjour<div class="dot"></div></h2>
                <h2>Hola<div class="dot"></div></h2>
                <h2>Salut<div class="dot"></div></h2>
            </div>
        </div>
    </div>

    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <a href="#hero" class="logo-link">
                    <span class="logo-avatar" aria-hidden="true"><img src="<?= htmlspecialchars($basePath . '/assets/img/cyr.png') ?>" alt=""></span>
                    <span>C-Y Ass</span>
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="#hero">Accueil</a></li>
                <li><a href="#about">A propos</a></li>
                <li><a href="#skills">Competences</a></li>
                <li><a href="#projects">Projets</a></li>
                <li><a href="#certifications">Certifications</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <button class="menu-toggle" aria-label="Ouvrir le menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>

    <main id="main-container">
