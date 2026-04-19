-- Script d'initialisation de la base de données innerbuild_db
-- Structure optimisée pour le Portfolio Premium

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `innerbuild_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `innerbuild_db`;

-- --------------------------------------------------------
-- Table `admins`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','superadmin') COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion de l'admin par défaut (mot de passe : "admin123" à changer en prod !)

-- Table `profil`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `profil`;
CREATE TABLE IF NOT EXISTS `profil` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_theme` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'midnight',
  `localisation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Bénin',
  `bio` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_contact` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profil` (`nom`, `titre`, `site_theme`, `localisation`, `bio`, `avatar`, `email_contact`, `linkedin`, `github`) VALUES
('Cyrus-y ASSOGBA', 'Développeur Web Full-Stack & UI/UX Designer', 'midnight', 'Located in Bénin', 'Passionné par la création d\'expériences web immersives et performantes. Mon approche marie un code structuré, une architecture backend robuste et un design interactif impactant orienté utilisateur.', 'DSC07033-Cut-Color.png', 'contact@cyrusy.dev', 'https://linkedin.com/in/cyrusy', 'https://github.com/cyrusy');

-- --------------------------------------------------------
-- Table `skills`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Frontend',
  `niveau` int DEFAULT '80',
  `icone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `skills` (`nom`, `categorie`, `niveau`, `ordre`) VALUES
('HTML5 / CSS3', 'Frontend', 95, 1),
('JavaScript (ES6+)', 'Frontend', 90, 2),
('GSAP / Motion', 'Frontend', 85, 3),
('PHP 8', 'Backend', 90, 4),
('MySQL', 'Backend', 85, 5),
('UI / UX Design', 'Design', 80, 6);

-- --------------------------------------------------------
-- Table `projets`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `projets`;
CREATE TABLE IF NOT EXISTS `projets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `technologies` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_live` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lien_github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `annee` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projets` (`titre`, `description`, `technologies`, `image`, `annee`, `ordre`) VALUES
('Portfolio Premium', 'Portfolio immersif développé avec une approche motion design fluide via GSAP, un espace d\'administration PHP sur mesure et un code ultra optimisé.', 'HTML, CSS, JS, GSAP, PHP, MySQL', 'portfolio-preview.jpg', '2026', 1),
('E-commerce Architect', 'Plateforme de vente en ligne complète avec gestion de paniers dynamiques, interface d\'administration produit et checkout sécurisé.', 'PHP, MySQL, Stripe API', 'ecommerce-preview.jpg', '2025', 2);

-- --------------------------------------------------------
-- Table `certifications`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `certifications`;
CREATE TABLE IF NOT EXISTS `certifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organisme` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_obtention` date DEFAULT NULL,
  `lien_verification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordre` int DEFAULT '0',
  `actif` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table `messages`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `messages`;
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sujet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenu` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
  `traite` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


COMMIT;
