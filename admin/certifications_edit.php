<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? "Modifier la Certification" : "Nouvelle Certification";
$error = '';
$success = '';

$cert = ['nom' => '', 'organisme' => '', 'date_obtention' => '', 'lien_verification' => '', 'ordre' => 0, 'photo' => ''];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM certifications WHERE id = ?");
    $stmt->execute([$id]);
    $existing = $stmt->fetch();
    if ($existing) $cert = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $organisme = trim($_POST['organisme'] ?? '');
    $date_obtention = trim($_POST['date_obtention'] ?? '');
    $lien_verification = trim($_POST['lien_verification'] ?? '');
    $ordre = (int)($_POST['ordre'] ?? 0);
    
    $photoName = $cert['photo'];
    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $dest = __DIR__ . '/../src/uploads';
            $photoName = handleImageUpload($_FILES['photo'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    if (empty($error)) {
        if ($isEdit) {
            $stmt = $pdo->prepare("UPDATE certifications SET nom=?, organisme=?, date_obtention=?, lien_verification=?, ordre=?, photo=? WHERE id=?");
            $stmt->execute([$nom, $organisme, empty($date_obtention) ? null : $date_obtention, $lien_verification, $ordre, $photoName, $id]);
            $success = "Certification mise à jour.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO certifications (nom, organisme, date_obtention, lien_verification, ordre, photo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $organisme, empty($date_obtention) ? null : $date_obtention, $lien_verification, $ordre, $photoName]);
            header("Location: certifications.php");
            exit();
        }
        $cert = ['nom'=>$nom,'organisme'=>$organisme,'date_obtention'=>$date_obtention,'lien_verification'=>$lien_verification,'ordre'=>$ordre,'photo'=>$photoName];
    }
}

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1><?= $pageTitle ?></h1>
    <a href="certifications.php" style="color: var(--text-muted); text-decoration: none;">&larr; Retour</a>
</div>

<?php if($error): ?><div style="background: #ff5555; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if($success): ?><div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card">
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Nom de la certification *</label>
        <input type="text" name="nom" value="<?= htmlspecialchars($cert['nom']) ?>" required style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Organisme délivreur *</label>
        <input type="text" name="organisme" value="<?= htmlspecialchars($cert['organisme']) ?>" required style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Date d'obtention</label>
            <input type="date" name="date_obtention" value="<?= $cert['date_obtention'] ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Ordre d'affichage</label>
            <input type="number" name="ordre" value="<?= $cert['ordre'] ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">URL de vérification</label>
        <input type="url" name="lien_verification" value="<?= htmlspecialchars($cert['lien_verification']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;" placeholder="https://...">
    </div>

    <div style="margin-bottom: 25px;">
        <label style="display: block; margin-bottom: 5px;">Badge / Logo (Upload)</label>
        <input type="file" name="photo" accept="image/jpeg, image/png, image/webp" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        <?php if(!empty($cert['photo'])): ?>
            <div style="margin-top: 10px;">
                <img src="../src/uploads/<?= htmlspecialchars($cert['photo']) ?>" alt="Aperçu" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" style="background: white; color: black; border: none; padding: 12px 24px; font-weight: bold; border-radius: 4px; cursor: pointer;">
        <?= $isEdit ? 'Enregistrer' : 'Créer' ?>
    </button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
