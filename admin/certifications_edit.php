<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? 'Modifier la Certification' : 'Nouvelle Certification';
$error = '';
$success = '';

$cert = ['nom' => '', 'organisme' => '', 'date_obtention' => '', 'lien_verification' => '', 'ordre' => 0, 'photo' => ''];

if ($isEdit) {
    $stmt = $pdo->prepare('SELECT * FROM certifications WHERE id = ?');
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) {
        $cert = $existing;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $organisme = trim($_POST['organisme'] ?? '');
    $date_obtention = trim($_POST['date_obtention'] ?? '');
    $lien_verification = trim($_POST['lien_verification'] ?? '');
    $ordre = (int) ($_POST['ordre'] ?? 0);

    $photoName = $cert['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $dest = __DIR__ . '/../src/uploads';
            $photoName = handleImageUpload($_FILES['photo'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if ($error === '') {
        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE certifications SET nom=?, organisme=?, date_obtention=?, lien_verification=?, ordre=?, photo=? WHERE id=?');
            $stmt->execute([$nom, $organisme, $date_obtention === '' ? null : $date_obtention, $lien_verification, $ordre, $photoName, $id]);
            $success = 'Certification mise a jour.';
        } else {
            $stmt = $pdo->prepare('INSERT INTO certifications (nom, organisme, date_obtention, lien_verification, ordre, photo) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([$nom, $organisme, $date_obtention === '' ? null : $date_obtention, $lien_verification, $ordre, $photoName]);
            header('Location: certifications.php');
            exit();
        }

        $cert = [
            'nom' => $nom,
            'organisme' => $organisme,
            'date_obtention' => $date_obtention,
            'lien_verification' => $lien_verification,
            'ordre' => $ordre,
            'photo' => $photoName,
        ];
    }
}

include __DIR__ . '/includes/header.php';
?>

<div class="page-head">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>
    <a href="certifications.php" class="btn-link">? Retour</a>
</div>

<?php if ($error): ?><div class="alert alert-error"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card form-shell">
    <div class="form-row">
        <label class="form-label">Nom de la certification *</label>
        <input class="form-control" type="text" name="nom" value="<?= htmlspecialchars($cert['nom']) ?>" required>
    </div>

    <div class="form-row">
        <label class="form-label">Organisme delivreur *</label>
        <input class="form-control" type="text" name="organisme" value="<?= htmlspecialchars($cert['organisme']) ?>" required>
    </div>

    <div class="form-grid-2">
        <div class="form-row">
            <label class="form-label">Date d'obtention</label>
            <input class="form-control" type="date" name="date_obtention" value="<?= htmlspecialchars((string) $cert['date_obtention']) ?>">
        </div>
        <div class="form-row">
            <label class="form-label">Ordre d'affichage</label>
            <input class="form-control" type="number" name="ordre" value="<?= (int) $cert['ordre'] ?>">
        </div>
    </div>

    <div class="form-row">
        <label class="form-label">URL de verification</label>
        <input class="form-control" type="url" name="lien_verification" value="<?= htmlspecialchars($cert['lien_verification']) ?>" placeholder="https://...">
    </div>

    <div class="form-row">
        <label class="form-label">Badge / Logo (upload)</label>
        <input class="form-control" type="file" name="photo" accept="image/jpeg, image/png, image/webp">
        <?php if (!empty($cert['photo'])): ?>
            <div style="margin-top: 10px;"><img src="../src/uploads/<?= htmlspecialchars($cert['photo']) ?>" alt="Apercu" class="thumb-round" style="width:80px;height:80px;"></div>
        <?php endif; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-light"><?= $isEdit ? 'Enregistrer' : 'Creer' ?></button>
    </div>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
