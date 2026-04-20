<?php
if (!isset($profilData)) {
    $stmtProfilContact = $pdo->query('SELECT email_contact, telephone, avatar FROM profil WHERE id = 1 LIMIT 1');
    $profilData = $stmtProfilContact->fetch();
}
$contactEmail = !empty($profilData['email_contact']) ? $profilData['email_contact'] : 'contact@example.com';
$contactPhone = !empty($profilData['telephone']) ? $profilData['telephone'] : null;
$photoC = resolveMediaPath($profilData['avatar'] ?? '', '../assets/img/cyr.png');
?>
<div class="rounded-div-wrap rounded-light"><div class="rounded-div"></div></div>
<section id="contact" class="section contact-section">
    <div class="container contact-container">
        <?php if ($contactSuccess): ?>
            <div class="flash flash-success">Votre message a ete envoye avec succes. Je vous repondrai sous peu.</div>
        <?php endif; ?>

        <?php if ($contactError): ?>
            <div class="flash flash-error"><?= e($contactError) ?></div>
        <?php endif; ?>

        <div class="contact-header">
            <div class="contact-header-row">
                <div class="profile-picture" style="background-image: url('<?= e($photoC) ?>');"></div>
                <h2 class="section-title js-split-text">Let's work</h2>
            </div>
            <h2 class="section-title js-split-text">together</h2>
        </div>

        <div class="contact-form-wrapper">
            <form action="index.php#contact" method="POST" class="contact-form">
                <input type="hidden" name="action" value="contact">
                <input type="hidden" name="csrf_token" value="<?= e($csrf ?? '') ?>">

                <div class="contact-grid">
                    <div class="form-group"><input type="text" name="nom" placeholder="Votre nom" required></div>
                    <div class="form-group"><input type="email" name="email" placeholder="Votre email" required></div>
                </div>

                <div class="form-group"><input type="text" name="sujet" placeholder="Sujet" required></div>
                <div class="form-group"><textarea name="message" placeholder="Votre message" rows="5" required></textarea></div>

                <div class="contact-submit-wrap">
                    <button type="submit" class="btn btn-primary magnetic">Envoyer le message</button>
                </div>
            </form>

            <div class="contact-direct">
                <a class="direct-link" href="mailto:<?= e($contactEmail) ?>"><?= e($contactEmail) ?></a>
                <?php if ($contactPhone): ?>
                    <span><?= e($contactPhone) ?></span>
                <?php endif; ?>
                <div class="magnetic">
                    <a href="<?= getWhatsAppLink('+2290150386711', 'Bonjour Cyrus, je souhaiterais discuter de votre projet.') ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary magnetic-inner">Discuter sur WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
