<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = "Gestion des Certifications";
$csrf = generateCsrfToken();

// Suppression (POST)
if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }
    $stmt = $pdo->prepare("DELETE FROM certifications WHERE id = ?");
    $stmt->execute([(int)$_POST['delete']]);
    header("Location: certifications.php?msg=deleted");
    exit();
}

// Liste
$stmt = $pdo->query("SELECT * FROM certifications ORDER BY ordre ASC, date_obtention DESC");
$certs = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Certifications & Diplômes</h1>
    <a href="certifications_edit.php" style="background: white; color: black; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Nouvelle Certification</a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">Certification supprimée.</div>
<?php endif; ?>

<table style="width: 100%; border-collapse: collapse; text-align: left; background: var(--surface); border-radius: 8px; overflow: hidden;">
    <thead>
        <tr style="border-bottom: 1px solid var(--border);">
            <th style="padding: 15px;">Image</th>
            <th style="padding: 15px;">Titre</th>
            <th style="padding: 15px;">Organisme</th>
            <th style="padding: 15px;">Date</th>
            <th style="padding: 15px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($certs as $c): ?>
        <tr style="border-bottom: 1px solid var(--border);">
            <td style="padding: 15px;">
                <?php if(!empty($c['photo'])): ?>
                    <img src="../src/uploads/<?= htmlspecialchars($c['photo']) ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                <?php else: ?>
                    <div style="width: 50px; height: 50px; background: #333; border-radius: 50%;"></div>
                <?php endif; ?>
            </td>
            <td style="padding: 15px;"><strong><?= htmlspecialchars($c['nom'] ?? 'Certification') ?></strong></td>
            <td style="padding: 15px; color: var(--text-muted);"><?= htmlspecialchars($c['organisme']) ?></td>
            <td style="padding: 15px;"><?= $c['date_obtention'] ?></td>
            <td style="padding: 15px;">
                <a href="certifications_edit.php?id=<?= $c['id'] ?>" style="color: #66b2ff; text-decoration: none; margin-right: 15px;">Modifier</a>
                <form method="POST" action="certifications.php" style="display:inline;">
                    <input type="hidden" name="delete" value="<?= $c['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <button type="submit" style="background:none;border:none;color:#ff5555;cursor:pointer;padding:0;" onclick="return confirm('Supprimer ?');">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($certs)): ?>
            <tr><td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">Aucune certification trouvée.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/footer.php'; ?>
