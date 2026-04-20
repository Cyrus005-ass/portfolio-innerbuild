<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = 'Competences';
$csrf = generateCsrfToken();

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (isset($_GET['csrf']) && verifyCsrfToken($_GET['csrf'])) {
        $stmt = $pdo->prepare('DELETE FROM skills WHERE id = ?');
        $stmt->execute([(int) $_GET['delete']]);
        header('Location: skills.php?msg=deleted');
    }
    exit();
}

$stmt = $pdo->query('SELECT * FROM skills ORDER BY categorie, ordre ASC');
$skills = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1>Competences</h1>
    <a href="skills_edit.php" class="btn btn-primary">+ Nouvelle competence</a>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">Competence supprimee.</div>
<?php endif; ?>

<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th>Categorie</th>
                <th>Nom</th>
                <th>Niveau (%)</th>
                <th>Ordre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($skills as $s): ?>
                <tr>
                    <td class="muted"><?= htmlspecialchars($s['categorie']) ?></td>
                    <td><strong><?= htmlspecialchars($s['nom']) ?></strong></td>
                    <td><?= (int) $s['niveau'] ?>%</td>
                    <td><?= (int) $s['ordre'] ?></td>
                    <td>
                        <div class="actions-inline">
                            <a href="skills_edit.php?id=<?= (int) $s['id'] ?>" class="text-link">Modifier</a>
                            <a href="skills.php?delete=<?= (int) $s['id'] ?>&csrf=<?= htmlspecialchars($csrf) ?>" class="btn btn-danger" onclick="return confirm('Supprimer cette competence ?');">Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($skills)): ?>
                <tr><td colspan="5" class="muted">Aucune competence enregistree.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
