<?php
require_once __DIR__ . '/../models/AdminModel.php';

class AuthController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $admin = $this->adminModel->login($username, $password);

            if ($admin) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $this->adminModel->updateLastLogin($admin['id']);
                
                header('Location: index.php?controller=dashboard');
                exit;
            } else {
                $_SESSION['error'] = "Tên đăng nhập hoặc mật khẩu không đúng!";
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?> 