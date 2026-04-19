<?php ob_start(); ?>
<form method="POST" enctype="multipart/form-data" class="card" style="max-width: 900px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Nom complet *</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>" required>
        </div>
        <div class="form-group">
            <label>Localisation</label>
            <input type="text" name="localisation" value="<?= htmlspecialchars($profil['localisation'] ?? 'Bénin') ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label>Titre professionnel</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($profil['titre'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label>Biographie</label>
        <textarea name="bio"><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email_contact" value="<?= htmlspecialchars($profil['email_contact'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="telephone" value="<?= htmlspecialchars($profil['telephone'] ?? '') ?>">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>GitHub</label>
            <input type="url" name="github" value="<?= htmlspecialchars($profil['github'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>LinkedIn</label>
            <input type="url" name="linkedin" value="<?= htmlspecialchars($profil['linkedin'] ?? '') ?>">
        </div>
        <div class="form-group">
            <label>Instagram</label>
            <input type="url" name="instagram" value="<?= htmlspecialchars($profil['instagram'] ?? '') ?>">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Avatar</label>
            <input type="file" name="photo" accept="image/*">
            <?php if (!empty($profil['avatar'])): ?>
                <img src="/src/uploads/<?= htmlspecialchars($profil['avatar']) ?>" style="width: 80px; margin-top: 10px; border-radius: 50%;">
            <?php endif; ?>
        </div>
        <div class="form-group">
            <label>CV (PDF)</label>
            <input type="file" name="cv_file" accept=".pdf">
            <?php if (!empty($profil['cv_url'])): ?>
                <a href="../../src/uploads/<?= htmlspecialchars($profil['cv_url'] ?? '') ?>" target="_blank" style="display: block; margin-top: 10px;">Voir CV</a>
            <?php endif; ?>
        </div>
    </div>
    
    <button type="submit" class="btn">Enregistrer</button>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php';