<?php
session_start();
require_once __DIR__ . '/../commons/Database.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

// Các route không cần đăng nhập
$publicRoutes = [
    'auth/login',
    'auth/logout'
];

$controller = $_GET['controller'] ?? 'dashboard';
$action = $_GET['action'] ?? 'index';

$route = $controller . '/' . $action;

// Kiểm tra đăng nhập
if (!in_array($route, $publicRoutes)) {
    AuthMiddleware::isLoggedIn();
} else if ($route === 'auth/login') {
    AuthMiddleware::isNotLoggedIn();
}

// Biến để lưu nội dung
$content = '';

// Load controller
$controllerFile = __DIR__ . '/controllers/' . ucfirst($controller) . 'Controller.php';
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = ucfirst($controller) . 'Controller';
    $controllerInstance = new $controllerClass();
    
    if (method_exists($controllerInstance, $action)) {
        // Bắt đầu output buffering
        ob_start();
        $controllerInstance->$action();
        $content = ob_get_clean();
    } else {
        $content = '<div class="alert alert-danger">Action không tồn tại!</div>';
    }
} else {
    $content = '<div class="alert alert-danger">Controller không tồn tại!</div>';
}

// Nếu là trang đăng nhập, chỉ hiển thị nội dung đăng nhập
if ($route === 'auth/login') {
    echo $content;
    exit;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Panel</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="<?php echo $controller == 'dashboard' ? 'active' : ''; ?>">
                    <a href="index.php?controller=dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="<?php echo $controller == 'product' ? 'active' : ''; ?>">
                    <a href="index.php?controller=product">
                        <i class="fas fa-box"></i> Quản lý sản phẩm
                    </a>
                </li>
                <li class="<?php echo $controller == 'category' ? 'active' : ''; ?>">
                    <a href="index.php?controller=category">
                        <i class="fas fa-list"></i> Quản lý danh mục
                    </a>
                </li>
                <li class="<?php echo $controller == 'order' ? 'active' : ''; ?>">
                    <a href="index.php?controller=order">
                        <i class="fas fa-shopping-cart"></i> Quản lý đơn hàng
                    </a>
                </li>
                <li class="<?php echo $controller == 'user' ? 'active' : ''; ?>">
                    <a href="index.php?controller=user">
                        <i class="fas fa-users"></i> Quản lý người dùng
                    </a>
                </li>
                <li class="<?php echo $controller == 'comment' ? 'active' : ''; ?>">
                    <a href="index.php?controller=comment">
                        <i class="fas fa-comments"></i> Quản lý bình luận
                    </a>
                </li>
                <li class="<?php echo $controller == 'cart' ? 'active' : ''; ?>">
                    <a href="index.php?controller=cart">
                        <i class="fas fa-shopping-cart"></i> Quản lý giỏ hàng
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <div class="ml-auto">
                        <span class="mr-3">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? ''); ?>
                        </span>
                        <a href="index.php?controller=auth&action=logout" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </nav>

            <!-- Content từ controller -->
            <?php echo $content; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html>