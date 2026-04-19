<?php
// templates/sections/about.php
// $profil est fourni par le contrôleur (index.php)

$bio = $profil['bio'] ?? "Passionné par la création d'expériences web immersives et performantes, je mets mon expertise technique au service de vos projets.";
$photo = !empty($profil['avatar']) ? $profil['avatar'] : '../assets/img/cyr.png';
if (!empty($profil['avatar']) && !str_starts_with($profil['avatar'], 'http')) {
    $photo = '../src/uploads/' . e($profil['avatar']);
    if (!file_exists(__DIR__ . '/../../src/uploads/' . $profil['avatar'])) {
        $photo = '../assets/img/' . e($profil['avatar']);
    }
}
?>
<div class="rounded-div-wrap" data-scroll-section>
    <div class="rounded-div" style="background: var(--bg-dark);"></div>
</div>
<section id="about" class="section about-section" data-scroll-section style="background-color: var(--text-light); color: var(--bg-dark);">
    <div class="container" style="padding: 80px 5vw;">
        <div class="about-grid" style="display: flex; flex-direction: column; gap: 80px;">
            <div class="about-text-container" style="max-width: 1200px;">
                <p class="about-text js-split-text" style="font-size: clamp(2rem, 4vw, 3.5rem); line-height: 1.3; font-weight: 300; margin-bottom: 40px; color: var(--bg-dark);">
                    <?= nl2br(htmlspecialchars($bio)) ?>
                </p>
                <div style="display: flex; gap: 20px; align-items: center;">
                    <div class="magnetic">
                        <a href="#contact" class="btn btn-primary magnetic-inner" style="background: var(--bg-dark); color: var(--text-light);">Discutons de votre projet</a>
                    </div>
                    <?php if(!empty($profil['cv_url'])): ?>
                        <div class="magnetic">
                            <a href="<?= e($config['app_url'] ?? '') ?>/../src/uploads/<?= e($profil['cv_url']) ?>" download class="btn btn-secondary magnetic-inner" style="border: 1px solid var(--bg-dark); color: var(--bg-dark); background: transparent;">Télécharger mon CV &darr;</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
