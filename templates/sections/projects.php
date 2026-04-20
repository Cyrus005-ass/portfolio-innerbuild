<?php
?>
<div class="rounded-div-wrap rounded-light"><div class="rounded-div"></div></div>
<section id="projects" class="section projects-section">
    <div class="container">
        <h2 class="section-title">Projets<br>Recents</h2>

        <div class="projects-grid">
            <?php if (empty($projets)): ?>
                <p class="empty-text">Travaux en cours de finalisation.</p>
            <?php else: ?>
                <?php foreach ($projets as $p): ?>
                    <?php $imgSrc = resolveMediaPath($p['image'] ?? '', '../assets/img/cyr.png'); ?>
                    <article class="project-card">
                        <div class="project-image magnetic">
                            <div class="magnetic-inner"><img src="<?= e($imgSrc) ?>" alt="Apercu de <?= e($p['titre'] ?? 'Projet') ?>"></div>
                        </div>
                        <div class="project-details">
                            <h3><?= e($p['titre'] ?? 'Projet sans titre') ?></h3>
                            <p><?= e($p['description'] ?? '') ?></p>

                            <div class="project-stack">
                                <?php if (!empty($p['technologies'])): ?>
                                    <?php foreach (explode(',', $p['technologies']) as $stackItem): ?>
                                        <span><?= e(trim($stackItem)) ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="project-links">
                                <?php if (!empty($p['lien_live'])): ?>
                                    <div class="magnetic"><a href="<?= e($p['lien_live']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary magnetic-inner">Live Demo</a></div>
                                <?php endif; ?>
                                <?php if (!empty($p['lien_github'])): ?>
                                    <div class="magnetic"><a href="<?= e($p['lien_github']) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary magnetic-inner">Source Code</a></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

