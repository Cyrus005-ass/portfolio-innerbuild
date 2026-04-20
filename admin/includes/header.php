<?php
$pageTitle = $pageTitle ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - Admin Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #111214;
            --surface: #1a1c20;
            --surface-soft: #20242b;
            --text: #f5f7ff;
            --text-muted: #9aa4b7;
            --border: #303745;
            --primary: #69a7ff;
            --danger: #ff5f5f;
            --success: #2ebd59;
            --radius: 10px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
        }

        a { color: inherit; }

        .sidebar {
            width: 260px;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 1.1rem;
            font-weight: 600;
            position: relative;
        }

        .sidebar-toggle {
            display: none;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.04);
            color: var(--text);
            border-radius: 8px;
            width: 36px;
            height: 32px;
            cursor: pointer;
        }

        .nav-links {
            margin: 0;
            padding: 0;
            list-style: none;
            flex: 1;
        }

        .nav-links a {
            display: block;
            padding: 13px 20px;
            text-decoration: none;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            transition: 0.2s ease;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: var(--text);
            background: rgba(255, 255, 255, 0.05);
        }

        .logout {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
        }

        .logout a {
            text-decoration: none;
            color: var(--danger);
        }

        .main-content {
            flex: 1;
            padding: 28px;
            overflow-y: auto;
        }

        h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 400;
            letter-spacing: -0.02em;
        }

        h2,
        h3,
        p {
            margin-top: 0;
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            margin-bottom: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
        }

        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
            flex-wrap: wrap;
        }

        .btn {
            border: 1px solid transparent;
            border-radius: 8px;
            padding: 10px 14px;
            font-weight: 600;
            font-size: 0.93rem;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-primary { background: var(--primary); color: #071326; }
        .btn-light { background: #f4f7ff; color: #121722; }
        .btn-danger { color: var(--danger); background: transparent; border-color: var(--danger); }
        .btn-link { color: var(--text-muted); text-decoration: none; }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid transparent;
        }

        .alert-success { background: rgba(46, 189, 89, 0.18); border-color: rgba(46, 189, 89, 0.45); color: #c9f5d7; }
        .alert-error { background: rgba(255, 95, 95, 0.18); border-color: rgba(255, 95, 95, 0.45); color: #ffd3d3; }

        .muted { color: var(--text-muted); }
        .actions-inline { display: inline-flex; align-items: center; gap: 10px; }
        .text-link { color: #8ec0ff; text-decoration: none; }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            margin: 8px 0 10px;
        }

        .table-wrap {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 760px;
        }

        .data-table th,
        .data-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .data-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .thumb {
            width: 84px;
            height: 54px;
            border-radius: 6px;
            object-fit: cover;
            background: var(--surface-soft);
            border: 1px solid var(--border);
        }

        .thumb-round {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            object-fit: cover;
            background: var(--surface-soft);
            border: 1px solid var(--border);
        }

        .form-shell { max-width: 920px; }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
        .form-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .form-row { margin-bottom: 14px; }
        .form-label { display: block; margin-bottom: 6px; font-weight: 500; }

        .form-control {
            width: 100%;
            padding: 10px 11px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: #11151d;
            color: var(--text);
            font-family: inherit;
            font-size: 0.95rem;
        }

        textarea.form-control { min-height: 110px; resize: vertical; }
        .form-actions { margin-top: 8px; display: flex; gap: 10px; flex-wrap: wrap; }

        .message-card {
            border-left: 4px solid var(--border);
        }

        .message-card.unread {
            border-left-color: var(--danger);
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .message-content {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
            white-space: pre-wrap;
            line-height: 1.55;
        }

        @media (max-width: 980px) {
            body { display: block; }
            .sidebar {
                width: 100%;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }
            .sidebar-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            .nav-links {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.25s ease;
            }
            .sidebar.nav-open .nav-links {
                max-height: 70vh;
                overflow-y: auto;
            }
            .logout { display: none; }
            .sidebar.nav-open .logout { display: block; }
            .main-content { padding: 18px; }
            .form-grid-2,
            .form-grid-3,
            .form-grid-4 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-header">
        Admin Panel
        <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-expanded="false" aria-controls="adminNav">&#9776;</button>
    </div>
    <ul class="nav-links" id="adminNav">
        <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'class="active"' : '' ?>>Tableau de bord</a></li>
        <li><a href="profil.php" <?= basename($_SERVER['PHP_SELF']) === 'profil.php' ? 'class="active"' : '' ?>>Mon Profil</a></li>
        <li><a href="projets.php" <?= basename($_SERVER['PHP_SELF']) === 'projets.php' ? 'class="active"' : '' ?>>Projets</a></li>
        <li><a href="skills.php" <?= basename($_SERVER['PHP_SELF']) === 'skills.php' ? 'class="active"' : '' ?>>Competences</a></li>
        <li><a href="certifications.php" <?= basename($_SERVER['PHP_SELF']) === 'certifications.php' ? 'class="active"' : '' ?>>Certifications</a></li>
        <li><a href="messages.php" <?= basename($_SERVER['PHP_SELF']) === 'messages.php' ? 'class="active"' : '' ?>>Messages</a></li>
        <li><a href="../public/index.php" target="_blank" rel="noopener noreferrer">Voir le site -></a></li>
    </ul>
    <div class="logout">
        <a href="logout.php">Deconnexion</a>
    </div>
</aside>

<main class="main-content">

