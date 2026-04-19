<?php ob_start(); ?>
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2><?= $isEdit ? 'Modifier' : 'Nouvelle' ?> Compétence</h2>
    <a href="/admin/skills.php" class="btn" style="background: transparent; color: var(--text-muted);">&larr; Retour</a>
</div>

<form method="POST" class="card" style="max-width: 600px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div class="form-group">
        <label>Nom *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($skill['nom']) ?>" required>
    </div>
    
    <div class="form-group">
        <label>Catégorie</label>
        <select name="categorie">
            <option value="Frontend" <?= $skill['categorie'] == 'Frontend' ? 'selected' : '' ?>>Frontend</option>
            <option value="Backend" <?= $skill['categorie'] == 'Backend' ? 'selected' : '' ?>>Backend</option>
            <option value="Design" <?= $skill['categorie'] == 'Design' ? 'selected' : '' ?>>Design</option>
            <option value="Outils" <?= $skill['categorie'] == 'Outils' ? 'selected' : '' ?>>Outils / DevOps</option>
        </select>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="form-group">
            <label>Niveau (0-100)</label>
            <input type="number" name="niveau" value="<?= $skill['niveau'] ?>" min="0" max="100">
        </div>
        <div class="form-group">
            <label>Ordre</label>
            <input type="number" name="ordre" value="<?= $skill['ordre'] ?>">
        </div>
    </div>
    
    <button type="submit" class="btn">Enregistrer</button>
</form>
<?php $content = ob_get_clean(); require __DIR__ . '/layout.php';