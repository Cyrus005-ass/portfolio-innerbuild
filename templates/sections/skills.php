<?php
// templates/sections/skills.php
// $groupedSkills est fourni par le contrôleur (index.php)
?>
<div class="rounded-div-wrap" data-scroll-section style="background: var(--bg-dark); height: 5vh; transform: translateY(1px); z-index: 10;">
    <div class="rounded-div" style="background: var(--bg-dark);"></div>
</div>
<section id="skills" class="section skills-section" data-scroll-section style="background-color: var(--text-light); color: var(--bg-dark); padding: 80px 0;">
    <div class="container" style="padding: 0 5vw;">
        <h2 class="section-title js-split-text" data-scroll data-scroll-speed="1" style="font-size: clamp(3rem, 8vw, 6rem); margin-bottom: 80px; text-align: left; font-weight: 300;">Mon Expertise</h2>
        
        <div class="skills-layout" style="display: flex; flex-direction: column;">
            <?php if (empty($groupedSkills)): ?>
                <p style="font-size:1.2rem;color:#555;">Compétences en cours d'ajout.</p>
            <?php endif; ?>
            <?php foreach ($groupedSkills as $categorie => $skills): ?>
                <?php if (count($skills) > 0): ?>
                <div class="skill-category" data-scroll data-scroll-speed="0.5" style="border-top: 1px solid rgba(0,0,0,0.1); padding: 40px 0; display: grid; grid-template-columns: 1fr 2fr; gap: 40px;">
                    <h3 class="skill-category-title js-split-text" style="font-size: 2rem; font-weight: 400; color: var(--bg-dark); margin: 0; border: none; padding: 0;"><?= htmlspecialchars($categorie) ?></h3>
                    
                    <ul class="skill-list" style="display: flex; flex-wrap: wrap; gap: 15px; margin: 0;">
                        <?php foreach ($skills as $skill): ?>
                        <li class="skill-item magnetic" style="width: auto;">
                            <div class="magnetic-inner" style="padding: 15px 30px; border: 1px solid rgba(0,0,0,0.1); border-radius: 50px; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; transition: 0.3s; cursor: default;">
                                <span><?= htmlspecialchars($skill['nom']) ?></span>
                                <small style="opacity:.65;"><?= (int)($skill['niveau'] ?? 0) ?>%</small>
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
