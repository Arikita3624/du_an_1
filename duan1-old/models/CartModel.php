<?php
class CartModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function addToCart($productId, $quantity = 1) {
        try {
            // Kiểm tra sản phẩm tồn tại
            $product = $this->db->queryOne("SELECT * FROM products WHERE id = ?", [$productId]);
            if (!$product) {
                return ['success' => false, 'message' => 'Sản phẩm không tồn tại'];
            }

            // Khởi tạo giỏ hàng nếu chưa có
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'quantity' => $quantity
                ];
            }

            return ['success' => true, 'message' => 'Đã thêm sản phẩm vào giỏ hàng'];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Có lỗi xảy ra: ' . $e->getMessage()];
        }
    }

    public function getCart() {
        return $_SESSION['cart'] ?? [];
    }

    public function updateQuantity($productId, $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            return true;
        }
        return false;
    }

    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            return true;
        }
        return false;
    }

    public function clearCart() {
        $_SESSION['cart'] = [];
    }

    public function getTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] ?? [] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
} 