<?php ob_start(); ?>
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> Certification</h2>
    <a href="/admin/certifications.php" class="btn" style="background: transparent; color: var(--text-muted);">&larr; Retour</a>
</div>

<form method="POST" enctype="multipart/form-data" class="card" style="max-width: 700px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div class="form-group">
        <label>Nom *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($cert['nom']) ?>" required>
    </div>
    
    <div class="form-group">
        <label>Organisme *</label>
        <input type="text" name="organisme" value="<?= htmlspecialchars($cert['organisme']) ?>" required>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Date d'obtention</label>
            <input type="date" name="date_obtention" value="<?= $cert['date_obtention'] ?>">
        </div>
        <div class="form-group">
            <label>Ordre</label>
            <input type="number" name="ordre" value="<?= $cert['ordre'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label>URL de vérification</label>
        <input type="url" name="lien_verification" value="<?= htmlspecialchars($cert['lien_verification']) ?>">
    </div>
    
    <div class="form-group">
        <label>Photo/Badge</label>
        <input type="file" name="photo" accept="image/*">
        <?php if (!empty($cert['photo'])): ?>
            <img src="/src/uploads/<?= htmlspecialchars($cert['photo']) ?>" style="width: 60px; margin-top: 10px; border-radius: 50%;">
        <?php endif; ?>
    </div>
    
    <button type="submit" class="btn">Enregistrer</button>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php';