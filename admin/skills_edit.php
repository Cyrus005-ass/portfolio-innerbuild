<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? 'Modifier la Competence' : 'Nouvelle Competence';
$error = '';
$success = '';

$skill = ['nom' => '', 'categorie' => 'Frontend', 'niveau' => 80, 'ordre' => 0];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM skills WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $skill = $existing;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCsrfToken($_POST['csrf_token'] ?? '')) {
        $error = 'Token CSRF invalide.';
    } else {
        $nom = trim($_POST['nom'] ?? '');
        $categorie = trim($_POST['categorie'] ?? '');
        $niveau = max(0, min(100, (int) ($_POST['niveau'] ?? 80)));
        $ordre = (int) ($_POST['ordre'] ?? 0);

        if ($nom === '') {
            $error = 'Le nom est obligatoire.';
        } else {
            if ($isEdit) {
                $stmt = $pdo->prepare('UPDATE skills SET nom=?, categorie=?, niveau=?, ordre=? WHERE id=?');
                $stmt->execute([$nom, $categorie, $niveau, $ordre, $id]);
                $success = 'Competence mise a jour.';
            } else {
                $stmt = $pdo->prepare('INSERT INTO skills (nom, categorie, niveau, ordre) VALUES (?, ?, ?, ?)');
                $stmt->execute([$nom, $categorie, $niveau, $ordre]);
                header('Location: skills.php');
                exit();
            }

            $skill = ['nom' => $nom, 'categorie' => $categorie, 'niveau' => $niveau, 'ordre' => $ordre];
        }
    }
}

$csrf = generateCsrfToken();
include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="skills.php" class="btn-link">? Retour</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" class="card form-shell" style="max-width: 620px;">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf) ?>">

    <div class="form-row">
        <label class="form-label">Nom de la competence</label>
        <input class="form-control" type="text" name="nom" value="<?= htmlspecialchars($skill['nom']) ?>" required>
    </div>

    <div class="form-row">
        <label class="form-label">Categorie</label>
        <select class="form-control" name="categorie">
            <option value="Frontend" <?= $skill['categorie'] === 'Frontend' ? 'selected' : '' ?>>Frontend</option>
            <option value="Backend" <?= $skill['categorie'] === 'Backend' ? 'selected' : '' ?>>Backend</option>
            <option value="Design" <?= $skill['categorie'] === 'Design' ? 'selected' : '' ?>>Design / UX</option>
            <option value="Outils" <?= $skill['categorie'] === 'Outils' ? 'selected' : '' ?>>Outils / DevOps</option>
        </select>
    </div>

    <div class="form-grid-2">
        <div class="form-row">
            <label class="form-label">Niveau (0 a 100%)</label>
            <input class="form-control" type="number" name="niveau" min="0" max="100" value="<?= (int) $skill['niveau'] ?>">
        </div>
        <div class="form-row">
            <label class="form-label">Ordre d'affichage</label>
            <input class="form-control" type="number" name="ordre" value="<?= (int) $skill['ordre'] ?>">
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-light"><?= $isEdit ? 'Enregistrer' : 'Creer' ?></button>
    </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
