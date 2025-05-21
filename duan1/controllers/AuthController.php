<?php
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/../commons/function.php';

class SignUpController
{
    public function index()
    {
        ob_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            // Validate đầu vào
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['message'] = 'Vui lòng điền đầy đủ username, email và mật khẩu.';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=register');
                ob_end_flush();
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['message'] = 'Email không hợp lệ.';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=register');
                ob_end_flush();
                exit();
            }

            if (strlen($password) < 8) {
                $_SESSION['message'] = 'Mật khẩu phải có ít nhất 8 ký tự.';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=register');
                ob_end_flush();
                exit();
            }

            if (!empty($phone) && !preg_match('/^[0-9]{10,12}$/', $phone)) {
                $_SESSION['message'] = 'Số điện thoại không hợp lệ (phải có 10-12 chữ số).';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=register');
                ob_end_flush();
                exit();
            }

            // Gọi model xử lý đăng ký
            $SignUpModel = new SignUpModel();
            $result = $SignUpModel->register($_POST);

            if ($result['success']) {
                $_SESSION['message'] = $result['message'];
                $_SESSION['message_type'] = 'success';
                header('Location: ?act=login');
            } else {
                $_SESSION['message'] = $result['message'];
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=register');
            }

            ob_end_flush();
            exit();
        }

        require_once __DIR__ . '/../views/pages/auth/SignUp.php';
        ob_end_flush();
    }
}

class SignInController
{
    public function index()
    {
        ob_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $_SESSION['message'] = 'Vui lòng nhập email và mật khẩu.';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=login');
                ob_end_flush();
                exit();
            }

            $authModel = new SignInModel();
            $user = $authModel->login($email, $password);

            if ($user) {
                $_SESSION['user'] = $user; // Lưu thông tin người dùng

                $_SESSION['message'] = 'Đăng nhập thành công!';
                $_SESSION['message_type'] = 'success';

                header('Location: index.php'); // Hoặc trang chủ
                exit();
            } else {
                $_SESSION['message'] = 'Email hoặc mật khẩu không đúng.';
                $_SESSION['message_type'] = 'error';
                header('Location: ?act=login');
                exit();
            }

            ob_end_flush();
            exit();
        }

        require_once __DIR__ . '/../views/pages/auth/SignIn.php';
        ob_end_flush();
    }
}
