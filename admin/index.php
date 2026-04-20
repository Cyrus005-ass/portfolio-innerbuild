<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';

$pageTitle = 'Dashboard';

$stmt = $pdo->query("SELECT COUNT(*) as total FROM messages WHERE traite = 0");
$messagesCount = (int) $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM projets");
$projetsCount = (int) $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM skills");
$skillsCount = (int) $stmt->fetch()['total'];

include __DIR__ . '/includes/header.php';
?>

<h1>Bienvenue, <?= htmlspecialchars($_SESSION['admin_email']) ?></h1>

<div class="grid" style="margin-top: 18px;">
    <div class="card">
        <h3>Messages non lus</h3>
        <p class="stats-number" style="color: <?= $messagesCount > 0 ? 'var(--danger)' : 'var(--text)' ?>;"><?= $messagesCount ?></p>
        <a class="btn-link" href="messages.php">Voir les messages ?</a>
    </div>

    <div class="card">
        <h3>Projets</h3>
        <p class="stats-number"><?= $projetsCount ?></p>
        <a class="btn-link" href="projets.php">Gerer les projets ?</a>
    </div>

    <div class="card">
        <h3>Competences</h3>
        <p class="stats-number"><?= $skillsCount ?></p>
        <a class="btn-link" href="skills.php">Gerer les competences ?</a>
    </div>
</div>

<div class="card" style="margin-top: 16px;">
    <h2>Actions rapides</h2>
    <p class="muted">Ajoute ou modifie rapidement le contenu du portfolio.</p>
    <div class="form-actions">
        <a href="projets_edit.php" class="btn btn-primary">+ Nouveau projet</a>
        <a href="skills_edit.php" class="btn btn-primary">+ Nouvelle competence</a>
        <a href="certifications_edit.php" class="btn btn-primary">+ Nouvelle certification</a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
