<?php
// templates/sections/hero.php
// $profil est fourni par le contrôleur (index.php)

$titre = $profil['titre'] ?? 'Développeur Web Full-Stack';
$nom = $profil['nom'] ?? 'Cyrus-y ASSOGBA';
$prenom = $profil['prenom'] ?? '';
$fullName = trim($nom . ' ' . $prenom);
if (empty($fullName)) $fullName = 'Développeur';

// Photo hero en background plein écran
$image = '../assets/img/ass.png';
?>
<section id="hero" class="section home-header hero" data-scroll-section>
    <div class="hero-personal-image hero-image hero-bg-full" data-scroll data-scroll-speed="-1" data-scroll-position="top">
        <img src="<?= $image ?>" alt="Photographie de <?= htmlspecialchars($fullName) ?>">
    </div>

    <div class="hero-overlay-content hero-container">
        <div class="hero-role" data-scroll data-scroll-speed="1">
            <div class="arrow">
                <svg width="24px" height="24px" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g transform="translate(-1019.000000, -279.000000)" stroke="#FFFFFF" stroke-width="1.5">
                            <g transform="translate(1026.000000, 286.000000) rotate(90.000000) translate(-1026.000000, -286.000000) translate(1020.000000, 280.000000)">
                                <polyline points="2.76923077 0 12 0 12 9.23076923"></polyline>
                                <line x1="12" y1="0" x2="0" y2="12"></line>
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <h4><span>Dev back-end</span><br><?= htmlspecialchars($titre) ?></h4>
        </div>

        <div class="hero-location" data-scroll data-scroll-speed="1.2">
            <div class="location-text">
                <p>Located in Benin</p>
            </div>
            <div class="globe">
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
                <h1 class="no-select hero-big-text"><?= htmlspecialchars($fullName) ?></h1>
            </div>
        </div>
    </div>
</section>
