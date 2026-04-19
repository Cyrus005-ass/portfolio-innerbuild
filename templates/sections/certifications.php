<?php
// templates/sections/certifications.php
// $certifications est fourni par le contrôleur (index.php)
?>
<div class="rounded-div-wrap" data-scroll-section style="background: var(--bg-dark); height: 5vh; transform: translateY(1px);">
    <div class="rounded-div" style="background: var(--bg-dark);"></div>
</div>
<section id="certifications" class="section certifications-section" data-scroll-section style="background-color: var(--text-light); color: var(--bg-dark); padding: 80px 0;">
    <div class="container" style="padding: 0 5vw;">
        <h2 class="section-title js-split-text" data-scroll data-scroll-speed="1" style="font-size: clamp(3rem, 8vw, 6rem); margin-bottom: 80px; text-align: left; font-weight: 300;">Certifications</h2>
        
        <div class="certifications-list">
            <?php if (empty($certifications)): ?>
                <p style="text-align:left; color:#999; font-size:1.5rem;">Aucune certification pour le moment.</p>
            <?php else: ?>
                <div class="projects-grid cert-projects-grid">
                <?php foreach ($certifications as $cert): ?>
                    <?php
                    $certImg = '';
                    if (!empty($cert['photo'])) {
                        if (file_exists(__DIR__ . '/../../src/uploads/' . $cert['photo'])) {
                            $certImg = '../src/uploads/' . htmlspecialchars($cert['photo']);
                        } elseif (file_exists(__DIR__ . '/../../assets/img/' . $cert['photo'])) {
                            $certImg = '../assets/img/' . htmlspecialchars($cert['photo']);
                        } else {
                            $certImg = htmlspecialchars($cert['photo']);
                        }
                    }
                    ?>
                    <article class="project-card cert-project-card magnetic" data-scroll data-scroll-speed="0.45">
                        <div class="project-image cert-project-image magnetic-inner">
                            <?php if ($certImg): ?>
                                <img
                                    src="<?= $certImg ?>"
                                    class="cert-image-zoom"
                                    onclick="openLightbox('<?= $certImg ?>', '<?= e($cert['nom'] ?? 'Certification') ?>', '<?= e($cert['lien_verification'] ?? '') ?>')"
                                    alt="<?= e($cert['nom'] ?? 'Certification') ?>"
                                >
                            <?php else: ?>
                                <div class="cert-fallback">CERT</div>
                            <?php endif; ?>
                            <div class="cert-image-overlay"></div>
                        </div>

                        <div class="project-details cert-project-details">
                            <h3><?= htmlspecialchars($cert['nom'] ?? 'Certification') ?></h3>
                            <p><?= htmlspecialchars($cert['organisme'] ?? '') ?></p>
                            <div class="project-stack cert-meta">
                                <?php if (!empty($cert['date_obtention'])): ?>
                                    <span><?= date('M Y', strtotime($cert['date_obtention'])) ?></span>
                                <?php endif; ?>
                            </div>

                            <div class="cert-actions">
                                <button type="button" class="btn btn-secondary" onclick="openLightbox('<?= $certImg ?>', '<?= e($cert['nom'] ?? 'Certification') ?>', '<?= e($cert['lien_verification'] ?? '') ?>')">Agrandir</button>
                                <?php if (!empty($cert['lien_verification'])): ?>
                                    <a href="<?= e($cert['lien_verification']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary">Vérifier &nearr;</a>
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
