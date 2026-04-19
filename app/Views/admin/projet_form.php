<?php ob_start(); ?>
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2><?= $isEdit ? 'Modifier' : 'Nouveau' ?> Projet</h2>
    <a href="/admin/projets.php" class="btn" style="background: transparent; color: var(--text-muted);">&larr; Retour</a>
</div>

<form method="POST" enctype="multipart/form-data" class="card" style="max-width: 800px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Titre *</label>
            <input type="text" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required>
        </div>
        <div class="form-group">
            <label>Année</label>
            <input type="text" name="annee" value="<?= htmlspecialchars($projet['annee'] ?? date('Y')) ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label>Technologies (séparées par virgule)</label>
        <input type="text" name="technologies" value="<?= htmlspecialchars($projet['technologies']) ?>">
    </div>
    
    <div class="form-group">
        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($projet['description']) ?></textarea>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Lien live</label>
            <input type="url" name="lien_live" value="<?= htmlspecialchars($projet['lien_live']) ?>">
        </div>
        <div class="form-group">
            <label>Lien GitHub</label>
            <input type="url" name="lien_github" value="<?= htmlspecialchars($projet['lien_github']) ?>">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Ordre</label>
            <input type="number" name="ordre" value="<?= $projet['ordre'] ?>">
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
            <?php if (!empty($projet['image'])): ?>
                <img src="/src/uploads/<?= htmlspecialchars($projet['image']) ?>" style="width: 100px; margin-top: 10px; border-radius: 4px;">
            <?php endif; ?>
        </div>
    </div>
    
    <button type="submit" class="btn">Enregistrer</button>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php';