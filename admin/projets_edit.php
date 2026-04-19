<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$isEdit = $id > 0;
$pageTitle = $isEdit ? "Modifier le Projet" : "Nouveau Projet";
$error = '';
$success = '';

// Valeurs par défaut
$projet = [
    'titre' => '', 'description' => '', 'technologies' => '', 'lien_live' => '', 'lien_github' => '', 'ordre' => 0, 'annee' => date('Y'), 'image' => ''
];

if ($isEdit) {
    $stmt = $pdo->prepare("SELECT * FROM projets WHERE id = :id");
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
            'image' => $existing['image'] ?? ''
        ];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $technologies = trim($_POST['technologies'] ?? '');
    $lien_live = trim($_POST['lien_live'] ?? '');
    $lien_github = trim($_POST['lien_github'] ?? '');
    $ordre = (int)($_POST['ordre'] ?? 0);
    $annee = trim($_POST['annee'] ?? '');
    
    $imageName = $projet['image']; // par defaut garde l'ancienne
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $dest = __DIR__ . '/../src/uploads';
            $imageName = handleImageUpload($_FILES['image'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    if (empty($error)) {
        if ($isEdit) {
            $sql = "UPDATE projets SET titre=?, description=?, technologies=?, lien_live=?, lien_github=?, ordre=?, annee=?, image=? WHERE id=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $technologies, $lien_live, $lien_github, $ordre, $annee, $imageName, $id]);
            $success = "Projet mis à jour avec succès.";
        } else {
            $sql = "INSERT INTO projets (titre, description, technologies, lien_live, lien_github, ordre, annee, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$titre, $description, $technologies, $lien_live, $lien_github, $ordre, $annee, $imageName]);
            $success = "Nouveau projet créé avec succès.";
            header("Location: projets.php");
            exit();
        }
        $projet = ['titre'=>$titre,'description'=>$description,'technologies'=>$technologies,'lien_live'=>$lien_live,'lien_github'=>$lien_github,'ordre'=>$ordre,'annee'=>$annee,'image'=>$imageName];
    }
}

include __DIR__ . '/includes/header.php';
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1><?= $pageTitle ?></h1>
    <a href="projets.php" style="color: var(--text-muted); text-decoration: none;">&larr; Retour aux projets</a>
</div>

<?php if($error): ?><div style="background: #ff5555; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if($success): ?><div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nom du projet *</label>
            <input type="text" name="titre" value="<?= htmlspecialchars($projet['titre']) ?>" required style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Année</label>
            <input type="text" name="annee" value="<?= htmlspecialchars($projet['annee']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Technologies (Séparées par des virgules)</label>
        <input type="text" name="technologies" value="<?= htmlspecialchars($projet['technologies']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Description du projet</label>
        <textarea name="description" rows="5" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px; font-family: inherit;"><?= htmlspecialchars($projet['description']) ?></textarea>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Lien du Site (Live)</label>
            <input type="url" name="lien_live" value="<?= htmlspecialchars($projet['lien_live']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;" placeholder="https://...">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Lien du Repo (GitHub/GitLab)</label>
            <input type="url" name="lien_github" value="<?= htmlspecialchars($projet['lien_github']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;" placeholder="https://...">
        </div>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Ordre d'affichage (0 = premier)</label>
            <input type="number" name="ordre" value="<?= $projet['ordre'] ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Image du projet (Upload)</label>
            <input type="file" name="image" accept="image/jpeg, image/png, image/webp" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <?php if(!empty($projet['image'])): ?>
                <div style="margin-top: 10px; font-size: 0.85rem; color: #888;">
                    Image actuelle : <br>
                    <img src="../src/uploads/<?= htmlspecialchars($projet['image']) ?>" alt="Aperçu" style="max-width: 200px; max-height: 100px; border-radius: 4px; margin-top: 5px;">
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <button type="submit" style="background: white; color: black; border: none; padding: 12px 24px; font-weight: bold; border-radius: 4px; cursor: pointer; font-size: 1rem;">
        <?= $isEdit ? 'Enregistrer les modifications' : 'Créer le projet' ?>
    </button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
