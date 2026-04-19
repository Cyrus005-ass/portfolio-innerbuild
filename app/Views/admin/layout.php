<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin' ?></title>
    <style>
        :root {
            --bg: #141516; --surface: #1c1d20; --border: #333;
            --text: #fff; --text-muted: #888; --accent: #66b2ff;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg); color: var(--text); }
        a { color: var(--accent); }
        
        .admin-layout { display: flex; min-height: 100vh; }
        .sidebar { width: 240px; background: var(--surface); padding: 20px; border-right: 1px solid var(--border); }
        .sidebar h2 { font-size: 1.2rem; margin-bottom: 30px; font-weight: 300; }
        .sidebar nav a { display: block; padding: 12px 0; color: var(--text-muted); text-decoration: none; border-bottom: 1px solid var(--border); }
        .sidebar nav a:hover, .sidebar nav a.active { color: var(--text); }
        
        .main { flex: 1; padding: 30px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid var(--border); }
        .header h1 { font-weight: 300; font-size: 1.8rem; }
        
        .btn { display: inline-block; padding: 10px 20px; background: var(--text); color: var(--bg); text-decoration: none; border-radius: 4px; font-weight: 600; border: none; cursor: pointer; }
        .btn:hover { opacity: 0.9; }
        .btn-danger { background: #ff5555; color: white; }
        .btn-sm { padding: 6px 12px; font-size: 0.85rem; }
        
        .card { background: var(--surface); padding: 20px; border-radius: 8px; border: 1px solid var(--border); margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; color: var(--text-muted); font-size: 0.9rem; }
        .form-group input, .form-group textarea, .form-group select { width: 100%; padding: 12px; background: var(--bg); color: var(--text); border: 1px solid var(--border); border-radius: 4px; }
        .form-group textarea { min-height: 100px; resize: vertical; }
        
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid var(--border); }
        th { color: var(--text-muted); font-weight: 500; font-size: 0.85rem; }
        
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #2ebd59; color: white; }
        .alert-error { background: #ff5555; color: white; }
        
        .empty { text-align: center; padding: 40px; color: var(--text-muted); }
        .actions { display: flex; gap: 10px; }
        .actions a { color: var(--accent); }
        .actions a.delete { color: #ff5555; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2>InnerBuild</h2>
            <nav>
                <a href="/admin/index.php">Dashboard</a>
                <a href="/admin/profil.php">Mon Profil</a>
                <a href="/admin/skills.php">Compétences</a>
                <a href="/admin/projets.php">Projets</a>
                <a href="/admin/certifications.php">Certifications</a>
                <a href="/admin/messages.php">Messages</a>
                <a href="/admin/login.php?logout=1" style="margin-top: 40px; color: #ff5555;">Déconnexion</a>
            </nav>
        </aside>
        <main class="main">
            <div class="header">
                <h1><?= $pageTitle ?? 'Dashboard' ?></h1>
            </div>
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $e): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($e) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <?php foreach ($success as $s): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($s) ?></div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?= $content ?? '' ?>
</main>
</body>
</html>