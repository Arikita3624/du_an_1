<?php
require_once __DIR__ . '/../models/CartModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CartController {
    private $cartModel;
    private $productModel;

    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để xem giỏ hàng!';
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $cart = $this->cartModel->getCartByUserId($userId);
        
        if (!$cart) {
            $cartId = $this->cartModel->createCart($userId);
            $cart = ['id' => $cartId];
        }

        $cartItems = $this->cartModel->getCartItems($cart['id']);
        $total = $this->cartModel->getCartTotal($cart['id']);
        
        require_once __DIR__ . '/../views/cart/index.php';
    }

    public function add() {
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Vui lòng đăng nhập để thêm vào giỏ hàng!';
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            $userId = $_SESSION['user_id'];
            $cart = $this->cartModel->getCartByUserId($userId);
            
            if (!$cart) {
                $cartId = $this->cartModel->createCart($userId);
            } else {
                $cartId = $cart['id'];
            }

            if ($this->cartModel->addToCart($cartId, $productId, $quantity)) {
                $_SESSION['success'] = 'Đã thêm sản phẩm vào giỏ hàng!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thêm vào giỏ hàng!';
            }
        }
        
        header('Location: index.php?controller=cart');
        exit();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cartItemId = $_POST['cart_item_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 1;

            if ($this->cartModel->updateCartItemQuantity($cartItemId, $quantity)) {
                $_SESSION['success'] = 'Đã cập nhật số lượng sản phẩm!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật số lượng!';
            }
        }
        
        header('Location: index.php?controller=cart');
        exit();
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_item_id'])) {
            $cartItemId = $_POST['cart_item_id'];
            if ($this->cartModel->removeFromCart($cartItemId)) {
                $_SESSION['success'] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi xóa sản phẩm!';
            }
        }
        
        header('Location: index.php?controller=cart');
        exit();
    }

    public function clear() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit();
        }

        $userId = $_SESSION['user_id'];
        $cart = $this->cartModel->getCartByUserId($userId);
        
        if ($cart && $this->cartModel->clearCart($cart['id'])) {
            $_SESSION['success'] = 'Đã xóa toàn bộ giỏ hàng!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa giỏ hàng!';
        }
        
        header('Location: index.php?controller=cart');
        exit();
    }

    public function view() {
        if (isset($_GET['id'])) {
            $cartId = $_GET['id'];
            $cart = $this->cartModel->getCartById($cartId);
            if ($cart) {
                $cartItems = $this->cartModel->getCartItems($cartId);
                require_once __DIR__ . '/../views/cart/view.php';
            } else {
                $_SESSION['error'] = 'Không tìm thấy giỏ hàng!';
                header('Location: index.php?controller=cart');
                exit();
            }
        } else {
            header('Location: index.php?controller=cart');
            exit();
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $cartId = $_POST['id'];
            if ($this->cartModel->deleteCart($cartId)) {
                $_SESSION['success'] = 'Đã xóa giỏ hàng thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi xóa giỏ hàng!';
            }
        }
        header('Location: index.php?controller=cart');
        exit();
    }
} 