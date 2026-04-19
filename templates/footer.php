<?php
$stmtProfilFooter = $pdo->query("SELECT linkedin, github, instagram FROM profil WHERE id = 1 LIMIT 1");
$profilFooter = $stmtProfilFooter->fetch();
$linkedin = $profilFooter['linkedin'] ?? null;
$github = $profilFooter['github'] ?? null;
$instagram = $profilFooter['instagram'] ?? null;
$footerEmail = 'cyr.ass.dev@gmail.com';
?>
</main> <!-- Fin de main-container -->

<footer class="main-footer" data-scroll-section>
    <div class="container footer-content">
        <div class="footer-col">
            <p>&copy; <?= date('Y') ?> C-Y Ass. Tous droits réservés.</p>
            <a class="footer-email" href="mailto:<?= htmlspecialchars($footerEmail) ?>"><?= htmlspecialchars($footerEmail) ?></a>
        </div>
        <div class="social-links" aria-label="Réseaux sociaux">
            <?php if ($linkedin): ?>
                <a href="<?= htmlspecialchars($linkedin) ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
            <?php endif; ?>
            <?php if ($github): ?>
                <a href="<?= htmlspecialchars($github) ?>" target="_blank" rel="noopener noreferrer">GitHub</a>
            <?php endif; ?>
            <?php if ($instagram): ?>
                <a href="<?= htmlspecialchars($instagram) ?>" target="_blank" rel="noopener noreferrer">Instagram</a>
            <?php endif; ?>
            <?php if (!$linkedin && !$github && !$instagram): ?>
                <span class="social-empty">Réseaux bientôt disponibles</span>
            <?php endif; ?>
        </div>
    </div>
</footer>
<div id="lightbox" class="lightbox" aria-hidden="true">
    <button type="button" class="lightbox-close" aria-label="Fermer">&times;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Détail de certification">
        <div class="lightbox-meta">
            <strong id="lightbox-title">Certification</strong>
            <a id="lightbox-link" href="#" target="_blank" rel="noopener noreferrer" style="display:none;">Vérifier</a>
        </div>
    </div>
</div>

<!-- Scripts externes (GSAP, ScrollTrigger, Locomotive Scroll) -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>

<!-- Script principal -->
<script src="<?= htmlspecialchars($config['app_url'] ?? '') ?>/../assets/js/main.js"></script>
</body>
</html>
