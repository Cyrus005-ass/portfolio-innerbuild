<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = 'Gestion des Projets';
$csrf = generateCsrfToken();

if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }

    $idToDelete = (int) $_POST['delete'];
    $stmt = $pdo->prepare('DELETE FROM projets WHERE id = ?');
    if ($stmt->execute([$idToDelete])) {
        header('Location: projets.php?msg=deleted');
        exit();
    }
}

$stmt = $pdo->query('SELECT * FROM projets ORDER BY ordre ASC, id DESC');
$projets = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1>Gerer les Projets</h1>
    <a href="projets_edit.php" class="btn btn-light">+ Nouveau Projet</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">Projet supprime avec succes.</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Technologies</th>
                <th>Ordre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projets as $p): ?>
                <tr>
                    <td>
                        <?php if (!empty($p['image'])): ?>
                            <img src="../src/uploads/<?= htmlspecialchars($p['image']) ?>" alt="Apercu" class="thumb">
                        <?php else: ?>
                            <div class="thumb" style="display:flex;align-items:center;justify-content:center;font-size:12px;">Sans img</div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= htmlspecialchars($p['titre'] ?? 'Projet sans titre') ?></strong></td>
                    <td class="muted"><?= htmlspecialchars($p['technologies'] ?? '') ?></td>
                    <td><?= (int) $p['ordre'] ?></td>
                    <td>
                        <div class="actions-inline">
                            <a href="projets_edit.php?id=<?= (int) $p['id'] ?>" class="text-link">Modifier</a>
                            <form method="POST" action="projets.php">
                                <input type="hidden" name="delete" value="<?= (int) $p['id'] ?>">
                                <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce projet ?');">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($projets)): ?>
                <tr>
                    <td colspan="5" class="muted">Aucun projet trouve. Clique sur "Nouveau Projet" pour commencer.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
