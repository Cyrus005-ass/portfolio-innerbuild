<?php
// templates/sections/about.php
// $profil est fourni par le contrôleur (index.php)

$bio = $profil['bio'] ?? "Passionné par la création d'expériences web immersives et performantes, je mets mon expertise technique au service de vos projets.";
$photo = '../assets/img/cyr.png';

if (!empty($profil['avatar'])) {
    if (str_starts_with($profil['avatar'], 'http')) {
        $photo = $profil['avatar'];
    } else {
        $avatarPath = __DIR__ . '/../../src/uploads/' . $profil['avatar'];
        if (file_exists($avatarPath)) {
            $photo = '../src/uploads/' . $profil['avatar'];
        }
    }
}
?>
<div class="rounded-div-wrap" data-scroll-section>
    <div class="rounded-div" style="background: var(--bg-dark);"></div>
</div>
<section id="about" class="section about-section" data-scroll-section>
    <div class="about-bg" style="background-image: url('<?= e($photo) ?>');"></div>
    <div class="about-overlay"></div>
    <div class="container about-container">
        <div class="about-grid">
            <div class="about-text-container">
                <p class="about-text js-split-text">
                    <?= nl2br(htmlspecialchars($bio)) ?>
                </p>
                <div class="about-actions">
                    <div class="magnetic">
                        <a href="#contact" class="btn btn-primary magnetic-inner about-primary-btn">Discutons de votre projet</a>
                    </div>
                    <?php if(!empty($profil['cv_url'])): ?>
                        <div class="magnetic">
                            <a href="<?= e($config['app_url'] ?? '') ?>/../src/uploads/<?= e($profil['cv_url']) ?>" download class="btn btn-secondary magnetic-inner about-secondary-btn">Télécharger mon CV &darr;</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
