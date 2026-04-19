<?php
// templates/sections/projects.php
// $projects est fourni par le contrôleur (index.php)
?>
<div class="rounded-div-wrap" data-scroll-section style="background: var(--text-light); height: 5vh;">
    <div class="rounded-div" style="background: var(--text-light);"></div>
</div>
<section id="projects" class="section projects-section" data-scroll-section style="background-color: var(--bg-dark);">
    <div class="container" style="padding: 80px 5vw;">
        <h2 class="section-title js-split-text" data-scroll data-scroll-speed="1" style="font-size: clamp(3rem, 8vw, 6rem); margin-bottom: 80px; text-align: left; font-weight: 300;">Projets<br>Récents</h2>
        
        <div class="projects-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 80px;">
            <?php if (empty($projets)): ?>
                <p style="text-align:left; color:#999; font-size: 1.5rem;">Travaux en cours de finalisation.</p>
            <?php else: ?>
                <?php foreach ($projets as $p): ?>
                <article class="project-card" data-scroll data-scroll-speed="0.5" style="background: transparent; border-radius: 0;">
                    <div class="project-image magnetic" style="border-radius: 10px; width: 100%; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 2px solid rgba(255,255,255,0.1);">
                        <div class="magnetic-inner" style="width: 100%;">
                            <?php 
                            $imgSrc = '../assets/img/cyr.png';
                            if (!empty($p['image'])) {
                                if (file_exists(__DIR__ . '/../../src/uploads/' . $p['image'])) {
                                    $imgSrc = '../src/uploads/' . e($p['image']);
                                } else if (file_exists(__DIR__ . '/../../assets/img/' . $p['image'])) {
                                    $imgSrc = '../assets/img/' . e($p['image']);
                                } else {
                                    $imgSrc = e($p['image']);
                                }
                            }
                            ?>
                            <img src="<?= $imgSrc ?>" alt="Aperçu de <?= e($p['titre'] ?? 'Projet') ?>" style="border-radius: 10px;">
                        </div>
                    </div>
                    <div class="project-details" style="padding: 30px 0;">
                        <h3 style="font-size: 2rem; font-weight: 400; margin-bottom: 10px;"><?= e($p['titre'] ?? 'Projet sans titre') ?></h3>
                        <p style="font-size: 1.1rem; color: #888;"><?= e($p['description'] ?? '') ?></p>
                        
                        <div class="project-stack" style="margin-top: 20px;">
                            <?php 
                            if (!empty($p['technologies'])) {
                                $stackItems = explode(',', $p['technologies']); 
                                foreach($stackItems as $stackItem): 
                            ?>
                                <span style="background: transparent; border: 1px solid rgba(255,255,255,0.2); font-size: 0.9rem; margin-right: 10px; padding: 5px 15px; border-radius: 20px;"><?= e(trim($stackItem)) ?></span>
                            <?php 
                                endforeach; 
                            }
                            ?>
                        </div>
                        <div style="display:flex;gap:10px; margin-top: 20px;">
                            <?php if(!empty($p['lien_live'])): ?>
                                <div class="magnetic"><a href="<?= e($p['lien_live']) ?>" target="_blank" class="btn btn-secondary magnetic-inner">Live Demo</a></div>
                            <?php endif; ?>
                            <?php if(!empty($p['lien_github'])): ?>
                                <div class="magnetic"><a href="<?= htmlspecialchars($p['lien_github']) ?>" target="_blank" class="btn btn-secondary magnetic-inner">Source Code</a></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
