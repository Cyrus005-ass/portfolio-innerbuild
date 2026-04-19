<?php
$profil = is_array($profil ?? null) ? $profil : [];
$skills = is_array($skills ?? null) ? $skills : [];
$projects = is_array($projects ?? null) ? $projects : [];
$certifications = is_array($certifications ?? null) ? $certifications : [];

$e = static fn($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

$metaDescription = trim(strip_tags((string) ($profil['bio'] ?? '')));
if ($metaDescription === '') {
    $metaDescription = 'Portfolio professionnel, design, developpement front-end et experiences web interactives.';
}
$metaDescription = substr($metaDescription, 0, 160);

$displayName = trim((string) ($profil['nom'] ?? 'Portfolio'));
$displayTitle = trim((string) ($profil['titre'] ?? 'Creative Developer'));
$displayBio = trim((string) ($profil['bio'] ?? 'Je conçois des experiences web premium avec une attention particuliere aux details, aux performances et aux interactions.'));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <title><?= $e($displayName) ?> - <?= $e($displayTitle) ?></title>
    <meta name="description" content="<?= $e($metaDescription) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700;800&family=Syne:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0d1117;
            --bg-soft: #121824;
            --bg-card: #141d2e;
            --text: #eaf1ff;
            --muted: #9fb0c8;
            --line: rgba(255, 255, 255, 0.15);
            --accent: #d8ff5c;
            --accent-dark: #121700;
            --ok: #1db97b;
            --error: #cf3f56;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: "Manrope", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(1200px 700px at 80% -5%, #1d2b42 0, var(--bg) 50%), var(--bg);
            color: var(--text);
            line-height: 1.55;
            overflow-x: hidden;
        }

        body.no-scroll {
            overflow: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1180px, 100% - 2.5rem);
            margin: 0 auto;
        }

        .section {
            padding: clamp(4rem, 8vw, 8.5rem) 0;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .kicker {
            text-transform: uppercase;
            letter-spacing: 0.12em;
            font-size: 0.76rem;
            color: var(--muted);
            margin-bottom: 1rem;
        }

        h1, h2, h3, h4 {
            font-family: "Syne", "Manrope", sans-serif;
            letter-spacing: -0.02em;
            line-height: 1.05;
        }

        p {
            color: var(--muted);
        }

        .loader {
            position: fixed;
            inset: 0;
            z-index: 1200;
            background: #090d14;
            display: grid;
            place-content: center;
            overflow: hidden;
            transition: transform 1s cubic-bezier(.22,1,.36,1), border-radius 1s cubic-bezier(.22,1,.36,1), opacity .8s ease;
        }

        .loader.hide {
            transform: translateY(-100%);
            border-bottom-left-radius: 50vw;
            border-bottom-right-radius: 50vw;
            opacity: 0;
            pointer-events: none;
        }

        .loader-word {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, calc(-50% + 18px));
            font-family: "Syne", sans-serif;
            font-size: clamp(1.6rem, 5vw, 3.5rem);
            opacity: 0;
            transition: opacity .24s ease, transform .24s ease;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
        }

        .loader-word::after {
            content: "";
            width: .44em;
            height: .44em;
            border-radius: 50%;
            background: #fff;
            flex-shrink: 0;
        }

        .loader-word.active {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        .topbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: linear-gradient(to bottom, rgba(7, 10, 16, .9), rgba(7, 10, 16, .2), transparent);
            backdrop-filter: blur(8px);
        }

        .topbar-inner {
            height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand small {
            color: var(--muted);
            font-weight: 500;
        }

        .menu-btn {
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, 0.03);
            color: var(--text);
            border-radius: 999px;
            padding: .62rem 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform .22s ease, background .22s ease;
        }

        .menu-btn:hover {
            transform: translateY(-1px);
            background: rgba(255, 255, 255, 0.08);
        }

        .overlay-nav {
            position: fixed;
            inset: 0;
            z-index: 1100;
            display: grid;
            place-content: center;
            gap: 1rem;
            background: rgba(8, 11, 17, 0.98);
            transform: translateY(-100%);
            transition: transform .6s cubic-bezier(.22,1,.36,1);
        }

        .overlay-nav.open {
            transform: translateY(0);
        }

        .overlay-nav a {
            font-family: "Syne", sans-serif;
            font-size: clamp(2rem, 6vw, 4.1rem);
            letter-spacing: -0.02em;
            text-align: center;
        }

        .overlay-nav a:hover {
            color: var(--accent);
        }

        .hero {
            min-height: 100vh;
            display: grid;
            align-items: center;
            padding-top: 84px;
            border-top: 0;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.15fr .85fr;
            gap: 3rem;
            align-items: center;
        }

        .hero h1 {
            font-size: clamp(2.4rem, 7vw, 6.8rem);
            margin-bottom: 1.1rem;
        }

        .hero .role {
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 1.15rem;
            font-size: clamp(1rem, 2.2vw, 1.35rem);
        }

        .hero p {
            max-width: 60ch;
            margin-bottom: 1.8rem;
        }

        .hero-ctas {
            display: flex;
            flex-wrap: wrap;
            gap: .8rem;
        }

        .btn {
            border-radius: 999px;
            padding: .82rem 1.3rem;
            font-weight: 700;
            border: 1px solid transparent;
            transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--accent);
            color: #111;
            box-shadow: 0 6px 24px rgba(216, 255, 92, .26);
        }

        .btn-ghost {
            border-color: var(--line);
            color: var(--text);
            background: rgba(255, 255, 255, 0.02);
        }

        .hero-visual {
            position: relative;
            aspect-ratio: 4 / 5;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .01));
        }

        .hero-visual img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            filter: brightness(.83);
            transform: scale(1.03);
            transition: transform 1.2s ease;
        }

        .hero-visual:hover img {
            transform: scale(1.08);
        }

        .hero-visual .fallback {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            font-size: 1.1rem;
            color: var(--muted);
        }

        .line-globe-wrap {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .line-globe {
            width: 86px;
            height: 86px;
            border-radius: 50%;
            border: 1px solid var(--line);
            position: relative;
            animation: globeSpin 10s linear infinite;
            flex-shrink: 0;
        }

        .line-globe::before,
        .line-globe::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1px solid var(--line);
        }

        .line-globe::before {
            transform: scaleX(.62);
        }

        .line-globe::after {
            transform: scaleY(.62);
        }

        .split-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2.4rem;
            align-items: start;
        }

        .panel {
            background: linear-gradient(180deg, rgba(255, 255, 255, .05), rgba(255, 255, 255, .02));
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 1.2rem;
        }

        .avatar {
            width: 100%;
            max-width: 300px;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, .1);
            margin-bottom: 1.2rem;
            display: block;
        }

        .contact-list {
            display: grid;
            gap: .6rem;
            font-size: .96rem;
        }

        .contact-list a:hover {
            color: var(--accent);
        }

        .services-grid,
        .projects-grid,
        .cert-grid {
            display: grid;
            gap: 1rem;
        }

        .services-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            margin-top: 1.4rem;
        }

        .service {
            background: linear-gradient(180deg, rgba(255, 255, 255, .04), rgba(255, 255, 255, .01));
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 14px;
            padding: 1.25rem;
        }

        .service .index {
            color: var(--accent);
            font-size: .86rem;
            font-weight: 700;
            margin-bottom: .7rem;
        }

        .service h3 {
            font-size: 1.24rem;
            margin-bottom: .6rem;
        }

        .skills-layout {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.2rem;
            margin-top: 1.2rem;
        }

        .skill-card {
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 14px;
            background: rgba(255, 255, 255, .02);
            padding: 1rem;
        }

        .skill-card h3 {
            margin-bottom: .8rem;
            font-size: 1.16rem;
        }

        .skill-item {
            margin-bottom: .85rem;
        }

        .skill-head {
            display: flex;
            justify-content: space-between;
            font-size: .95rem;
            margin-bottom: .3rem;
            gap: .5rem;
        }

        .skill-bar {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, .08);
            border-radius: 999px;
            overflow: hidden;
        }

        .skill-fill {
            width: 0;
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, #90b4ff, #d8ff5c);
            transition: width 1.1s cubic-bezier(.2,.8,.2,1);
        }

        .projects-grid {
            grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
            margin-top: 1.2rem;
        }

        .project {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .1);
            background: var(--bg-card);
            transition: transform .24s ease;
        }

        .project:hover {
            transform: translateY(-4px);
        }

        .project img {
            width: 100%;
            height: 210px;
            object-fit: cover;
            display: block;
        }

        .project-body {
            padding: 1rem;
        }

        .project-body h3 {
            font-size: 1.14rem;
            margin-bottom: .55rem;
        }

        .project-body p {
            font-size: .94rem;
            margin-bottom: .8rem;
        }

        .tech-list {
            display: flex;
            flex-wrap: wrap;
            gap: .45rem;
            margin-bottom: .85rem;
        }

        .tech-list span {
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 999px;
            padding: .25rem .6rem;
            font-size: .78rem;
            color: #bfd1ea;
        }

        .project-links {
            display: flex;
            gap: .8rem;
            font-weight: 700;
            font-size: .9rem;
        }

        .project-links a:hover {
            color: var(--accent);
        }

        .cert-grid {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            margin-top: 1rem;
        }

        .cert {
            display: flex;
            gap: .85rem;
            align-items: center;
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 14px;
            background: rgba(255, 255, 255, .02);
            padding: .9rem;
        }

        .cert img {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .cert h4 {
            font-size: 1rem;
            margin-bottom: .2rem;
        }

        .cert .org,
        .cert .date {
            font-size: .86rem;
            color: var(--muted);
        }

        .contact-wrap {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.2rem;
        }

        .alert {
            border-radius: 10px;
            padding: .75rem .9rem;
            margin-bottom: .75rem;
            font-size: .9rem;
            font-weight: 600;
            color: #fff;
        }

        .alert.success {
            background: var(--ok);
        }

        .alert.error {
            background: var(--error);
        }

        .contact-form {
            display: grid;
            gap: .75rem;
        }

        .contact-form label {
            font-size: .9rem;
            color: #c7d8f2;
            display: block;
            margin-bottom: .24rem;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 10px;
            background: #0e141f;
            color: var(--text);
            padding: .7rem .78rem;
            font: inherit;
            outline: none;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #9cc0ff;
            box-shadow: 0 0 0 3px rgba(156, 192, 255, .14);
        }

        .contact-form textarea {
            min-height: 140px;
            resize: vertical;
        }

        .footer {
            padding: 2rem 0 3rem;
            border-top: 1px solid rgba(255, 255, 255, .07);
        }

        .footer-grid {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            color: var(--muted);
            font-size: .9rem;
        }

        .socials {
            display: flex;
            gap: .8rem;
        }

        .socials a:hover {
            color: var(--accent);
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity .65s ease, transform .65s ease;
        }

        .reveal.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .empty-state {
            padding: 1rem;
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, .2);
            color: var(--muted);
            font-size: .95rem;
        }

        @keyframes globeSpin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 980px) {
            .hero-grid,
            .split-grid,
            .contact-wrap {
                grid-template-columns: 1fr;
            }

            .hero-visual {
                max-width: 520px;
            }
        }

        @media (max-width: 640px) {
            .container {
                width: min(1180px, 100% - 1.4rem);
            }

            .topbar-inner {
                height: 68px;
            }

            .overlay-nav a {
                font-size: clamp(2rem, 10vw, 3.1rem);
            }
        }
    </style>
