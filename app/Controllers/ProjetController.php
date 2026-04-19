<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Admin - Gestion desProjets
 */
class ProjetController extends Controller {
    
    public function index(): void {
        $this->requireAuth();
        $stmt = $this->db->query("SELECT * FROM projets ORDER BY ordre ASC, id DESC");
        $projets = $stmt->fetchAll();
        $this->render('admin/projets', ['projets' => $projets]);
    }

    public function edit(int $id = 0): void {
        $this->requireAuth();
        $isEdit = $id > 0;
        
        $projet = [
            'titre' => '', 'description' => '', 'technologies' => '', 
            'lien_live' => '', 'lien_github' => '', 'ordre' => 0, 
            'annee' => date('Y'), 'image' => ''
        ];

        if ($isEdit) {
            $stmt = $this->db->prepare("SELECT * FROM projets WHERE id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if ($existing) $projet = $existing;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveProjet($id, $isEdit, $projet);
        }

        $csrf = $this->generateCsrf();
        $this->render('admin/projet_form', [
            'projet' => $projet, 
            'isEdit' => $isEdit,
            'csrf' => $csrf,
            'errors' => $this->errors,
            'success' => $this->success
        ]);
    }

    private function saveProjet(int $id, bool $isEdit, array $currentProjet): void {
        $csrf = $_POST['csrf_token'] ?? '';
        if (!$this->verifyCsrf($csrf)) {
            $this->errors[] = 'Token CSRF invalide';
            return;
        }

        ['titre' => $titre, 'description' => $desc, 'technologies' => $tech, 
         'lien_live' => $live, 'lien_github' => $gh, 'ordre' => $ordre, 'annee' => $annee] 
            = $this->getPost(['titre', 'description', 'technologies', 'lien_live', 'lien_github', 'ordre', 'annee']);

        if (empty($titre)) {
            $this->errors[] = 'Le titre est obligatoire';
            return;
        }

        $imageName = $currentProjet['image'];
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = $this->handleUpload($_FILES['image'], 'image');
        }

        if ($isEdit) {
            $stmt = $this->db->prepare("UPDATE projets SET titre=?, description=?, technologies=?, lien_live=?, lien_github=?, ordre=?, annee=?, image=? WHERE id=?");
            $stmt->execute([$titre, $desc, $tech, $live, $gh, $ordre, $annee, $imageName, $id]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO projets (titre, description, technologies, lien_live, lien_github, ordre, annee, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $desc, $tech, $live, $gh, $ordre, $annee, $imageName]);
            $this->redirect('/admin/projets.php');
        }
        $this->success[] = 'Projet enregistré';
    }

    public function delete(int $id): void {
        $this->requireAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['confirm'])) {
            $stmt = $this->db->prepare("DELETE FROM projets WHERE id = ?");
            $stmt->execute([$id]);
        }
        $this->redirect('/admin/projets.php?deleted=1');
    }

    private function handleUpload(array $file, string $type): string {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowed)) {
            throw new RuntimeException('Format non autorisé');
        }
        if ($file['size'] > 5_000_000) {
            throw new RuntimeException('Fichier trop volumineux');
        }

        $ext = str_replace('image/', '', $mime);
        $name = sprintf('%s_%s.%s', sha1_file($file['tmp_name']), uniqid(), $ext);
        $path = dirname(__DIR__, 2) . '/src/uploads/' . $name;
        
        if (!move_uploaded_file($file['tmp_name'], $path)) {
            throw new RuntimeException('Erreur upload');
        }
        return $name;
    }

    protected function render(string $view, array $data = []): void {
        extract($data);
        $pageTitle = $pageTitle ?? 'Admin';
        require dirname(__DIR__) . "/Views/$view.php";
    }
}