<?php
session_start();
require_once '../commons/Database.php';

// Nếu đã đăng nhập thì chuyển về trang chủ admin
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Vui lòng nhập đầy đủ thông tin!';
    } else {
        $db = new Database();
        $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin' LIMIT 1";
        $user = $db->queryOne($sql, [$username]);

        // Debug chi tiết
        error_log("=== DEBUG LOGIN ===");
        error_log("Username nhập vào: " . $username);
        error_log("Password nhập vào: " . $password);
        error_log("SQL Query: " . $sql);
        
        if ($user) {
            error_log("Tìm thấy user trong database");
            error_log("User data: " . print_r($user, true));
            error_log("Password hash trong DB: " . $user['password']);
            error_log("Kết quả verify password: " . (password_verify($password, $user['password']) ? "TRUE" : "FALSE"));
        } else {
            error_log("KHÔNG tìm thấy user trong database");
        }

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_username'] = $user['username'];
            $_SESSION['admin_name'] = $user['full_name'];

            header('Location: index.php');
            exit;
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Admin Panel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #343a40;
            color: white;
            text-align: center;
            border-radius: 10px 10px 0 0 !important;
            padding: 20px;
        }
        .card-body {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-login {
            background-color: #343a40;
            border-color: #343a40;
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
        .btn-login:hover {
            background-color: #23272b;
            border-color: #23272b;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Đăng nhập Admin</h3>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="form-group">
                            <label for="username">Tên đăng nhập</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="username" name="username"
                                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                       placeholder="Nhập tên đăng nhập" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" id="password" name="password"
                                       placeholder="Nhập mật khẩu" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-login">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>