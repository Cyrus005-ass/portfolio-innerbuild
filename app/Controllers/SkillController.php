<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Admin - Compétences
 */
class SkillController extends Controller {

    public function index(): void {
        $this->requireAuth();
        $stmt = $this->db->query("SELECT * FROM skills ORDER BY categorie, ordre ASC");
        $skills = $stmt->fetchAll();
        $this->render('admin/skills', ['skills' => $skills]);
    }

    public function edit(int $id = 0): void {
        $this->requireAuth();
        $isEdit = $id > 0;
        
        $skill = ['nom' => '', 'categorie' => 'Frontend', 'niveau' => 80, 'ordre' => 0];

        if ($isEdit) {
            $stmt = $this->db->prepare("SELECT * FROM skills WHERE id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if ($existing) $skill = $existing;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveSkill($id, $isEdit);
        }

        $csrf = $this->generateCsrf();
        $this->render('admin/skill_form', [
            'skill' => $skill, 'isEdit' => $isEdit, 'csrf' => $csrf,
            'errors' => $this->errors, 'success' => $this->success
        ]);
    }

    private function saveSkill(int $id, bool $isEdit): void {
        if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $this->errors[] = 'Token CSRF invalide';
            return;
        }

        ['nom' => $nom, 'categorie' => $cat, 'niveau' => $niv, 'ordre' => $ord] 
            = $this->getPost(['nom', 'categorie', 'niveau', 'ordre']);

        if (empty($nom)) {
            $this->errors[] = 'Le nom est obligatoire';
            return;
        }

        $niveau = max(0, min(100, (int)$niv));

        if ($isEdit) {
            $stmt = $this->db->prepare("UPDATE skills SET nom=?, categorie=?, niveau=?, ordre=? WHERE id=?");
            $stmt->execute([$nom, $cat, $niveau, $ord, $id]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO skills (nom, categorie, niveau, ordre) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $cat, $niveau, $ord]);
            $this->redirect('/admin/skills.php');
        }
        $this->success[] = 'Compétence enregistrée';
    }

    public function delete(int $id): void {
        $this->requireAuth();
        $stmt = $this->db->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        $this->redirect('/admin/skills.php?deleted=1');
    }

    protected function render(string $view, array $data = []): void {
        extract($data);
        $pageTitle = $pageTitle ?? 'Admin';
        require dirname(__DIR__) . "/Views/$view.php";
    }
}