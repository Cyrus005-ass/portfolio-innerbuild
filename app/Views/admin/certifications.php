<div style="display: flex; justify-content: space-between; align-items: center;">
    <h2>Certifications</h2>
    <a href="/admin/cert_form.php" class="btn">+ Nouvelle certification</a>
</div>

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Organisme</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($certs as $c): ?>
        <tr>
            <td>
                <?php if (!empty($c['photo'])): ?>
                    <img src="/src/uploads/<?= htmlspecialchars($c['photo']) ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($c['nom']) ?></strong></td>
            <td><?= htmlspecialchars($c['organisme']) ?></td>
            <td><?= $c['date_obtention'] ?></td>
            <td>
                <div class="actions">
                    <a href="/admin/cert_form.php?id=<?= $c['id'] ?>">Modifier</a>
                    <a href="/admin/certifications.php?delete=<?= $c['id'] ?>" class="delete" onclick="return confirm('Supprimer?')">Supprimer</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($certs)): ?>
        <tr><td colspan="5" class="empty">Aucune certification</td></tr>
        <?php endif; ?>
    </tbody>
</table>