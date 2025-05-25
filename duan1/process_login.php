<?php
session_start();
require_once 'commons/Database.php';
require_once 'models/UserModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin đăng nhập!';
        header('Location: /DUAN1/du_an_1/duan1/?act=login');
        exit;
    }

    try {
        $userModel = new UserModel();
        $user = $userModel->login($username, $password);
        
        // Debug
        error_log("Login attempt - Username: " . $username);
        error_log("User data: " . print_r($user, true));

        if ($user) {
            $_SESSION['user'] = $user;
            header('Location: /DUAN1/du_an_1/duan1/');
            exit;
        } else {
            $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
            header('Location: /DUAN1/du_an_1/duan1/?act=login');
            exit;
        }
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = 'Có lỗi xảy ra khi đăng nhập: ' . $e->getMessage();
        header('Location: /DUAN1/du_an_1/duan1/?act=login');
        exit;
    }
} else {
    header('Location: /DUAN1/du_an_1/duan1/?act=login');
    exit;
} 