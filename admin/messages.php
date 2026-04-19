<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = "Messages Reçus";
$csrf = generateCsrfToken();

// Marquer comme traité (POST)
if (isset($_POST['read']) && is_numeric($_POST['read'])) {
    $stmt = $pdo->prepare("UPDATE messages SET traite = 1 WHERE id = ?");
    $stmt->execute([(int)$_POST['read']]);
    header("Location: messages.php");
    exit();
}

// Suppression (POST)
if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([(int)$_POST['delete']]);
    header("Location: messages.php?msg=deleted");
    exit();
}

// Liste
$stmt = $pdo->query("SELECT * FROM messages ORDER BY date_envoi DESC");
$messages = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Messages</h1>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;">Message supprimé.</div>
<?php endif; ?>

<div style="display: flex; flex-direction: column; gap: 20px;">
    <?php foreach($messages as $m): ?>
    <div class="card" style="position: relative; border-left: 4px solid <?= $m['traite'] ? '#333' : '#ff5555' ?>;">
        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div>
                <strong style="font-size: 1.2rem;"><?= htmlspecialchars($m['nom']) ?></strong> 
                <span style="color: var(--text-muted); margin-left: 10px;">&lt;<?= htmlspecialchars($m['email']) ?>&gt;</span>
            </div>
            <div style="color: var(--text-muted); font-size: 0.9rem;">
                <?= $m['date_envoi'] ?>
            </div>
        </div>
        <div style="margin-bottom: 15px; font-weight: 600; color: #aaa;">
            Sujet: <?= htmlspecialchars($m['sujet'] ?? 'Sans sujet') ?>
        </div>
        <div style="background: rgba(0,0,0,0.2); padding: 15px; border-radius: 4px; line-height: 1.6; white-space: pre-wrap;"><?= htmlspecialchars($m['contenu']) ?></div>
        
        <div style="margin-top: 15px; display: flex; gap: 15px;">
            <?php if(!$m['traite']): ?>
                <form method="POST" action="messages.php" style="display:inline;">
                    <input type="hidden" name="read" value="<?= $m['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= $csrf ?>">
                    <button type="submit" style="background:none;border:none;color:#2ebd59;font-weight:bold;cursor:pointer;padding:0;">Marquer comme lu</button>
                </form>
            <?php endif; ?>
            <form method="POST" action="messages.php" style="display:inline;">
                <input type="hidden" name="delete" value="<?= $m['id'] ?>">
                <input type="hidden" name="csrf" value="<?= $csrf ?>">
                <button type="submit" style="background:none;border:none;color:#ff5555;cursor:pointer;padding:0;" onclick="return confirm('Supprimer ce message ?');">Supprimer</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
    
    <?php if(empty($messages)): ?>
        <div class="card" style="text-align: center; color: var(--text-muted);">Aucun message reçu pour le moment.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
