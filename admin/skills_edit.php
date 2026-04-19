<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? "Modifier la Compétence" : "Nouvelle Compétence";
$error = '';
$success = '';

$skill = ['nom' => '', 'categorie' => 'Frontend', 'niveau' => 80, 'ordre' => 0];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) $skill = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = "Token CSRF invalide.";
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $categorie = trim($_POST['categorie'] ?? '');
        $niveau = max(0, min(100, (int)($_POST['niveau'] ?? 80)));
        $ordre = (int)($_POST['ordre'] ?? 0);

        if (empty($nom)) {
            $error = "Le nom est obligatoire.";
        } else {
            if ($isEdit) {
                $stmt = $pdo->prepare("UPDATE skills SET nom=?, categorie=?, niveau=?, ordre=? WHERE id=?");
                $stmt->execute([$nom, $categorie, $niveau, $ordre, $id]);
                $success = "Compétence mise à jour.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO skills (nom, categorie, niveau, ordre) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $categorie, $niveau, $ordre]);
                header("Location: skills.php");
                exit();
            }
        }
    }
}

$csrf = generateCsrfToken();
include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1><?= $pageTitle ?></h1>
    <a href="skills.php" style="color: var(--text-muted); text-decoration: none;">&larr; Retour</a>
</div>

<?php if($error): ?>
    <div class="alert" style="background: #ef4444; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if($success): ?>
    <div class="alert" style="background: #22c55e; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" style="max-width: 500px;">
    <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
    
    <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px;">Nom de la compétence</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($skill['nom']) ?>" required style="width: 100%; padding: 12px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 20px;">
        <label style="display: block; margin-bottom: 8px;">Catégorie</label>
        <select name="categorie" style="width: 100%; padding: 12px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <option value="Frontend" <?= $skill['categorie'] == 'Frontend' ? 'selected' : '' ?>>Frontend</option>
            <option value="Backend" <?= $skill['categorie'] == 'Backend' ? 'selected' : '' ?>>Backend</option>
            <option value="Design" <?= $skill['categorie'] == 'Design' ? 'selected' : '' ?>>Design / UX</option>
            <option value="Outils" <?= $skill['categorie'] == 'Outils' ? 'selected' : '' ?>>Outils / DevOps</option>
        </select>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
        <div>
            <label style="display: block; margin-bottom: 8px;">Niveau (0 à 100%)</label>
            <input type="number" name="niveau" value="<?= $skill['niveau'] ?>" min="0" max="100" style="width: 100%; padding: 12px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 8px;">Ordre d'affichage</label>
            <input type="number" name="ordre" value="<?= $skill['ordre'] ?>" style="width: 100%; padding: 12px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <button type="submit" style="background: white; color: black; border: none; padding: 12px 24px; font-weight: bold; border-radius: 4px; cursor: pointer;">
        <?= $isEdit ? 'Enregistrer' : 'Créer' ?>
    </button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>