</head>
<body class="no-scroll">
    <div class="loader" id="loader" aria-hidden="true">
        <span class="loader-word active">Hello</span>
        <span class="loader-word">Bonjour</span>
        <span class="loader-word">Ciao</span>
        <span class="loader-word">Ola</span>
        <span class="loader-word">Hallo</span>
    </div>

    <header class="topbar">
        <div class="container topbar-inner">
            <a href="#hero" class="brand">&copy; <?= $e($displayName) ?> <small>/ Portfolio</small></a>
            <button id="menuBtn" class="menu-btn" type="button" aria-expanded="false" aria-controls="overlayNav">Menu</button>
        </div>
    </header>

    <nav class="overlay-nav" id="overlayNav" aria-hidden="true">
        <a href="#hero">Accueil</a>
        <a href="#about">A propos</a>
        <a href="#skills">Competences</a>
        <a href="#projects">Projets</a>
        <a href="#contact">Contact</a>
    </nav>

    <main>
        <section id="hero" class="section hero">
            <div class="container hero-grid reveal">
                <div>
                    <p class="kicker">Digital Design & Front-End Development</p>
                    <h1><?= $e($displayName) ?></h1>
                    <p class="role"><?= $e($displayTitle) ?></p>
                    <p><?= nl2br($e($displayBio)) ?></p>
                    <div class="hero-ctas">
                        <a class="btn btn-primary" href="#contact">Me contacter</a>
                        <a class="btn btn-ghost" href="#projects">Voir mes projets</a>
                    </div>
                </div>
                <div class="hero-visual">
                    <?php if (!empty($profil['avatar'])): ?>
                        <img src="/src/uploads/<?= $e($profil['avatar']) ?>" alt="Portrait de <?= $e($displayName) ?>">
                    <?php else: ?>
                        <div class="fallback">Image de profil</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container line-globe-wrap reveal">
                <div class="line-globe" aria-hidden="true"></div>
                <p>J'accompagne des clients sur des projets web sur mesure en combinant direction artistique, code propre et interactions fluides.</p>
            </div>
        </section>

        <section id="about" class="section">
            <div class="container split-grid reveal">
                <div class="panel">
                    <?php if (!empty($profil['avatar'])): ?>
                        <img src="/src/uploads/<?= $e($profil['avatar']) ?>" alt="Photo de <?= $e($displayName) ?>" class="avatar">
                    <?php endif; ?>
                    <div class="contact-list">
                        <?php if (!empty($profil['localisation'])): ?><span><?= $e($profil['localisation']) ?></span><?php endif; ?>
                        <?php if (!empty($profil['email_contact'])): ?><a href="mailto:<?= $e($profil['email_contact']) ?>"><?= $e($profil['email_contact']) ?></a><?php endif; ?>
                        <?php if (!empty($profil['telephone'])): ?><a href="tel:<?= $e(preg_replace('/\s+/', '', (string) $profil['telephone'])) ?>"><?= $e($profil['telephone']) ?></a><?php endif; ?>
                    </div>
                </div>
                <div>
                    <p class="kicker">A propos</p>
                    <h2 style="font-size:clamp(2rem,4.5vw,3.4rem); margin-bottom:1rem;">Helping brands thrive in the digital world</h2>
                    <p><?= nl2br($e($displayBio)) ?></p>
                    <div class="services-grid">
                        <article class="service">
                            <div class="index">01</div>
                            <h3>Design</h3>
                            <p>Interfaces claires, fortes en hierarchie visuelle et adaptees a vos objectifs de marque.</p>
                        </article>
                        <article class="service">
                            <div class="index">02</div>
                            <h3>Development</h3>
                            <p>Implementation front-end robuste, animations soignées et performances maintenues.</p>
                        </article>
                        <article class="service">
                            <div class="index">03</div>
                            <h3>Full Package</h3>
                            <p>Prise en charge complete du concept a la mise en ligne pour un rendu coherent et premium.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="skills" class="section">
            <div class="container reveal">
                <p class="kicker">Competences</p>
                <h2 style="font-size:clamp(2rem,4.5vw,3.2rem);">I can help you with...</h2>
                <?php if (!empty($skills)): ?>
                    <div class="skills-layout">
                        <?php foreach ($skills as $category => $items): ?>
                            <article class="skill-card">
                                <h3><?= $e($category) ?></h3>
                                <?php foreach ($items as $skill): ?>
                                    <?php $level = max(0, min(100, (int) ($skill['niveau'] ?? 0))); ?>
                                    <div class="skill-item">
                                        <div class="skill-head">
                                            <span><?= $e($skill['nom'] ?? '') ?></span>
                                            <span><?= $level ?>%</span>
                                        </div>
                                        <div class="skill-bar"><div class="skill-fill" data-level="<?= $level ?>"></div></div>
                                    </div>
                                <?php endforeach; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">Aucune competence publiee pour le moment.</div>
                <?php endif; ?>
            </div>
        </section>

        <section id="projects" class="section">
            <div class="container reveal">
                <p class="kicker">Projets</p>
                <h2 style="font-size:clamp(2rem,4.5vw,3.2rem);">Selected work</h2>
                <?php if (!empty($projects)): ?>
                    <div class="projects-grid">
                        <?php foreach ($projects as $project): ?>
                            <article class="project">
                                <?php if (!empty($project['image'])): ?>
                                    <img src="/src/uploads/<?= $e($project['image']) ?>" alt="Projet <?= $e($project['titre'] ?? '') ?>">
                                <?php endif; ?>
                                <div class="project-body">
                                    <h3><?= $e($project['titre'] ?? '') ?></h3>
                                    <p><?= $e($project['description'] ?? '') ?></p>
                                    <?php if (!empty($project['technologies'])): ?>
                                        <div class="tech-list">
                                            <?php foreach (explode(',', (string) $project['technologies']) as $tech): ?>
                                                <?php $tech = trim($tech); if ($tech === '') { continue; } ?>
                                                <span><?= $e($tech) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="project-links">
                                        <?php if (!empty($project['lien_live'])): ?><a href="<?= $e($project['lien_live']) ?>" target="_blank" rel="noopener noreferrer">Live</a><?php endif; ?>
                                        <?php if (!empty($project['lien_github'])): ?><a href="<?= $e($project['lien_github']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a><?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">Aucun projet disponible pour le moment.</div>
                <?php endif; ?>
            </div>
        </section>

        <section class="section">
            <div class="container reveal">
                <p class="kicker">Certifications</p>
                <h2 style="font-size:clamp(1.8rem,4vw,3rem);">Parcours & reconnaissance</h2>
                <?php if (!empty($certifications)): ?>
                    <div class="cert-grid">
                        <?php foreach ($certifications as $certification): ?>
                            <article class="cert">
                                <?php if (!empty($certification['photo'])): ?>
                                    <img src="/src/uploads/<?= $e($certification['photo']) ?>" alt="Certification <?= $e($certification['nom'] ?? '') ?>">
                                <?php endif; ?>
                                <div>
                                    <h4><?= $e($certification['nom'] ?? '') ?></h4>
                                    <p class="org"><?= $e($certification['organisme'] ?? '') ?></p>
                                    <p class="date"><?= $e($certification['date_obtention'] ?? '') ?></p>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">Aucune certification publiee pour le moment.</div>
                <?php endif; ?>
            </div>
        </section>

        <section id="contact" class="section">
            <div class="container reveal">
                <p class="kicker">Contact</p>
                <h2 style="font-size:clamp(2rem,4.5vw,3.3rem);">Let's work together</h2>
                <div class="contact-wrap">
                    <div class="panel">
                        <p>Parlons de ton prochain projet. Je peux intervenir sur la conception, l'integration et l'optimisation de ton site.</p>
                        <div class="contact-list" style="margin-top:1rem;">
                            <?php if (!empty($profil['email_contact'])): ?><a href="mailto:<?= $e($profil['email_contact']) ?>"><?= $e($profil['email_contact']) ?></a><?php endif; ?>
                            <?php if (!empty($profil['github'])): ?><a href="<?= $e($profil['github']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a><?php endif; ?>
                            <?php if (!empty($profil['linkedin'])): ?><a href="<?= $e($profil['linkedin']) ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a><?php endif; ?>
                            <?php if (!empty($profil['instagram'])): ?><a href="<?= $e($profil['instagram']) ?>" target="_blank" rel="noopener noreferrer">Instagram</a><?php endif; ?>
                        </div>
                    </div>
                    <div class="panel">
                        <?php if (!empty($contactSuccess)): ?>
                            <div class="alert success">Message envoye avec succes.</div>
                        <?php endif; ?>
                        <?php if (!empty($contactError)): ?>
                            <div class="alert error"><?= $e($contactError) ?></div>
                        <?php endif; ?>
                        <form method="POST" class="contact-form">
                            <input type="hidden" name="csrf_token" value="<?= $e($csrf ?? '') ?>">
                            <input type="hidden" name="action" value="contact">
                            <div>
                                <label for="nom">Nom *</label>
                                <input id="nom" name="nom" type="text" required>
                            </div>
                            <div>
                                <label for="email">Email *</label>
                                <input id="email" name="email" type="email" required>
                            </div>
                            <div>
                                <label for="sujet">Sujet</label>
                                <input id="sujet" name="sujet" type="text">
                            </div>
                            <div>
                                <label for="message">Message *</label>
                                <textarea id="message" name="message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <p>&copy; <?= date('Y') ?> <?= $e($displayName) ?>. Tous droits reserves.</p>
            <div class="socials">
                <?php if (!empty($profil['github'])): ?><a href="<?= $e($profil['github']) ?>" target="_blank" rel="noopener noreferrer">GitHub</a><?php endif; ?>
                <?php if (!empty($profil['linkedin'])): ?><a href="<?= $e($profil['linkedin']) ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a><?php endif; ?>
                <?php if (!empty($profil['instagram'])): ?><a href="<?= $e($profil['instagram']) ?>" target="_blank" rel="noopener noreferrer">Instagram</a><?php endif; ?>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            const body = document.body;
            const loader = document.getElementById('loader');
            const loaderWords = loader ? loader.querySelectorAll('.loader-word') : [];
            let idx = 0;

            function runLoader() {
                if (!loader || loaderWords.length === 0) {
                    body.classList.remove('no-scroll');
                    return;
                }

                const timer = setInterval(() => {
                    loaderWords[idx].classList.remove('active');
                    idx += 1;
                    if (idx >= loaderWords.length) {
                        clearInterval(timer);
                        loader.classList.add('hide');
                        setTimeout(() => {
                            body.classList.remove('no-scroll');
                            loader.remove();
                        }, 980);
                        return;
                    }
                    loaderWords[idx].classList.add('active');
                }, 230);
            }

            window.addEventListener('load', runLoader);

            const menuBtn = document.getElementById('menuBtn');
            const nav = document.getElementById('overlayNav');
            const navLinks = nav ? nav.querySelectorAll('a') : [];

            function closeMenu() {
                if (!nav || !menuBtn) return;
                nav.classList.remove('open');
                nav.setAttribute('aria-hidden', 'true');
                menuBtn.setAttribute('aria-expanded', 'false');
                menuBtn.textContent = 'Menu';
                if (!body.classList.contains('no-scroll')) {
                    body.style.overflow = '';
                }
            }

            if (menuBtn && nav) {
                menuBtn.addEventListener('click', () => {
                    const open = nav.classList.toggle('open');
                    nav.setAttribute('aria-hidden', open ? 'false' : 'true');
                    menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
                    menuBtn.textContent = open ? 'Close' : 'Menu';
                    if (open) {
                        body.style.overflow = 'hidden';
                    } else if (!body.classList.contains('no-scroll')) {
                        body.style.overflow = '';
                    }
                });
            }

            navLinks.forEach((link) => {
                link.addEventListener('click', closeMenu);
            });

            const reveals = document.querySelectorAll('.reveal');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                });
            }, { threshold: 0.18 });

            reveals.forEach((item) => observer.observe(item));

            const skillBars = document.querySelectorAll('.skill-fill');
            const barsObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const target = entry.target;
                    const level = Number(target.getAttribute('data-level') || 0);
                    target.style.width = Math.max(0, Math.min(100, level)) + '%';
                    barsObserver.unobserve(target);
                });
            }, { threshold: 0.3 });

            skillBars.forEach((bar) => barsObserver.observe(bar));
        })();
    </script>
</body>
</html>
