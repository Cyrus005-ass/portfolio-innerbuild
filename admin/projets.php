<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = "Gestion des Projets";
$csrf = generateCsrfToken();

// Gestion de la suppression (POST requis avec CSRF)
if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }
    $idToDelete = (int)$_POST['delete'];
    $stmt = $pdo->prepare("DELETE FROM projets WHERE id = ?");
    if($stmt->execute([$idToDelete])) {
        header("Location: projets.php?msg=deleted");
        exit();
    }
}

// Récupération des projets
$stmt = $pdo->query("SELECT * FROM projets ORDER BY ordre ASC, id DESC");
$projets = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Gérer les Projets</h1>
    <a href="projets_edit.php" style="background: white; color: black; padding: 10px 20px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Nouveau Projet</a>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
<div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">Projet supprimé avec succès.</div>
<?php endif; ?>

<table style="width: 100%; border-collapse: collapse; text-align: left; background: var(--surface); border-radius: 8px; overflow: hidden;">
    <thead>
        <tr style="border-bottom: 1px solid var(--border);">
            <th style="padding: 15px;">Image</th>
            <th style="padding: 15px;">Nom</th>
            <th style="padding: 15px;">Technologies</th>
            <th style="padding: 15px;">Ordre</th>
            <th style="padding: 15px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projets as $p): ?>
        <tr style="border-bottom: 1px solid var(--border);">
            <td style="padding: 15px;">
                <?php if(!empty($p['image'])): ?>
                    <img src="../src/uploads/<?= htmlspecialchars($p['image']) ?>" alt="Aperçu" style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                <?php else: ?>
                    <div style="width: 80px; height: 50px; background: #333; border-radius: 4px; display:flex; align-items:center; justify-content:center; font-size:12px;">Sans img</div>
                <?php endif; ?>
            </td>
            <td style="padding: 15px;"><strong><?= htmlspecialchars($p['titre'] ?? 'Projet sans titre') ?></strong></td>
            <td style="padding: 15px; color: var(--text-muted);"><?= htmlspecialchars($p['technologies'] ?? '') ?></td>
            <td style="padding: 15px;"><?= $p['ordre'] ?></td>
            <td style="padding: 15px;">
                <a href="projets_edit.php?id=<?= $p['id'] ?>" style="color: #66b2ff; text-decoration: none; margin-right: 15px;">Modifier</a>
                <form method="POST" action="projets.php" style="display:inline;">
                    <input type="hidden" name="delete" value="<?= $p['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <button type="submit" style="background:none;border:none;color:#ff5555;cursor:pointer;padding:0;" onclick="return confirm('Supprimer ce projet ?');">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($projets)): ?>
        <tr>
            <td colspan="5" style="padding: 30px; text-align: center; color: var(--text-muted);">Aucun projet trouvé. Cliquez sur "Nouveau Projet" pour commencer.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<?php include __DIR__ . '/includes/footer.php'; ?>
