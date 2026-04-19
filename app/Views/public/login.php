<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - InnerBuild</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: #141516; color: #fff; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-box { background: #1c1d20; padding: 40px; border-radius: 8px; width: 100%; max-width: 380px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h2 { margin-bottom: 30px; font-weight: 300; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #888; font-size: 0.9rem; }
        input { width: 100%; padding: 12px; background: #141516; color: #fff; border: 1px solid #333; border-radius: 4px; }
        input:focus { outline: none; border-color: #555; }
        .btn { width: 100%; padding: 12px; background: #fff; color: #000; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn:hover { background: #eee; }
        .error { color: #ff5555; font-size: 0.9rem; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Connexion Admin</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Mot de passe</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Se connecter</button>
        </form>
    </div>
</body>
</html>