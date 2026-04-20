<?php
?>
<div class="rounded-div-wrap rounded-dark"><div class="rounded-div"></div></div>
<section id="certifications" class="section certifications-section">
    <div class="container">
        <h2 class="section-title js-split-text">Certifications</h2>

        <div class="certifications-list">
            <?php if (empty($certifications)): ?>
                <p class="empty-text">Aucune certification pour le moment.</p>
            <?php else: ?>
                <div class="projects-grid cert-projects-grid">
                    <?php foreach ($certifications as $cert): ?>
                        <?php $certImg = resolveMediaPath($cert['photo'] ?? '', '../assets/img/cyr.png'); ?>
                        <article class="project-card cert-project-card magnetic">
                            <div class="project-image cert-project-image magnetic-inner">
                                <img
                                    src="<?= e($certImg) ?>"
                                    class="cert-image-zoom"
                                    alt="<?= e($cert['nom'] ?? 'Certification') ?>"
                                    data-title="<?= e($cert['nom'] ?? 'Certification') ?>"
                                    data-link="<?= e($cert['lien_verification'] ?? '') ?>"
                                >
                                <div class="cert-image-overlay"></div>
                            </div>

                            <div class="project-details cert-project-details">
                                <h3><?= e($cert['nom'] ?? 'Certification') ?></h3>
                                <p><?= e($cert['organisme'] ?? '') ?></p>
                                <div class="project-stack cert-meta">
                                    <?php if (!empty($cert['date_obtention'])): ?>
                                        <span><?= e(date('M Y', strtotime($cert['date_obtention']))) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="cert-actions">
                                    <button type="button" class="btn btn-secondary" onclick="openLightbox('<?= e($certImg) ?>', '<?= e($cert['nom'] ?? 'Certification') ?>', '<?= e($cert['lien_verification'] ?? '') ?>')">Agrandir</button>
                                    <?php if (!empty($cert['lien_verification'])): ?>
                                        <a href="<?= e($cert['lien_verification']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Verifier</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
