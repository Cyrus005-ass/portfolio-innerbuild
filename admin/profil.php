<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/upload.php';

$pageTitle = 'Mon Profil';
$error = '';
$success = '';

function ensureProfilStyleColumns(PDO $pdo): void
{
    $columns = [
        'site_theme' => "ALTER TABLE profil ADD COLUMN site_theme VARCHAR(50) DEFAULT 'midnight' AFTER titre",
        'site_font' => "ALTER TABLE profil ADD COLUMN site_font VARCHAR(40) DEFAULT 'outfit' AFTER site_theme",
        'title_scale' => "ALTER TABLE profil ADD COLUMN title_scale DECIMAL(3,2) DEFAULT 1.00 AFTER site_font",
        'text_scale' => "ALTER TABLE profil ADD COLUMN text_scale DECIMAL(3,2) DEFAULT 1.00 AFTER title_scale",
        'accent_color' => "ALTER TABLE profil ADD COLUMN accent_color VARCHAR(7) DEFAULT '#8eb8ff' AFTER text_scale",
        'accent_soft_color' => "ALTER TABLE profil ADD COLUMN accent_soft_color VARCHAR(7) DEFAULT '#c5dcff' AFTER accent_color",
        'bg_color' => "ALTER TABLE profil ADD COLUMN bg_color VARCHAR(7) DEFAULT '#0b0f16' AFTER accent_soft_color",
        'surface_color' => "ALTER TABLE profil ADD COLUMN surface_color VARCHAR(7) DEFAULT '#131a25' AFTER bg_color",
    ];

    foreach ($columns as $name => $sql) {
        $check = $pdo->query("SHOW COLUMNS FROM profil LIKE " . $pdo->quote($name));
        if (!$check || !$check->fetch()) {
            $pdo->exec($sql);
        }
    }
}

function sanitizeHexColor(string $value, string $fallback): string
{
    $value = strtoupper(trim($value));
    if (!preg_match('/^#[0-9A-F]{6}$/', $value)) {
        return $fallback;
    }

    return $value;
}

try {
    ensureProfilStyleColumns($pdo);
} catch (Exception $e) {
}

$stmt = $pdo->prepare('SELECT * FROM profil WHERE id = 1 LIMIT 1');
$stmt->execute();
$profil = $stmt->fetch();

if (!$profil) {
    die('Erreur : Aucun profil trouve (ID 1).');
}

