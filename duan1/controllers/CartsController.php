<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Carts.php';

class CartsController
{
    private $cartModel;
    private $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModels();
        $this->productModel = new ProductModels();
    }

    private function writeLog($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message";
        error_log($logMessage, 3, "C:/laragon/www/DUAN1/du_an_1/duan1/logs/cart.log");
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['message'] = 'Bạn cần đăng nhập để xem giỏ hàng!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=login');
            exit;
        }

        $cartItems = $this->cartModel->getCartItemsByUserId($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/pages/Carts.php';
    }

    public function addToCart()
    {
        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-list');
            exit;
        }

        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        if ($quantity < 1) {
            $_SESSION['message'] = 'Số lượng phải lớn hơn 0!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-detail&id=' . $product_id);
            exit;
        }

        // Lấy thông tin sản phẩm
        $product = $this->productModel->getById($product_id);
        if (!$product) {
            $_SESSION['message'] = 'Sản phẩm không tồn tại!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-list');
            exit;
        }

        // Lấy số lượng đã có trong giỏ
        $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
        $cartItem = $this->cartModel->getCartItems($cart_id, $product_id);
        $cartQuantity = $cartItem ? intval($cartItem['quantity']) : 0;

        // Kiểm tra tổng số lượng không vượt quá tồn kho
        if ($quantity + $cartQuantity > $product['stock']) {
            $_SESSION['message'] = 'Số lượng bạn chọn vượt quá số lượng tồn kho! Vui lòng chọn số lượng nhỏ hơn hoặc bằng ' . ($product['stock'] - $cartQuantity) . '.';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-detail&id=' . $product_id);
            exit;
        }

        // Thêm vào giỏ hàng (KHÔNG cập nhật bảng products ở đây)
        $this->cartModel->addToCart($cart_id, $product_id, $quantity, $product['price']);

        $_SESSION['message'] = 'Đã thêm sản phẩm vào giỏ hàng!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }
    // ...existing code...

    public function updateCart()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['message'] = 'Bạn cần đăng nhập!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=login');
            exit;
        }

        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $product_id = intval($_POST['product_id']);
        $quantity = intval($_POST['quantity']);
        if ($quantity < 1) {
            $_SESSION['message'] = 'Số lượng phải lớn hơn 0!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $product = $this->productModel->getById($product_id);
        if (!$product) {
            $_SESSION['message'] = 'Sản phẩm không tồn tại!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $stock = intval($product['stock']);
        if ($quantity > $stock) {
            $_SESSION['message'] = 'Số lượng bạn chọn vượt quá số lượng tồn kho! Tối đa còn lại: ' . $stock . '.';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
        $this->cartModel->updateCartItem($cart_id, $product_id, $quantity);

        $_SESSION['message'] = 'Cập nhật giỏ hàng thành công!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }

    public function removeCartItem()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        if (!isset($_POST['product_id'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $product_id = intval($_POST['product_id']);
        $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
        $this->cartModel->removeCartItem($cart_id, $product_id);

        $_SESSION['message'] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }
}
