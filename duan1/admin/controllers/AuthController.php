<?php
require_once __DIR__ . '/../models/AdminModel.php';

class AuthController
{
    private $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $result = $this->adminModel->login($username, $password);

            if ($result['status'] === 'success') {
                $admin = $result['user'];
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                $this->adminModel->updateLastLogin($admin['id']);
                header('Location: index.php?controller=dashboard');
                exit;
            } elseif ($result['status'] === 'not_found') {
                $_SESSION['error'] = "Tài khoản không tồn tại!";
            } elseif ($result['status'] === 'wrong_password') {
                $_SESSION['error'] = "Mật khẩu không đúng!";
            } elseif ($result['status'] === 'not_admin') {
                $_SESSION['error'] = "Bạn không có quyền truy cập trang quản trị!";
            } else {
                $_SESSION['error'] = "Đã xảy ra lỗi, vui lòng thử lại!";
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