$profil['site_theme'] = $profil['site_theme'] ?? 'midnight';
$profil['site_font'] = $profil['site_font'] ?? 'outfit';
$profil['title_scale'] = (string) ($profil['title_scale'] ?? '1.00');
$profil['text_scale'] = (string) ($profil['text_scale'] ?? '1.00');
$profil['accent_color'] = $profil['accent_color'] ?? '#8eb8ff';
$profil['accent_soft_color'] = $profil['accent_soft_color'] ?? '#c5dcff';
$profil['bg_color'] = $profil['bg_color'] ?? '#0b0f16';
$profil['surface_color'] = $profil['surface_color'] ?? '#131a25';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $titre = trim($_POST['titre'] ?? '');
    $siteTheme = trim($_POST['site_theme'] ?? 'midnight');
    $siteFont = trim($_POST['site_font'] ?? 'outfit');
    $titleScale = (float) ($_POST['title_scale'] ?? 1);
    $textScale = (float) ($_POST['text_scale'] ?? 1);
    $accentColor = sanitizeHexColor($_POST['accent_color'] ?? '#8eb8ff', '#8EB8FF');
    $accentSoftColor = sanitizeHexColor($_POST['accent_soft_color'] ?? '#c5dcff', '#C5DCFF');
    $bgColor = sanitizeHexColor($_POST['bg_color'] ?? '#0b0f16', '#0B0F16');
    $surfaceColor = sanitizeHexColor($_POST['surface_color'] ?? '#131a25', '#131A25');

    $bio = trim($_POST['bio'] ?? '');
    $emailContact = trim($_POST['email_contact'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $github = trim($_POST['github'] ?? '');
    $linkedin = trim($_POST['linkedin'] ?? '');
    $instagram = trim($_POST['instagram'] ?? '');
    $localisation = trim($_POST['localisation'] ?? 'Benin');

    $allowedThemes = ['midnight', 'ocean', 'sunset', 'forest'];
    if (!in_array($siteTheme, $allowedThemes, true)) {
        $siteTheme = 'midnight';
    }

    $allowedFonts = ['outfit', 'syne', 'sora', 'manrope'];
    if (!in_array($siteFont, $allowedFonts, true)) {
        $siteFont = 'outfit';
    }

    $titleScale = max(0.8, min(1.4, $titleScale));
    $textScale = max(0.9, min(1.2, $textScale));

    $avatarName = $profil['avatar'] ?? '';
    $cvName = $profil['cv_url'] ?? '';
    $dest = __DIR__ . '/../src/uploads';

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $avatarName = handleImageUpload($_FILES['photo'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (empty($error) && isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $cvName = handleFileUpload($_FILES['cv_file'], $dest);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }

    if (empty($error)) {
        $sql = 'UPDATE profil SET nom=?, titre=?, site_theme=?, site_font=?, title_scale=?, text_scale=?, accent_color=?, accent_soft_color=?, bg_color=?, surface_color=?, bio=?, email_contact=?, telephone=?, github=?, linkedin=?, instagram=?, avatar=?, localisation=?, cv_url=? WHERE id=1';
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            $nom,
            $titre,
            $siteTheme,
            $siteFont,
            $titleScale,
            $textScale,
            $accentColor,
            $accentSoftColor,
            $bgColor,
            $surfaceColor,
            $bio,
            $emailContact,
            $telephone,
            $github,
            $linkedin,
            $instagram,
            $avatarName,
            $localisation,
            $cvName,
        ]);

        if ($ok) {
            $success = 'Profil mis a jour avec succes.';
            $profil = array_merge($profil, [
                'nom' => $nom,
                'titre' => $titre,
                'site_theme' => $siteTheme,
                'site_font' => $siteFont,
                'title_scale' => (string) $titleScale,
                'text_scale' => (string) $textScale,
                'accent_color' => $accentColor,
                'accent_soft_color' => $accentSoftColor,
                'bg_color' => $bgColor,
                'surface_color' => $surfaceColor,
                'bio' => $bio,
                'email_contact' => $emailContact,
                'telephone' => $telephone,
                'github' => $github,
                'linkedin' => $linkedin,
                'instagram' => $instagram,
                'avatar' => $avatarName,
                'localisation' => $localisation,
                'cv_url' => $cvName,
            ]);
        } else {
            $error = 'Une erreur est survenue lors de la mise a jour.';
        }
    }
}

include __DIR__ . '/includes/header.php';
?>

<h1>Gestion du Profil</h1>

<?php if ($error): ?>
    <div style="background: #ff5555; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<?php if ($success): ?>
    <div style="background: #2ebd59; color: white; padding: 15px; border-radius: 4px; margin-bottom: 20px;"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Nom complet *</label>
            <input type="text" name="nom" value="<?= htmlspecialchars($profil['nom'] ?? '') ?>" required style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Localisation</label>
            <input type="text" name="localisation" value="<?= htmlspecialchars($profil['localisation'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Titre Professionnel</label>
        <input type="text" name="titre" value="<?= htmlspecialchars($profil['titre'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 5px;">Theme global</label>
            <select name="site_theme" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
                <?php foreach (['midnight' => 'Midnight', 'ocean' => 'Ocean', 'sunset' => 'Sunset', 'forest' => 'Forest'] as $v => $label): ?>
                    <option value="<?= $v ?>" <?= (($profil['site_theme'] ?? 'midnight') === $v) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Police du site</label>
            <select name="site_font" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
                <?php foreach (['outfit' => 'Outfit', 'syne' => 'Syne', 'sora' => 'Sora', 'manrope' => 'Manrope'] as $v => $label): ?>
                    <option value="<?= $v ?>" <?= (($profil['site_font'] ?? 'outfit') === $v) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 5px;">Taille titres (0.8 - 1.4)</label>
            <input type="number" step="0.05" min="0.8" max="1.4" name="title_scale" value="<?= htmlspecialchars((string) $profil['title_scale']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Taille texte (0.9 - 1.2)</label>
            <input type="number" step="0.05" min="0.9" max="1.2" name="text_scale" value="<?= htmlspecialchars((string) $profil['text_scale']) ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
    </div>

    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 15px;">
        <div>
            <label style="display: block; margin-bottom: 5px;">Accent</label>
            <input type="color" name="accent_color" value="<?= htmlspecialchars($profil['accent_color'] ?? '#8eb8ff') ?>" style="width:100%;height:42px;background:var(--bg);border:1px solid var(--border);border-radius:4px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Accent doux</label>
            <input type="color" name="accent_soft_color" value="<?= htmlspecialchars($profil['accent_soft_color'] ?? '#c5dcff') ?>" style="width:100%;height:42px;background:var(--bg);border:1px solid var(--border);border-radius:4px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Fond</label>
            <input type="color" name="bg_color" value="<?= htmlspecialchars($profil['bg_color'] ?? '#0b0f16') ?>" style="width:100%;height:42px;background:var(--bg);border:1px solid var(--border);border-radius:4px;">
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Surface</label>
            <input type="color" name="surface_color" value="<?= htmlspecialchars($profil['surface_color'] ?? '#131a25') ?>" style="width:100%;height:42px;background:var(--bg);border:1px solid var(--border);border-radius:4px;">
        </div>
    </div>

    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 5px;">Biographie</label>
        <textarea name="bio" rows="5" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px; font-family: inherit;"><?= htmlspecialchars($profil['bio'] ?? '') ?></textarea>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Email de contact</label>
            <input type="email" name="email_contact" value="<?= htmlspecialchars($profil['email_contact'] ?? '') ?>" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 5px;">Telephone</label>
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
            <label style="display: block; margin-bottom: 5px;">Avatar / Photo de profil</label>
            <input type="file" name="photo" accept="image/jpeg, image/png, image/webp" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <small style="display:block; margin-top:6px; color:#9aa0aa;">Image optimisee automatiquement.</small>
            <?php if (!empty($profil['avatar'])): ?>
                <div style="margin-top: 10px;">
                    <img src="../src/uploads/<?= htmlspecialchars($profil['avatar']) ?>" alt="Avatar" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 2px solid var(--border);">
                </div>
            <?php endif; ?>
        </div>
        <div>
            <label style="display: block; margin-bottom: 5px;">Curriculum Vitae (PDF/DOCX)</label>
            <input type="file" name="cv_file" accept=".pdf,.doc,.docx" style="width: 100%; padding: 10px; background: var(--bg); color: white; border: 1px solid var(--border); border-radius: 4px;">
            <?php if (!empty($profil['cv_url'])): ?>
                <div style="margin-top: 10px;">
                    <a href="../src/uploads/<?= htmlspecialchars($profil['cv_url']) ?>" target="_blank" style="color: var(--primary); text-decoration: underline;"><?= htmlspecialchars($profil['cv_url']) ?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <button type="submit" style="background: white; color: black; border: none; padding: 12px 30px; font-weight: bold; border-radius: 4px; cursor: pointer; font-size: 1rem;">
        Enregistrer les modifications
    </button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
