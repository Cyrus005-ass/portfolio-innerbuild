-- PostgreSQL initialization script for InnerBuild
-- Import this file into your Render Postgres database

BEGIN;

CREATE TABLE IF NOT EXISTS admins (
  id SERIAL PRIMARY KEY,
  email VARCHAR(255) NOT NULL UNIQUE,
  mot_de_passe_hash VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'admin',
  last_login TIMESTAMPTZ NULL
);

CREATE TABLE IF NOT EXISTS profil (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  titre VARCHAR(150) NOT NULL,
  site_theme VARCHAR(50) NOT NULL DEFAULT 'midnight',
  localisation VARCHAR(100) NOT NULL DEFAULT 'Bénin',
  bio TEXT,
  avatar VARCHAR(255),
  cv_url VARCHAR(255),
  email_contact VARCHAR(255) NOT NULL,
  telephone VARCHAR(50),
  linkedin VARCHAR(255),
  github VARCHAR(255),
  instagram VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS skills (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  categorie VARCHAR(100) NOT NULL DEFAULT 'Frontend',
  niveau INTEGER NOT NULL DEFAULT 80,
  icone VARCHAR(100),
  ordre INTEGER NOT NULL DEFAULT 0,
  actif BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS projets (
  id SERIAL PRIMARY KEY,
  titre VARCHAR(255) NOT NULL,
  description TEXT,
  technologies VARCHAR(255),
  image VARCHAR(255),
  lien_live VARCHAR(255),
  lien_github VARCHAR(255),
  ordre INTEGER NOT NULL DEFAULT 0,
  annee VARCHAR(4),
  actif BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS certifications (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  organisme VARCHAR(255) NOT NULL,
  date_obtention DATE,
  lien_verification VARCHAR(255),
  photo VARCHAR(255),
  ordre INTEGER NOT NULL DEFAULT 0,
  actif BOOLEAN NOT NULL DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS messages (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(150) NOT NULL,
  email VARCHAR(255) NOT NULL,
  sujet VARCHAR(255),
  contenu TEXT NOT NULL,
  date_envoi TIMESTAMPTZ NOT NULL DEFAULT CURRENT_TIMESTAMP,
  traite BOOLEAN NOT NULL DEFAULT FALSE
);

INSERT INTO profil (nom, titre, site_theme, localisation, bio, avatar, email_contact, linkedin, github)
SELECT 'Cyrus-y ASSOGBA', 'Développeur Web Full-Stack & UI/UX Designer', 'midnight', 'Located in Bénin', 'Passionné par la création d\'expériences web immersives et performantes. Mon approche marie un code structuré, une architecture backend robuste et un design interactif impactant orienté utilisateur.', 'DSC07033-Cut-Color.png', 'contact@cyrusy.dev', 'https://linkedin.com/in/cyrusy', 'https://github.com/cyrusy'
WHERE NOT EXISTS (SELECT 1 FROM profil);

INSERT INTO skills (nom, categorie, niveau, ordre)
SELECT v.nom, v.categorie, v.niveau, v.ordre
FROM (VALUES
  ('HTML5 / CSS3', 'Frontend', 95, 1),
  ('JavaScript (ES6+)', 'Frontend', 90, 2),
  ('GSAP / Motion', 'Frontend', 85, 3),
  ('PHP 8', 'Backend', 90, 4),
  ('MySQL', 'Backend', 85, 5),
  ('UI / UX Design', 'Design', 80, 6)
) AS v(nom, categorie, niveau, ordre)
WHERE NOT EXISTS (SELECT 1 FROM skills);

INSERT INTO projets (titre, description, technologies, image, annee, ordre)
SELECT v.titre, v.description, v.technologies, v.image, v.annee, v.ordre
FROM (VALUES
  ('Portfolio Premium', 'Portfolio immersif développé avec une approche motion design fluide via GSAP, un espace d\'administration PHP sur mesure et un code ultra optimisé.', 'HTML, CSS, JS, GSAP, PHP, MySQL', 'portfolio-preview.jpg', '2026', 1),
  ('E-commerce Architect', 'Plateforme de vente en ligne complète avec gestion de paniers dynamiques, interface d\'administration produit et checkout sécurisé.', 'PHP, MySQL, Stripe API', 'ecommerce-preview.jpg', '2025', 2)
) AS v(titre, description, technologies, image, annee, ordre)
WHERE NOT EXISTS (SELECT 1 FROM projets);

COMMIT;
