<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';

$pageTitle = 'Dashboard';

$stmt = $pdo->query("SELECT COUNT(*) as total FROM messages WHERE traite = 0");
$messagesCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM projets");
$projetsCount = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM skills");
$skillsCount = $stmt->fetch()['total'];

include __DIR__ . '/includes/header.php';
?>

<h1>Bienvenue, <?= htmlspecialchars($_SESSION['admin_email']) ?></h1>

<div class="grid">
    <div class="card">
        <h3>Messages Non Lus</h3>
        <p style="font-size: 2rem; font-weight: bold; margin: 10px 0; color: <?= $messagesCount > 0 ? '#ff5555' : 'white' ?>;"><?= $messagesCount ?></p>
        <a href="messages.php" style="color: #aaa;">Voir les messages &rarr;</a>
    </div>
    
    <div class="card">
        <h3>Projets</h3>
        <p style="font-size: 2rem; font-weight: bold; margin: 10px 0;"><?= $projetsCount ?></p>
        <a href="projets.php" style="color: #aaa;">Gérer les projets &rarr;</a>
    </div>
    
    <div class="card">
        <h3>Compétences</h3>
        <p style="font-size: 2rem; font-weight: bold; margin: 10px 0;"><?= $skillsCount ?></p>
        <a href="skills.php" style="color: #aaa;">Gérer les compétences &rarr;</a>
    </div>
</div>

<div class="card" style="margin-top: 40px;">
    <h2>Actions Rapides</h2>
    <p>Depuis le menu latéral, vous pouvez ajouter ou modifier le contenu de votre portfolio.</p>
    <div style="display: flex; gap: 12px; margin-top: 20px; flex-wrap: wrap;">
        <a href="projets_edit.php" class="btn" style="background: #3b82f6;">+ Nouveau projet</a>
        <a href="skills_edit.php" class="btn" style="background: #3b82f6;">+ Nouvelle compétence</a>
        <a href="certifications_edit.php" class="btn" style="background: #3b82f6;">+ Nouvelle certification</a>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
