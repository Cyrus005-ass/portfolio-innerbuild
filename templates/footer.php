<?php
$stmtProfilFooter = $pdo->query('SELECT linkedin, github, instagram, email_contact FROM profil WHERE id = 1 LIMIT 1');
$profilFooter = $stmtProfilFooter->fetch();
$linkedin = $profilFooter['linkedin'] ?? null;
$github = $profilFooter['github'] ?? null;
$instagram = $profilFooter['instagram'] ?? null;
$footerEmail = !empty($profilFooter['email_contact']) ? $profilFooter['email_contact'] : 'contact@example.com';
$basePath = rtrim((string) ($config['base_path'] ?? ''), '/');
$jsPath = dirname(__DIR__) . '/assets/js/main.js';
$jsVersion = is_file($jsPath) ? (string) filemtime($jsPath) : (string) time();
?>
</main>

<footer class="main-footer">
    <div class="container footer-content">
        <div class="footer-col">
            <p>&copy; <?= date('Y') ?> C-Y Ass. Tous droits reserves.</p>
            <a class="footer-email" href="mailto:<?= htmlspecialchars($footerEmail) ?>"><?= htmlspecialchars($footerEmail) ?></a>
        </div>
        <div class="social-links" aria-label="Reseaux sociaux">
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
                <span class="social-empty">Reseaux bientot disponibles</span>
            <?php endif; ?>
        </div>
    </div>
</footer>

<div id="lightbox" class="lightbox" aria-hidden="true">
    <button type="button" class="lightbox-close" aria-label="Fermer">&times;</button>
    <div class="lightbox-content">
        <img id="lightbox-img" src="" alt="Detail de certification">
        <div class="lightbox-meta">
            <strong id="lightbox-title">Certification</strong>
            <a id="lightbox-link" href="#" target="_blank" rel="noopener noreferrer" style="display:none;">Verifier</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.2/dist/ScrollTrigger.min.js"></script>
<script src="<?= htmlspecialchars($basePath . '/assets/js/main.js?v=' . $jsVersion) ?>"></script>
</body>
</html>
