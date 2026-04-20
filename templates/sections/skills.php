<?php
?>
<div class="rounded-div-wrap rounded-dark"><div class="rounded-div"></div></div>
<section id="skills" class="section skills-section">
    <div class="container">
        <h2 class="section-title js-split-text">Mon Expertise</h2>
        <div class="skills-layout">
            <?php if (empty($groupedSkills)): ?>
                <p class="empty-text">Competences en cours d'ajout.</p>
            <?php endif; ?>
            <?php foreach ($groupedSkills as $categorie => $skills): ?>
                <?php if (count($skills) > 0): ?>
                    <div class="skill-category">
                        <h3 class="skill-category-title js-split-text"><?= e($categorie) ?></h3>
                        <ul class="skill-list">
                            <?php foreach ($skills as $skill): ?>
                                <li class="skill-item magnetic">
                                    <div class="magnetic-inner">
                                        <span><?= e($skill['nom']) ?></span>
                                        <small><?= (int) ($skill['niveau'] ?? 0) ?>%</small>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
