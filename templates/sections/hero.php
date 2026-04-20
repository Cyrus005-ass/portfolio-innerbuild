<?php
$titre = $profil['titre'] ?? 'Developpeur Web Full-Stack';
$nom = $profil['nom'] ?? 'Cyrus-y ASSOGBA';
$prenom = $profil['prenom'] ?? '';
$fullName = trim($nom . ' ' . $prenom);
if ($fullName === '') {
    $fullName = 'Developpeur';
}

$location = !empty($profil['localisation']) ? $profil['localisation'] : 'Benin';
$basePath = rtrim((string) ($config['base_path'] ?? ''), '/');
$image = $basePath . '/assets/img/ass.png';
?>
<section id="hero" class="section home-header hero">
    <div class="hero-personal-image hero-image hero-bg-full">
        <img src="<?= e($image) ?>" alt="Photographie de <?= e($fullName) ?>">
    </div>

    <div class="hero-overlay-content hero-container">
        <div class="hero-role">
            <div class="arrow" aria-hidden="true">
                <svg width="24" height="24" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" fill-rule="evenodd">
                        <g transform="translate(-1019 -279)" stroke="#FFFFFF" stroke-width="1.5">
                            <g transform="translate(1026 286) rotate(90) translate(-1026 -286) translate(1020 280)">
                                <polyline points="2.76923077 0 12 0 12 9.23076923"></polyline>
                                <line x1="12" y1="0" x2="0" y2="12"></line>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <h4><span>Dev back-end</span><br><?= e($titre) ?></h4>
        </div>

        <div class="hero-location">
            <div class="location-text"><p>Located in <?= e($location) ?></p></div>
            <div class="globe" aria-hidden="true">
                <div class="globe-wrap">
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle"></div>
                    <div class="circle-hor"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="big-name hero-big-text-wrap">
        <div class="name-h1">
            <div class="name-wrap">
                <h1 class="no-select hero-big-text"><?= e($fullName) ?></h1>
            </div>
        </div>
    </div>
</section>
