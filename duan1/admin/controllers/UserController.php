<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        require_once __DIR__ . '/../views/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => $_POST['password'],
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'role' => $_POST['role']
            ];

            // Kiểm tra username đã tồn tại chưa
            if ($this->userModel->checkUsernameExists($data['username'])) {
                $_SESSION['error'] = "Tên đăng nhập đã tồn tại!";
                require_once __DIR__ . '/../views/user/create.php';
                return;
            }

            // Kiểm tra email đã tồn tại chưa
            if ($this->userModel->checkEmailExists($data['email'])) {
                $_SESSION['error'] = "Email đã tồn tại!";
                require_once __DIR__ . '/../views/user/create.php';
                return;
            }

            if ($this->userModel->createUser($data)) {
                $_SESSION['success'] = "Thêm người dùng thành công!";
                header('Location: index.php?controller=user');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm người dùng!";
            }
        }
        require_once __DIR__ . '/../views/user/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
            header('Location: index.php?controller=user');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'full_name' => $_POST['full_name'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'role' => $_POST['role']
            ];

            // Kiểm tra email đã tồn tại chưa (trừ user hiện tại)
            if ($this->userModel->checkEmailExists($data['email'], $id)) {
                $_SESSION['error'] = "Email đã tồn tại!";
                require_once __DIR__ . '/../views/user/edit.php';
                return;
            }

            if ($this->userModel->updateUser($id, $data)) {
                $_SESSION['success'] = "Cập nhật thông tin người dùng thành công!";
                header('Location: index.php?controller=user');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật thông tin người dùng!";
            }
        }
        require_once __DIR__ . '/../views/user/edit.php';
    }

    public function changePassword() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
            header('Location: index.php?controller=user');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = "Mật khẩu xác nhận không khớp!";
                require_once __DIR__ . '/../views/user/change_password.php';
                return;
            }

            if ($this->userModel->updatePassword($id, $newPassword)) {
                $_SESSION['success'] = "Đổi mật khẩu thành công!";
                header('Location: index.php?controller=user');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi đổi mật khẩu!";
            }
        }
        require_once __DIR__ . '/../views/user/change_password.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        
        if ($this->userModel->deleteUser($id)) {
            $_SESSION['success'] = "Xóa người dùng thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa người dùng!";
        }
        
        header('Location: index.php?controller=user');
        exit;
    }
} 