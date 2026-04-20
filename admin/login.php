<?php
require_once __DIR__ . '/../src/config/config.php';
require_once __DIR__ . '/../src/includes/db.php';
require_once __DIR__ . '/../src/includes/security.php';

if (isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $csrf_token = $_POST['csrf_token'] ?? '';

    if (!verifyCsrfToken($csrf_token)) {
        $error = "Token de sÃ©curitÃ© invalide.";
    } else {
        $stmt = $pdo->prepare("SELECT id, email, mot_de_passe_hash, role FROM admins WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['mot_de_passe_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['LAST_ACTIVITY'] = time();

            $stmt = $pdo->prepare("UPDATE admins SET last_login = NOW() WHERE id = :id");
            $stmt->execute(['id' => $admin['id']]);

            header("Location: index.php");
            exit();
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    }
}

$csrf_token = generateCsrfToken();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Admin Portfolio</title>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #141516; color: white; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #1c1d20; padding: 40px; border-radius: 8px; width: 100%; max-width: 400px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h2 { margin-top: 0; margin-bottom: 30px; font-weight: 300; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-size: 0.9rem; color: #aaa; }
        input { width: 100%; padding: 12px; border: 1px solid #333; background: #141516; color: white; border-radius: 4px; box-sizing: border-box; }
        input:focus { outline: none; border-color: #555; }
        .btn { display: block; width: 100%; padding: 12px; background: white; color: black; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #ccc; }
        .error { color: #ff5555; font-size: 0.9rem; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion Admin</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <div class="form-group">
                <label>Adresse Email</label>
                <input type="email" name="email" autocomplete="username" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" autocomplete="current-password" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>
</body>
</html>
