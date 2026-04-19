<?php
/**
 * Controller de base avec helpers
 */
abstract class Controller {
    protected PDO $db;
    protected array $config;
    protected array $errors = [];
    protected array $success = [];

    public function __construct() {
        $this->config = Database::getConfig();
        $this->db = Database::getInstance($this->config);
        $this->initSession();
    }

    private function initSession(): void {
        if (session_status() === PHP_SESSION_NONE) {
            ini_set('session.cookie_httponly', 1);
            ini_set('session.use_only_cookies', 1);
            session_start();
        }
    }

    protected function generateCsrf(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function verifyCsrf(string $token): bool {
        return !empty($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    protected function requireAuth(): void {
        if (empty($_SESSION['admin_id'])) {
            $this->redirect('/admin/login.php');
        }
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > 1800) {
            session_unset();
            session_destroy();
            $this->redirect('/admin/login.php?timeout=1');
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    protected function redirect(string $url): void {
        header("Location: $url");
        exit();
    }

    protected function json(array $data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    protected function sanitize(array|string $data): array|string {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    protected function getPost(array $keys): array {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = trim($_POST[$key] ?? '');
        }
        return $data;
    }
}