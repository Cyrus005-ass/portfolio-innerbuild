<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = 'Compétences';
$csrf = generateCsrfToken();

// Suppression
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if (isset($_GET['csrf']) && verifyCsrfToken($_GET['csrf'])) {
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([(int)$_GET['delete']]);
        header("Location: skills.php?msg=deleted");
    }
    exit();
}

// Liste
$stmt = $pdo->query("SELECT * FROM skills ORDER BY categorie, ordre ASC");
$skills = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Compétences</h1>
    <a href="skills_edit.php" class="btn" style="background: #3b82f6;">+ Nouvelle compétence</a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert" style="background: #22c55e; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">Compétence supprimée.</div>
<?php endif; ?>

<table style="width: 100%; border-collapse: collapse; text-align: left;">
    <thead>
        <tr style="border-bottom: 1px solid var(--border);">
            <th style="padding: 15px;">Catégorie</th>
            <th style="padding: 15px;">Nom</th>
            <th style="padding: 15px;">Niveau (%)</th>
            <th style="padding: 15px;">Ordre</th>
            <th style="padding: 15px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($skills as $s): ?>
        <tr style="border-bottom: 1px solid var(--border);">
            <td style="padding: 15px; color: var(--text-muted);"><?= htmlspecialchars($s['categorie']) ?></td>
            <td style="padding: 15px;"><strong><?= htmlspecialchars($s['nom']) ?></strong></td>
            <td style="padding: 15px;"><?= $s['niveau'] ?>%</td>
            <td style="padding: 15px;"><?= $s['ordre'] ?></td>
            <td style="padding: 15px;">
                <a href="skills_edit.php?id=<?= $s['id'] ?>" style="color: #66b2ff; text-decoration: none; margin-right: 15px;">Modifier</a>
                <a href="skills.php?delete=<?= $s['id'] ?>&csrf=<?= $csrf ?>" style="color: #ff5555; text-decoration: none;" onclick="return confirm('Supprimer cette compétence ?');">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($skills)): ?>
            <tr><td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">Aucune compétence enregistrée.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/footer.php'; ?>
