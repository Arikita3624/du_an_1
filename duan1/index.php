<style>
    .message {
        padding: 10px;
        margin: 0;
        max-width: 600px;
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
        transition: opacity 0.5s ease;
        position: fixed;
        top: 10px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 100%;
        box-sizing: border-box;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .message.hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>

<?php
ob_start(); // Bắt đầu bộ đệm đầu ra

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hiển thị thông báo từ session nếu có
if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    echo '<div class="message ' . htmlspecialchars($_SESSION['message_type']) . '" id="globalMessage">';
    echo htmlspecialchars($_SESSION['message']);
    echo '</div>';
    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/AboutsController.php';
require_once './controllers/ProductController.php';
require_once './controllers/CartsController.php';
require_once './controllers/CheckoutController.php';
require_once './controllers/AuthController.php';

// Route
$act = $_GET['act'] ?? '/';

// Debug: Kiểm tra giá trị của $act
echo "<!-- Debug: act = $act -->";

require_once __DIR__ . '/views/layouts/layouttop.php';

// Thêm xử lý đăng xuất
if ($act === 'logout') {
    session_destroy();
    session_start(); // Khởi tạo lại session để tránh lỗi
    $_SESSION['message'] = 'Đã đăng xuất thành công!';
    $_SESSION['message_type'] = 'success';
    header('Location: ?act=login');
    ob_end_flush();
    exit();
}

// Để bảo đảm tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match
try {
    match ($act) {
        // Trang chủ
        '/'                 => (new HomeController())->index(),
        'about'             => (new AboutsController())->index(),
        'product-list'      => (new ProductController())->index(),
        'product-detail'    => (new ProductDetailController())->index(),
        'carts'             => (new CartsController())->index(),
        'checkout'          => (new CheckoutController())->index(),
        'login'             => (new SignInController())->index(),
        'register'          => (new SignUpController())->index(),
        default             => throw new Exception("Route không hợp lệ: $act"),
    };
} catch (Exception $e) {
    echo "Lỗi định tuyến: " . $e->getMessage();
    ob_end_flush();
    exit();
}

require_once __DIR__ . '/views/layouts/layoutbottom.php';

ob_end_flush(); // Xả bộ đệm đầu ra
?>