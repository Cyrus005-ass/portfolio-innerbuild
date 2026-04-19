<?php
if (!isset($profilData)) {
    $stmtProfilContact = $pdo->query("SELECT email_contact, telephone, avatar FROM profil WHERE id = 1 LIMIT 1");
    $profilData = $stmtProfilContact->fetch();
}
$contactEmail = 'cyr.ass.dev@gmail.com';
$contactPhone = !empty($profilData['telephone']) ? $profilData['telephone'] : null;
$photoC = !empty($profilData['avatar']) && file_exists(__DIR__ . '/../../src/uploads/' . $profilData['avatar']) ? '../src/uploads/' . htmlspecialchars($profilData['avatar']) : '../assets/img/cyr.png';
?>
<div class="rounded-div-wrap" data-scroll-section style="background: var(--text-light); height: 5vh; transform: translateY(1px); z-index:10;">
    <div class="rounded-div" style="background: var(--bg-dark);"></div>
</div>
<section id="contact" class="section contact-section" data-scroll-section style="background-color: var(--bg-dark); padding-top: 80px; position: relative;">
    <div class="container contact-container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; width: 100%;">
        <?php if ($contactSuccess): ?>
            <div style="background: #2ebd59; color: white; padding: 20px 40px; border-radius: 10px; margin-bottom: 40px; width: 100%; max-width: 600px; text-align: center;">
                Votre message a été envoyé avec succès ! Je vous répondrai sous peu.
            </div>
        <?php endif; ?>
        
        <?php if ($contactError): ?>
            <div style="background: #ff5555; color: white; padding: 20px 40px; border-radius: 10px; margin-bottom: 40px; width: 100%; max-width: 600px; text-align: center;">
                <?= htmlspecialchars($contactError) ?>
            </div>
        <?php endif; ?>

        <div class="contact-header" data-scroll data-scroll-speed="1.5" style="display: flex; flex-direction: column; align-items: center; text-align: center; gap: 30px;">
            <div style="display: flex; align-items: center; gap: 20px;">
                <div class="profile-picture" style="background-image: url('<?= $photoC ?>');"></div>
                <h2 class="section-title js-split-text" style="font-size: clamp(4rem, 10vw, 8rem); margin: 0; font-weight: 300;">Let's work</h2>
            </div>
            <h2 class="section-title js-split-text" style="font-size: clamp(4rem, 10vw, 8rem); margin: 0; font-weight: 300;">together</h2>
        </div>
        
        <div style="margin-top: 80px; width: 100%; max-width: 600px; padding: 0 5vw;">
            <div style="width: 100%; height: 1px; background: rgba(255,255,255,0.2); margin-bottom: 40px;"></div>
            
            <div data-scroll data-scroll-speed="0.5" style="width: 100%;">
                <form action="index.php#contact" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
                    <input type="hidden" name="action" value="contact">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf ?? '') ?>">
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group" style="margin-bottom: 0;">
                            <input type="text" name="nom" placeholder="Votre nom" required style="width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.2); padding: 15px 0; color: #fff; font-size: 1.1rem; outline: none; transition: 0.3s;">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <input type="email" name="email" placeholder="Votre email" required style="width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.2); padding: 15px 0; color: #fff; font-size: 1.1rem; outline: none; transition: 0.3s;">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="sujet" placeholder="Sujet" required style="width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.2); padding: 15px 0; color: #fff; font-size: 1.1rem; outline: none; transition: 0.3s;">
                    </div>
                    
                    <div class="form-group">
                        <textarea name="message" placeholder="Votre message" rows="5" required style="width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.2); padding: 15px 0; color: #fff; font-size: 1.1rem; outline: none; transition: 0.3s; resize: none;"></textarea>
                    </div>
                    
                    <div style="margin-top: 20px; display: flex; justify-content: center;">
                        <button type="submit" class="btn btn-primary magnetic" style="border: none; padding: 20px 60px; border-radius: 50px; font-weight: 600; cursor: pointer;">
                            Envoyer le message
                        </button>
                    </div>
                </form>
            </div>
            
            <div style="margin-top: 60px; display: flex; flex-direction: column; gap: 25px; align-items: center;">
                <div class="magnetic" style="margin-top: 10px;">
                    <a href="<?= getWhatsAppLink('+2290150386711', 'Bonjour Cyrus, je souhaiterais discuter de votre projet.') ?>" target="_blank" class="btn btn-primary magnetic-inner" style="background: #25D366; color: white; border: none; padding: 15px 40px; border-radius: 50px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                        Discuter sur WhatsApp &nearr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
