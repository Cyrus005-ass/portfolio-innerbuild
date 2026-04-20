<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? 'Modifier le Projet' : 'Nouveau Projet';
$error = '';
$success = '';

$projet = [
    'titre' => '',
    'description' => '',
    'technologies' => '',
    'lien_live' => '',
    'lien_github' => '',
    'ordre' => 0,
    'annee' => date('Y'),
    'image' => '',
];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM projets WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $projet = [
            'titre' => $existing['titre'] ?? '',
            'description' => $existing['description'] ?? '',
            'technologies' => $existing['technologies'] ?? '',
            'lien_live' => $existing['lien_live'] ?? '',
            'lien_github' => $existing['lien_github'] ?? '',
            'ordre' => $existing['ordre'] ?? 0,
            'annee' => $existing['annee'] ?? date('Y'),
            'image' => $existing['image'] ?? '',
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    $lien_live = trim($_POST['lien_live'] ?? '');
    $lien_github = trim($_POST['lien_github'] ?? '');
    $ordre = (int) ($_POST['ordre'] ?? 0);
    $annee = trim($_POST['annee'] ?? '');

    $imageName = $projet['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $dest = __DIR__ . '/../src/uploads';
            $imageName = handleImageUpload($_FILES['image'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if ($error === '') {
        if ($isEdit) {
            $sql = 'UPDATE projets SET titre=?, description=?, technologies=?, lien_live=?, lien_github=?, ordre=?, annee=?, image=? WHERE id=?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $technologies, $lien_live, $lien_github, $ordre, $annee, $imageName, $id]);
            $success = 'Projet mis a jour avec succes.';
        } else {
            $sql = 'INSERT INTO projets (titre, description, technologies, lien_live, lien_github, ordre, annee, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $technologies, $lien_live, $lien_github, $ordre, $annee, $imageName]);
            header('Location: projets.php');
            exit();
        }

        $projet = [
            'titre' => $titre,
            'description' => $description,
            'technologies' => $technologies,
            'lien_live' => $lien_live,
            'lien_github' => $lien_github,
            'ordre' => $ordre,
            'annee' => $annee,
            'image' => $imageName,
        ];
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="projets.php" class="btn-link">? Retour aux projets</a>
</div>

<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card form-shell">
    <div class="form-grid-2">
        <div class="form-row">
            <label class="form-label">Nom du projet *</label>
            <input class="form-control" type="text" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required>
        </div>
        <div class="form-row">
            <label class="form-label">Annee</label>
            <input class="form-control" type="text" name="annee" value="<?= htmlspecialchars($projet['annee']) ?>">
        </div>
    </div>

    <div class="form-row">
        <label class="form-label">Technologies (separees par des virgules)</label>
        <input class="form-control" type="text" name="technologies" value="<?= htmlspecialchars($projet['technologies']) ?>">
    </div>

    <div class="form-row">
        <label class="form-label">Description du projet</label>
        <textarea class="form-control" name="description" rows="5"><?= htmlspecialchars($projet['description']) ?></textarea>
    </div>

    <div class="form-grid-2">
        <div class="form-row">
            <label class="form-label">Lien du site (live)</label>
            <input class="form-control" type="url" name="lien_live" value="<?= htmlspecialchars($projet['lien_live']) ?>" placeholder="https://...">
        </div>
        <div class="form-row">
            <label class="form-label">Lien du repo (GitHub/GitLab)</label>
            <input class="form-control" type="url" name="lien_github" value="<?= htmlspecialchars($projet['lien_github']) ?>" placeholder="https://...">
        </div>
    </div>

    <div class="form-grid-2">
        <div class="form-row">
            <label class="form-label">Ordre d'affichage</label>
            <input class="form-control" type="number" name="ordre" value="<?= (int) $projet['ordre'] ?>">
        </div>
        <div class="form-row">
            <label class="form-label">Image du projet</label>
            <input class="form-control" type="file" name="image" accept="image/jpeg, image/png, image/webp">
            <?php if (!empty($projet['image'])): ?>
                <div style="margin-top: 8px;">
                    <img src="../src/uploads/<?= htmlspecialchars($projet['image']) ?>" alt="Apercu" class="thumb" style="width: 200px; height: 110px;">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-light"><?= $isEdit ? 'Enregistrer les modifications' : 'Creer le projet' ?></button>
    </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
