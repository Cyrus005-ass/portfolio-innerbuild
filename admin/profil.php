<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$pageTitle = "Mon Profil";
$error = '';
$success = '';

// Récupération du profil (ID 1 uniquement désormais)
$stmt = $pdo->prepare("SELECT * FROM profil WHERE id = 1 LIMIT 1");
$stmt->execute();
$profil = $stmt->fetch();

// Migration légère: ajoute la colonne de thème si absente
try {
    $colCheck = $pdo->query("SHOW COLUMNS FROM profil LIKE 'site_theme'");
    $hasSiteTheme = (bool) $colCheck->fetch();
    if (!$hasSiteTheme) {
        $pdo->exec("ALTER TABLE profil ADD COLUMN site_theme VARCHAR(50) DEFAULT 'midnight' AFTER titre");
        $pdo->exec("UPDATE profil SET site_theme = 'midnight' WHERE site_theme IS NULL OR site_theme = ''");
    }
} catch (Exception $e) {
    // On ne bloque pas l'admin si la migration échoue
}

if (!$profil) {
    die("Erreur : Aucun profil trouvé (ID 1).");
}

if (empty($profil['site_theme'])) {
    $profil['site_theme'] = 'midnight';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $site_theme = trim($_POST['site_theme'] ?? 'midnight');
    $bio = trim($_POST['bio'] ?? '');
    $email_contact = trim($_POST['email_contact'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $github = trim($_POST['github'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');
    $localisation = trim($_POST['localisation'] ?? 'Bénin');
    
    $avatarName = $profil['avatar'] ?? '';
    $cvName = $profil['cv_url'] ?? '';
    
    $dest = __DIR__ . '/../src/uploads';

    // Upload avatar
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $avatarName = handleImageUpload($_FILES['photo'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    // Upload CV
    if (empty($error) && isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $cvName = handleFileUpload($_FILES['cv_file'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    
    if (empty($error)) {
        $sql = "UPDATE profil SET nom=?, titre=?, site_theme=?, bio=?, email_contact=?, telephone=?, github=?, linkedin=?, instagram=?, avatar=?, localisation=?, cv_url=? WHERE id=1";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nom, $titre, $site_theme, $bio, $email_contact, $telephone, $github, $linkedin, $instagram, $avatarName, $localisation, $cvName])) {
            $success = "Profil mis à jour avec succès.";
            // Refresh local object for UI
            $profil['nom'] = $nom; $profil['titre'] = $titre; $profil['site_theme'] = $site_theme;
            $profil['bio'] = $bio; $profil['email_contact'] = $email_contact; $profil['telephone'] = $telephone;
            $profil['github'] = $github; $profil['linkedin'] = $linkedin; $profil['instagram'] = $instagram;
            $profil['avatar'] = $avatarName; $profil['localisation'] = $localisation; $profil['cv_url'] = $cvName;
        } else {
            $error = "Une erreur est survenue lors de la mise à jour.";
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<h1>Gestion du Profil</h1>

<?php if($error): ?><div style="background: #ff5555; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div><?php endif; ?>
<?php if($success): ?><div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div><?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nom complet *</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>" required style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Localisation (ex: Bénin)</label>
            <input type="text" name="localisation" value="<?= htmlspecialchars($profil['localisation'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Titre Professionnel</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($profil['titre'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Thème couleur du site</label>
        <select name="site_theme" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <option value="midnight" <?= (($profil['site_theme'] ?? 'midnight') === 'midnight') ? 'selected' : '' ?>>Midnight (Bleu sombre)</option>
            <option value="ocean" <?= (($profil['site_theme'] ?? 'midnight') === 'ocean') ? 'selected' : '' ?>>Ocean (Bleu cyan)</option>
            <option value="sunset" <?= (($profil['site_theme'] ?? 'midnight') === 'sunset') ? 'selected' : '' ?>>Sunset (Orange doux)</option>
            <option value="forest" <?= (($profil['site_theme'] ?? 'midnight') === 'forest') ? 'selected' : '' ?>>Forest (Vert profond)</option>
        </select>
        <small style="display:block; margin-top:6px; color:#9aa0aa;">Ce choix modifie les couleurs globales du site public.</small>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Biographie (Bio)</label>
        <textarea name="bio" rows="5" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px; font-family: inherit;"><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Email de contact</label>
            <input type="email" name="email_contact" value="<?= htmlspecialchars($profil['email_contact'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Téléphone</label>
            <input type="text" name="telephone" value="<?= htmlspecialchars($profil['telephone'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">GitHub URL</label>
            <input type="url" name="github" value="<?= htmlspecialchars($profil['github'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">LinkedIn URL</label>
            <input type="url" name="linkedin" value="<?= htmlspecialchars($profil['linkedin'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Instagram URL</label>
            <input type="url" name="instagram" value="<?= htmlspecialchars($profil['instagram'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
        <div>
            <label style="display: block; margin-bottom: 5px;">Avatar / Photo de profil (Upload)</label>
            <input type="file" name="photo" accept="image/jpeg, image/png, image/webp" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <?php if(!empty($profil['avatar'])): ?>
                <div style="margin-top: 10px;">
                    <p style="font-size: 0.8rem; color: #888; margin-bottom: 5px;">Aperçu actuel :</p>
                    <img src="../src/uploads/<?= htmlspecialchars($profil['avatar']) ?>" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid var(--border);">
                </div>
            <?php endif; ?>
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Curriculum Vitae (PDF/DOCX)</label>
            <input type="file" name="cv_file" accept=".pdf,.doc,.docx" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <?php if(!empty($profil['cv_url'])): ?>
                <div style="margin-top: 10px;">
                    <p style="font-size: 0.8rem; color: #888; margin-bottom: 5px;">Fichier actuel :</p>
                    <a href="../src/uploads/<?= htmlspecialchars($profil['cv_url']) ?>" target="_blank" style="color: var(--accent); text-decoration: underline;"><?= htmlspecialchars($profil['cv_url']) ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" style="background: white; color: black; border: none; padding: 12px 30px; font-weight: bold; border-radius: 4px; cursor: pointer; font-size: 1rem;">
        Enregistrer les modifications
    </button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
    $allowedThemes = ['midnight', 'ocean', 'sunset', 'forest'];
    if (!in_array($site_theme, $allowedThemes, true)) {
        $site_theme = 'midnight';
    }
