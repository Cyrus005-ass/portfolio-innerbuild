# InnerBuild Portfolio

Portfolio PHP + espace admin (projets, competences, certifications, profil, messages), optimisé pour local (WAMP) et InfinityFree.

## Structure utilisee

- `index.php` : point d'entree racine
- `public/` : point d'entree public du site
- `templates/` : sections du portfolio
- `assets/` : CSS, JS, images, fonts
- `admin/` : back-office
- `src/config/` : configuration environnement + SQL
- `src/includes/` : db, securite, helpers, upload
- `src/uploads/` : fichiers uploades depuis admin

## Prerequis

- PHP 8.0+
- MySQL/MariaDB
- Extensions PHP: `pdo`, `pdo_mysql`, `gd`, `fileinfo`

## Installation locale (WAMP)

1. Copier le projet dans `C:\wamp64\www\inner`
2. Creer une base `innerbuild_db`
3. Importer `src/config/init.sql`
4. Ouvrir: `http://localhost/inner/`
5. Admin: `http://localhost/inner/admin/login.php`

Le fichier `src/config/config.php` detecte automatiquement localhost.

## Configuration InfinityFree

Renseigner dans `src/config/config.php` (deja preconfigure en auto-prod):

- Host: `sql100.infinityfree.com`
- DB: `if0_41706453_innerbuild_db`
- User: `if0_41706453`
- Mot de passe: variable d'environnement `IF_DB_PASS` (recommande)

URL production: `https://cyrus-innerbuild.kesug.com/`

## Fonctionnalites admin

- Modifier textes du profil
- Changer couleurs, font, tailles globales
- Ajouter/editer/supprimer projets, skills, certifications
- Upload d'images optimise (validation MIME + redimensionnement)
- Gestion des messages de contact

## Notes de securite

- Token CSRF sur formulaires sensibles
- Validation serveur des uploads
- Ne pas versionner les mots de passe en clair

## Deploiement

Pour un package de production, garder:

- `index.php`
- `public/`
- `templates/`
- `assets/`
- `admin/`
- `src/`
- `.htaccess` (si necessaire selon hebergeur)

