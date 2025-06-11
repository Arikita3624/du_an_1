<style>
    .message {
        padding: 10px;
        margin: 10px 0;
        max-width: 600px;
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
        transition: opacity 0.5s ease;
        position: fixed;
        top: 60px;
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
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
session_start();

// Tự động đăng nhập nếu có cookie
if (!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])) {
    require_once __DIR__ . '/models/Auth.php';
    $authModel = new SignInModel();
    $user = $authModel->login($_COOKIE['remember_user'], null, true);
    if ($user && is_array($user) && !isset($user['success']) && !empty($user['username'])) {
        $_SESSION['user'] = $user;
    } else {
        setcookie('remember_user', '', time() - 3600, "/");
        unset($_SESSION['user']);
    }
}

// Xử lý logout
$act = $_GET['act'] ?? '/';
if ($act === 'logout') {
    setcookie('remember_user', '', time() - 3600, "/");
    session_destroy();
    session_start();
    $_SESSION['message'] = 'Đã đăng xuất thành công!';
    $_SESSION['message_type'] = 'success';
    header('Location: ?act=login');
    ob_end_flush();
    exit();
}

// Xử lý thêm vào giỏ hàng (nếu dùng trực tiếp ở đây, còn không thì dùng controller)
if ($act === 'add-to-cart' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nếu chưa đăng nhập thì chuyển hướng sang trang đăng nhập
    if (!isset($_SESSION['user'])) {
        $_SESSION['message'] = 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng!';
        $_SESSION['message_type'] = 'error';
        header('Location: ?act=login');
        exit;
    }
}

// Require các file cần thiết
require_once './commons/env.php';
require_once './commons/function.php';
require_once './controllers/HomeController.php';
require_once './controllers/AboutsController.php';
require_once './controllers/ProductControllerClient.php';
require_once './controllers/CartsController.php';
require_once './controllers/CheckoutController.php';
require_once './controllers/AuthController.php';
require_once './controllers/OrderController.php';
require_once './controllers/CommentController.php';
// Hiển thị layout top
require_once __DIR__ . '/views/layouts/layouttop.php';

// Hiển thị message
if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    echo '<div class="message ' . htmlspecialchars($_SESSION['message_type'], ENT_QUOTES, 'UTF-8') . '" id="globalMessage">';
    echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    echo '</div>';
    echo '<script>
        setTimeout(() => {
            const message = document.getElementById("globalMessage");
            if (message) {
                message.classList.add("hidden");
            }
        }, 3000);
    </script>';
    unset($_SESSION['message'], $_SESSION['message_type']);
}

// Điều hướng tìm kiếm về product-list
if ($act === '/' && (isset($_GET['search']) || isset($_GET['category_id']))) {
    $act = 'product-list';
}

// Xử lý route
try {
    match ($act) {
        '/' => (new HomeController())->index(),
        'about' => (new AboutsController())->index(),
        'product-list' => (new ProductControllerClient())->list(),
        'product-detail' => (new ProductControllerClient())->detail(),
        'carts' => (new CartsController())->index(),
        'add-to-cart' => (new CartsController())->addToCart(),
        'update-cart' => (new CartsController())->updateCart(),
        'remove-cart-item' => (new CartsController())->removeCartItem(),
        'checkout' => (new CheckoutController())->index(),
        'process-checkout' => (new CheckoutController())->processCheckout(),
        'order-list' => (new OrderController())->list(),
        'order-confirmation' => (new OrderController())->view(),
        'mark-order-received' => (new OrderController())->markAsReceived(),
        'add-comment' => (new CommentController())->add(),
        'login' => (new SignInController())->index(),
        'register' => (new SignUpController())->index(),
        default => throw new Exception("Route không hợp lệ: $act"),
    };
} catch (Exception $e) {
    echo "Lỗi định tuyến: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    ob_end_flush();
    exit();
}

require_once __DIR__ . '/views/layouts/layoutbottom.php';
ob_end_flush();
?>