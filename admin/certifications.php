<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = 'Gestion des Certifications';
$csrf = generateCsrfToken();

if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }

    $stmt = $pdo->prepare('DELETE FROM certifications WHERE id = ?');
    $stmt->execute([(int) $_POST['delete']]);
    header('Location: certifications.php?msg=deleted');
    exit();
}

$stmt = $pdo->query('SELECT * FROM certifications ORDER BY ordre ASC, date_obtention DESC');
$certs = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1>Certifications et Diplomes</h1>
    <a href="certifications_edit.php" class="btn btn-light">+ Nouvelle Certification</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">Certification supprimee.</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
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
                            <img src="../src/uploads/<?= htmlspecialchars($c['photo']) ?>" alt="Apercu" class="thumb-round">
                        <?php else: ?>
                            <div class="thumb-round"></div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($c['nom'] ?? 'Certification') ?></strong></td>
                    <td class="muted"><?= htmlspecialchars($c['organisme'] ?? '') ?></td>
                    <td><?= htmlspecialchars((string) ($c['date_obtention'] ?? '')) ?></td>
                    <td>
                        <div class="actions-inline">
                            <a href="certifications_edit.php?id=<?= (int) $c['id'] ?>" class="text-link">Modifier</a>
                            <form method="POST" action="certifications.php">
                                <input type="hidden" name="delete" value="<?= (int) $c['id'] ?>">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ?');">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($certs)): ?>
                <tr><td colspan="5" class="muted">Aucune certification trouvee.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
