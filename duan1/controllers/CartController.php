<?php
class CartController {
    private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function index() {
        $cartItems = $this->cartModel->getCart();
        $cartTotal = $this->cartModel->getTotal();
        require_once 'views/pages/Cart.php';
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                return;
            }

            $result = $this->cartModel->addToCart($productId, $quantity);
            echo json_encode($result);
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                return;
            }

            if ($quantity < 1) {
                $quantity = 1;
            }

            $result = $this->cartModel->updateQuantity($productId, $quantity);
            echo json_encode(['success' => $result, 'message' => $result ? 'Đã cập nhật số lượng' : 'Có lỗi xảy ra']);
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;

            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                return;
            }

            $result = $this->cartModel->removeFromCart($productId);
            echo json_encode(['success' => $result, 'message' => $result ? 'Đã xóa sản phẩm khỏi giỏ hàng' : 'Có lỗi xảy ra']);
        }
    }

    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->cartModel->clearCart();
            echo json_encode(['success' => true, 'message' => 'Đã xóa giỏ hàng']);
        }
    }
} 