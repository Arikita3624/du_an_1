<?php
require_once __DIR__ . '/../models/UserModel.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function index() {
        $keyword = $_GET['keyword'] ?? '';
        
        if (!empty($keyword)) {
            $users = $this->userModel->searchUsers($keyword);
        } else {
            $users = $this->userModel->getAllUsers();
        }
        
        require_once __DIR__ . '/../views/user/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'] ?? '',
                'password' => $_POST['password'] ?? '',
                'full_name' => $_POST['full_name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? null,
                'address' => $_POST['address'] ?? null,
                'role' => $_POST['role'] ?? 'user'
            ];

            // Basic validation
            if (empty($data['username']) || empty($data['password']) || empty($data['full_name']) || empty($data['email']) || empty($data['role'])) {
                $_SESSION['error'] = "Vui lòng điền đầy đủ các trường bắt buộc.";
            } elseif ($this->userModel->checkUsernameExists($data['username'])) {
                 $_SESSION['error'] = "Tên đăng nhập đã tồn tại.";
            } elseif ($this->userModel->checkEmailExists($data['email'])) {
                 $_SESSION['error'] = "Email đã tồn tại.";
            } else {
                // Attempt to create user
                if ($this->userModel->createUser($data)) {
                    $_SESSION['success'] = "Thêm người dùng thành công!";
                    header('Location: index.php?controller=user');
                    exit;
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi thêm người dùng.";
                }
            }
             // If there was an error, load the view again with the error message
             require_once __DIR__ . '/../views/user/create.php';

        } else {
            // Display the creation form
            require_once __DIR__ . '/../views/user/create.php';
        }
    }

    public function view() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
            header('Location: index.php?controller=user');
            exit;
        }

        require_once __DIR__ . '/../views/user/view.php';
    }

    public function toggleStatus() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);
        
        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
        } else {
            // Prevent locking the currently logged-in admin user
            if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id && $user['role'] === 'admin') {
                 $_SESSION['error'] = "Không thể tự khóa tài khoản admin đang đăng nhập!";
            } else {
                if ($this->userModel->toggleUserStatus($id)) {
                    $newStatus = $this->userModel->getUserStatus($id);
                    $_SESSION['success'] = "Đã " . ($newStatus === 'locked' ? 'khóa' : 'mở khóa') . " tài khoản thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi thay đổi trạng thái tài khoản!";
                }
            }
        }
        
        header('Location: index.php?controller=user');
        exit;
    }

    public function manageRole() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
            header('Location: index.php?controller=user');
            exit;
        }

        require_once __DIR__ . '/../views/user/manage_role.php';
    }

    public function updateRole() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $user = $this->userModel->getUserById($id);
            $role = $_POST['role'] ?? '';
            
             // Prevent changing the role of the currently logged-in admin user
            if (!$user) {
                 $_SESSION['error'] = "Không tìm thấy người dùng để cập nhật vai trò!";
            } elseif (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id && $user['role'] === 'admin') {
                 $_SESSION['error'] = "Không thể thay đổi vai trò của tài khoản admin đang đăng nhập!";
            } elseif ($this->userModel->updateUserRole($id, $role)) {
                $_SESSION['success'] = "Cập nhật vai trò thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật vai trò!";
            }
        }
        
        header('Location: index.php?controller=user');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $user = $this->userModel->getUserById($id);

        if (!$user) {
            $_SESSION['error'] = "Không tìm thấy người dùng!";
        } else {
             // Prevent deleting the currently logged-in admin user
            if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id && $user['role'] === 'admin') {
                 $_SESSION['error'] = "Không thể tự xóa tài khoản admin đang đăng nhập!";
            } else {
                 if ($this->userModel->deleteUser($id)) {
                    $_SESSION['success'] = "Xóa người dùng thành công!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi xóa người dùng.";
                }
            }
        }

        header('Location: index.php?controller=user');
        exit;
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
} 