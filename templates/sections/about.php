<?php
$bio = $profil['bio'] ?? "Passionne par la creation d'experiences web immersives et performantes, je mets mon expertise technique au service de vos projets.";
$basePath = rtrim((string) ($config['base_path'] ?? ''), '/');
?>
<div class="rounded-div-wrap"><div class="rounded-div"></div></div>
<section id="about" class="section about-section">
    <div class="container about-container">
        <div class="about-grid">
            <div class="about-text-container">
                <p class="about-text js-split-text"><?= nl2br(e($bio)) ?></p>
                <div class="about-actions">
                    <div class="magnetic"><a href="#contact" class="btn btn-primary magnetic-inner about-primary-btn">Discutons de votre projet</a></div>
                    <?php if (!empty($profil['cv_url'])): ?>
                        <div class="magnetic"><a href="<?= e($basePath . '/src/uploads/' . $profil['cv_url']) ?>" download class="btn btn-secondary magnetic-inner about-secondary-btn">Telecharger mon CV</a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

