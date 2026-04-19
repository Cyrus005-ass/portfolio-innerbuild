<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Public - Portfolio
 */
class PortfolioController extends Controller {

    public function index(): void {
        $this->config = Database::getConfig();
        $this->db = Database::getInstance($this->config);

        $contactSuccess = false;
        $contactError = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'contact') {
            if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
                $contactError = 'Token invalide';
            } else {
                $contactSuccess = $this->handleContact();
            }
        }

        $profil = $this->getProfil();
        $skills = $this->getSkills();
        $projects = $this->getProjects();
        $certifications = $this->getCertifications();
        $csrf = $this->generateCsrf();

        require dirname(__DIR__) . '/Views/public/home.php';
    }

    private function handleContact(): bool {
        ['nom' => $nom, 'email' => $email, 'sujet' => $sujet, 'message' => $message] 
            = $this->getPost(['nom', 'email', 'sujet', 'message']);

        if (empty($nom) || empty($email) || empty($message)) {
            $this->errors[] = 'Tous les champs obligatoires';
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email invalide';
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO messages (nom, email, sujet, contenu, date_envoi) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$nom, $email, $sujet, $message]);
        return true;
    }

    private function getProfil(): ?array {
        $stmt = $this->db->prepare("SELECT * FROM profil WHERE id = 1");
        $stmt->execute();
        return $stmt->fetch();
    }

    private function getSkills(): array {
        $stmt = $this->db->query("SELECT * FROM skills ORDER BY categorie, ordre ASC");
        $all = $stmt->fetchAll();
        $grouped = [];
        foreach ($all as $s) {
            $grouped[$s['categorie']][] = $s;
        }
        return $grouped;
    }

    private function getProjects(): array {
        $stmt = $this->db->query("SELECT * FROM projets ORDER BY ordre ASC, id DESC");
        return $stmt->fetchAll();
    }

    private function getCertifications(): array {
        $stmt = $this->db->query("SELECT * FROM certifications ORDER BY ordre ASC, date_obtenance DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}