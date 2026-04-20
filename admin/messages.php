<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$pageTitle = 'Messages recus';
$csrf = generateCsrfToken();

if (isset($_POST['read']) && is_numeric($_POST['read'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }

    $stmt = $pdo->prepare('UPDATE messages SET traite = 1 WHERE id = ?');
    $stmt->execute([(int) $_POST['read']]);
    header('Location: messages.php');
    exit();
}

if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    if (!verifyCsrfToken($_POST['csrf'] ?? '')) {
        die('Token CSRF invalide');
    }

    $stmt = $pdo->prepare('DELETE FROM messages WHERE id = ?');
    $stmt->execute([(int) $_POST['delete']]);
    header('Location: messages.php?msg=deleted');
    exit();
}

$stmt = $pdo->query('SELECT * FROM messages ORDER BY date_envoi DESC');
$messages = $stmt->fetchAll();

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1>Messages</h1>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div class="alert alert-success">Message supprime.</div>
<?php endif; ?>

<div style="display: flex; flex-direction: column; gap: 12px;">
    <?php foreach ($messages as $m): ?>
        <div class="card message-card <?= (int) $m['traite'] === 0 ? 'unread' : '' ?>">
            <div class="message-meta">
                <div>
                    <strong style="font-size: 1.05rem;"><?= htmlspecialchars($m['nom']) ?></strong>
                    <span class="muted">&lt;<?= htmlspecialchars($m['email']) ?>&gt;</span>
                </div>
                <div class="muted"><?= htmlspecialchars((string) $m['date_envoi']) ?></div>
            </div>

            <div class="muted" style="margin-bottom: 10px; font-weight: 600;">
                Sujet: <?= htmlspecialchars($m['sujet'] ?? 'Sans sujet') ?>
            </div>

            <div class="message-content"><?= htmlspecialchars($m['contenu']) ?></div>

            <div class="form-actions" style="margin-top: 10px;">
                <?php if ((int) $m['traite'] === 0): ?>
                    <form method="POST" action="messages.php">
                        <input type="hidden" name="read" value="<?= (int) $m['id'] ?>">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                        <button type="submit" class="btn btn-primary">Marquer comme lu</button>
                    </form>
                <?php endif; ?>
                <form method="POST" action="messages.php">
                    <input type="hidden" name="delete" value="<?= (int) $m['id'] ?>">
                    <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Supprimer ce message ?');">Supprimer</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($messages)): ?>
        <div class="card muted">Aucun message recu pour le moment.</div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
