<?php
require_once __DIR__ . '/../Core/Controller.php';

/**
 * Controller Authentification
 */
class AuthController extends Controller {

    public function login(): void {
        if (!empty($_SESSION['admin_id'])) {
            $this->redirect('/admin/index.php');
        }

        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $error = $this->authenticate();
        }

        $csrf = $this->generateCsrf();
        require dirname(__DIR__) . '/Views/public/login.php';
    }

    private function authenticate(): string {
        if (!$this->verifyCsrf($_POST['csrf_token'] ?? '')) {
            return 'Token invalide';
        }

        ['email' => $email, 'password' => $password] = $this->getPost(['email', 'password']);

        $stmt = $this->db->prepare("SELECT id, email, mot_de_passe_hash, role FROM admins WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['mot_de_passe_hash'])) {
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            $_SESSION['LAST_ACTIVITY'] = time();

            $stmt = $this->db->prepare("UPDATE admins SET last_login = NOW() WHERE id = ?");
            $stmt->execute([$admin['id']]);

            $this->redirect('/admin/index.php');
        }

        return 'Email ou mot de passe incorrect';
    }

    public function logout(): void {
        session_unset();
        session_destroy();
        $this->redirect('/admin/login.php');
    }
}