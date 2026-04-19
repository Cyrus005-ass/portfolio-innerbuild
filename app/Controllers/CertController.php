<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Admin - Certifications
 */
class CertController extends Controller {

    public function index(): void {
        $this->requireAuth();
        $stmt = $this->db->query("SELECT * FROM certifications ORDER BY ordre ASC, date_obtention DESC");
        $certs = $stmt->fetchAll();
        $this->render('admin/certifications', ['certs' => $certs]);
    }

    public function edit(int $id = 0): void {
        $this->requireAuth();
        $isEdit = $id > 0;
        
        $cert = ['nom' => '', 'organisme' => '', 'date_obtention' => '', 'lien_verification' => '', 'ordre' => 0, 'photo' => ''];

        if ($isEdit) {
            $stmt = $this->db->prepare("SELECT * FROM certifications WHERE id = ?");
            $stmt->execute([$id]);
            $existing = $stmt->fetch();
            if ($existing) $cert = $existing;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->saveCert($id, $isEdit, $cert);
        }

        $csrf = $this->generateCsrf();
        $this->render('admin/cert_form', [
            'cert' => $cert, 'isEdit' => $isEdit, 'csrf' => $csrf,
            'errors' => $this->errors, 'success' => $this->success
        ]);
    }

    private function saveCert(int $id, bool $isEdit, array $currentCert): void {
        if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
            $this->errors[] = 'Token CSRF invalide';
            return;
        }

        ['nom' => $nom, 'organisme' => $org, 'date' => $date, 'lien' => $lien, 'ordre' => $ord] 
            = $this->getPost(['nom', 'organisme', 'date_obtention', 'lien_verification', 'ordre']);

        if (empty($nom) || empty($org)) {
            $this->errors[] = 'Nom et organisme obligatoires';
            return;
        }

        $photo = $currentCert['photo'];
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo = $this->handleUpload($_FILES['photo']);
        }

        if ($isEdit) {
            $stmt = $this->db->prepare("UPDATE certifications SET nom=?, organisme=?, date_obtention=?, lien_verification=?, ordre=?, photo=? WHERE id=?");
            $stmt->execute([$nom, $org, $date ?: null, $lien, $ord, $photo, $id]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO certifications (nom, organisme, date_obtention, lien_verification, ordre, photo) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $org, $date ?: null, $lien, $ord, $photo]);
            $this->redirect('/admin/certifications.php');
        }
        $this->success[] = 'Certification enregistrée';
    }

    public function delete(int $id): void {
        $this->requireAuth();
        $stmt = $this->db->prepare("DELETE FROM certifications WHERE id = ?");
        $stmt->execute([$id]);
        $this->redirect('/admin/certifications.php?deleted=1');
    }

    private function handleUpload(array $file): string {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        
        if (!in_array($mime, $allowed)) throw new RuntimeException('Format non autorisé');
        if ($file['size'] > 5_000_000) throw new RuntimeException('Fichier trop gros');

        $ext = str_replace('image/', '', $mime);
        $name = sprintf('%s_%s.%s', sha1_file($file['tmp_name']), uniqid(), $ext);
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