<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Compétences</h2>
    <a href="/admin/skill_form.php" class="btn">+ Nouvelle compétence</a>
</div>

<table>
    <thead>
        <tr>
            <th>Catégorie</th>
            <th>Nom</th>
            <th>Niveau</th>
            <th>Ordre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($skills as $s): ?>
        <tr>
            <td><?= htmlspecialchars($s['categorie']) ?></td>
            <td><strong><?= htmlspecialchars($s['nom']) ?></strong></td>
            <td><?= $s['niveau'] ?>%</td>
            <td><?= $s['ordre'] ?></td>
            <td>
                <div class="actions">
                    <a href="/admin/skill_form.php?id=<?= $s['id'] ?>">Modifier</a>
                    <a href="/admin/skills.php?delete=<?= $s['id'] ?>" class="delete" onclick="return confirm('Supprimer?')">Supprimer</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($skills)): ?>
        <tr><td colspan="5" class="empty">Aucune compétence</td></tr>
        <?php endif; ?>
    </tbody>
</table>