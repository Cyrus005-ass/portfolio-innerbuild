<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Projets</h2>
    <a href="/admin/projet_form.php" class="btn">+ Nouveau projet</a>
</div>

<?php if (isset($_GET['deleted'])): ?>
<div class="alert alert-success">Projet supprimé</div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Technologies</th>
            <th>Année</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projets as $p): ?>
        <tr>
            <td>
                <?php if (!empty($p['image'])): ?>
                    <img src="/src/uploads/<?= htmlspecialchars($p['image']) ?>" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 4px;">
                <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($p['titre']) ?></strong></td>
            <td><?= htmlspecialchars($p['technologies']) ?></td>
            <td><?= htmlspecialchars($p['annee']) ?></td>
            <td>
                <div class="actions">
                    <a href="/admin/projet_form.php?id=<?= $p['id'] ?>">Modifier</a>
                    <a href="/admin/projets.php?delete=<?= $p['id'] ?>" class="delete" onclick="return confirm('Supprimer ce projet?')">Supprimer</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($projets)): ?>
        <tr><td colspan="5" class="empty">Aucun projet</td></tr>
        <?php endif; ?>
    </tbody>
</table>