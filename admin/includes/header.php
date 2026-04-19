<?php
// S'assurer que le titre est défini
$pageTitle = $pageTitle ?? "Dashboard";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> - Admin Portfolio</title>
    <!-- On utilise une police basique pour l'admin -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #141516;
            --surface: #1c1d20;
            --text: #ffffff;
            --text-muted: #888;
            --primary: #ffffff;
            --border: #333;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text);
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }
        
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            font-weight: 600;
            font-size: 1.2rem;
            text-align: center;
            position: relative;
        }

        .sidebar-toggle {
            display: none;
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 1px solid var(--border);
            background: rgba(255,255,255,.05);
            color: var(--text);
            border-radius: 8px;
            width: 36px;
            height: 32px;
            cursor: pointer;
            font-size: 1.1rem;
            line-height: 1;
        }
        
        .nav-links {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }
        
        .nav-links li a {
            display: block;
            padding: 15px 20px;
            color: var(--text-muted);
            text-decoration: none;
            border-bottom: 1px solid var(--border);
            transition: 0.2s;
        }
        
        .nav-links li a:hover, .nav-links li a.active {
            color: var(--text);
            background-color: rgba(255,255,255,0.05);
        }
        
        .logout {
            padding: 20px;
            text-align: center;
            border-top: 1px solid var(--border);
        }
        
        .logout a {
            color: #ff5555;
            text-decoration: none;
        }
        
        /* Main Content */
        .main-content {
            flex-grow: 1;
            padding: 40px;
            overflow-y: auto;
        }
        
        /* Utilities */
        h1 { margin-top: 0; font-weight: 300; }
        .card { background: var(--surface); padding: 25px; border-radius: 8px; margin-bottom: 20px; border: 1px solid var(--border); }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }

        @media (max-width: 980px) {
            body {
                display: block;
            }

            .sidebar {
                width: 100%;
                border-right: 0;
                border-bottom: 1px solid var(--border);
                transform: translateY(0);
            }

            .sidebar-header {
                text-align: left;
                padding-right: 56px;
            }

            .sidebar-toggle {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .nav-links {
                max-height: 0;
                overflow: hidden;
                transition: max-height .25s ease;
            }

            .sidebar.nav-open .nav-links {
                max-height: 70vh;
                overflow-y: auto;
            }

            .logout {
                display: none;
            }

            .sidebar.nav-open .logout {
                display: block;
            }

            .main-content {
                padding: 20px;
            }

            .grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 560px) {
            .main-content {
                padding: 14px;
            }

            .card {
                padding: 16px;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="adminSidebar">
        <div class="sidebar-header">
            Admin Panel
            <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-expanded="false" aria-controls="adminNav">☰</button>
        </div>
        <ul class="nav-links" id="adminNav">
            <li><a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : '' ?>>Tableau de bord</a></li>
            <li><a href="profil.php" <?= basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'class="active"' : '' ?>>Mon Profil</a></li>
            <li><a href="projets.php" <?= basename($_SERVER['PHP_SELF']) == 'projets.php' ? 'class="active"' : '' ?>>Projets</a></li>
            <li><a href="skills.php" <?= basename($_SERVER['PHP_SELF']) == 'skills.php' ? 'class="active"' : '' ?>>Compétences</a></li>
            <li><a href="certifications.php" <?= basename($_SERVER['PHP_SELF']) == 'certifications.php' ? 'class="active"' : '' ?>>Certifications</a></li>
            <li><a href="messages.php" <?= basename($_SERVER['PHP_SELF']) == 'messages.php' ? 'class="active"' : '' ?>>Messages</a></li>
            <li><a href="../public/index.php" target="_blank">Voir le site ↗</a></li>
        </ul>
        <div class="logout">
            <a href="logout.php">Déconnexion</a>
        </div>
    </aside>

    <main class="main-content">
