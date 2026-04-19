<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Admin - Profil
 */
class ProfilController extends Controller {

    public function index(): void {
        $this->requireAuth();
        $stmt = $this->db->prepare("SELECT * FROM profil WHERE id = 1");
        $stmt->execute();
        $profil = $stmt->fetch();

        if (!$profil) {
            die("Profil introuvable");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveProfil($profil);
        }

        $csrf = $this->generateCsrf();
        $this->render('admin/profil', [
            'profil' => $profil, 'csrf' => $csrf,
            'errors' => $this->errors, 'success' => $this->success
        ]);
    }

    private function saveProfil(array $current): void {
        if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $this->errors[] = 'Token CSRF invalide';
            return;
        }

        ['nom' => $nom, 'titre' => $titre, 'bio' => $bio, 'email' => $email, 'tel' => $tel, 
         'github' => $gh, 'linkedin' => $li, 'insta' => $ig, 'loc' => $loc] 
            = $this->getPost(['nom', 'titre', 'bio', 'email_contact', 'telephone', 'github', 'linkedin', 'instagram', 'localisation']);

        $avatar = $current['avatar'] ?? '';
        $cv = $current['cv_url'] ?? '';

        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $avatar = $this->handleImageUpload($_FILES['photo']);
        }
        if (!empty($_FILES['cv_file']['name']) && $_FILES['cv_file']['error'] === UPLOAD_ERR_OK) {
            $cv = $this->handleFileUpload($_FILES['cv_file']);
        }

        $stmt = $this->db->prepare("UPDATE profil SET nom=?, titre=?, bio=?, email_contact=?, telephone=?, github=?, linkedin=?, instagram=?, avatar=?, localisation=?, cv_url=? WHERE id=1");
        $stmt->execute([$nom, $titre, $bio, $email, $tel, $gh, $li, $ig, $avatar, $loc, $cv]);
        $this->success[] = 'Profilmis à jour';
    }

    private function handleImageUpload(array $file): string {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, $allowed)) throw new RuntimeException('Format non autorisé');
        
        $ext = str_replace('image/', '', $mime);
        $name = sprintf('avatar_%s.%s', uniqid(), $ext);
        $path = dirname(__DIR__, 2) . '/src/uploads/' . $name;
        move_uploaded_file($file['tmp_name'], $path);
        return $name;
    }

    private function handleFileUpload(array $file): string {
        $allowed = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!in_array($mime, $allowed)) throw new RuntimeException('Format CV non autorisé');
        
        $ext = $mime === 'application/pdf' ? 'pdf' : 'docx';
        $name = sprintf('cv_%s.%s', uniqid(), $ext);
        $path = dirname(__DIR__, 2) . '/src/uploads/' . $name;
        move_uploaded_file($file['tmp_name'], $path);
        return $name;
    }

    protected function render(string $view, array $data = []): void {
        extract($data);
        $pageTitle = $pageTitle ?? 'Admin';
        require dirname(__DIR__) . "/Views/$view.php";
    }
}