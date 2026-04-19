<?php
/**
 * src/Models/Portfolio.php
 * Gère la récupération de toutes les données du portfolio
 */

class PortfolioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Récupère le profil principal (ID 1)
     */
    public function getProfil() {
        $stmt = $this->pdo->prepare("SELECT * FROM profil WHERE id = 1 LIMIT 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Récupère toutes les compétences actives groupées par catégorie
     */
    public function getSkills() {
        $stmt = $this->pdo->query("SELECT * FROM skills WHERE actif = 1 ORDER BY ordre ASC");
        $skills = $stmt->fetchAll();
        
        $grouped = [];
        foreach ($skills as $skill) {
            $cat = !empty($skill['categorie']) ? $skill['categorie'] : 'Autres';
            $grouped[$cat][] = $skill;
        }
        return $grouped;
    }

    /**
     * Récupère tous les projets actifs
     */
    public function getProjects() {
        $stmt = $this->pdo->query("SELECT * FROM projets WHERE actif = 1 ORDER BY ordre ASC");
        return $stmt->fetchAll();
    }

    /**
     * Récupère toutes les certifications actives
     */
    public function getCertifications() {
        $stmt = $this->pdo->query("SELECT * FROM certifications WHERE actif = 1 ORDER BY ordre ASC");
        return $stmt->fetchAll();
    }
}
