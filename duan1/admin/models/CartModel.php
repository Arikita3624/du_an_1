<?php
require_once __DIR__ . '/../../commons/Database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllCarts() {
        $sql = "SELECT c.*, u.username, u.full_name, 
                COUNT(ci.id) as total_items,
                SUM(ci.quantity * p.price) as total_amount
                FROM carts c
                LEFT JOIN users u ON c.user_id = u.id
                LEFT JOIN cart_items ci ON c.id = ci.cart_id
                LEFT JOIN products p ON ci.product_id = p.id
                GROUP BY c.id
                ORDER BY c.created_at DESC";
        return $this->db->query($sql);
    }

    public function getCartById($cartId) {
        $sql = "SELECT c.*, u.username, u.full_name
                FROM carts c
                LEFT JOIN users u ON c.user_id = u.id
                WHERE c.id = ?";
        return $this->db->queryOne($sql, [$cartId]);
    }

    public function getCartItems($cartId) {
        $sql = "SELECT ci.*, p.name, p.price, p.discount_price, p.image 
                FROM cart_items ci
                JOIN products p ON ci.product_id = p.id
                WHERE ci.cart_id = ?";
        return $this->db->query($sql, [$cartId]);
    }

    public function deleteCart($cartId) {
        // Xóa các cart items trước
        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        $this->db->execute($sql, [$cartId]);
        
        // Sau đó xóa cart
        $sql = "DELETE FROM carts WHERE id = ?";
        return $this->db->execute($sql, [$cartId]);
    }

    public function getCartByUserId($userId) {
        $sql = "SELECT * FROM carts WHERE user_id = ?";
        return $this->db->queryOne($sql, [$userId]);
    }

    public function createCart($userId) {
        $sql = "INSERT INTO carts (user_id) VALUES (?)";
        return $this->db->execute($sql, [$userId]);
    }

    public function addToCart($cartId, $productId, $quantity = 1) {
        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $existingItem = $this->db->queryOne($sql, [$cartId, $productId]);

        if ($existingItem) {
            // Cập nhật số lượng nếu sản phẩm đã tồn tại
            $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE cart_id = ? AND product_id = ?";
            return $this->db->execute($sql, [$quantity, $cartId, $productId]);
        } else {
            // Thêm mới sản phẩm vào giỏ hàng
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            return $this->db->execute($sql, [$cartId, $productId, $quantity]);
        }
    }

    public function updateCartItemQuantity($cartId, $productId, $quantity) {
        $sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?";
        return $this->db->execute($sql, [$quantity, $cartId, $productId]);
    }

    public function removeFromCart($cartId, $productId) {
        $sql = "DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?";
        return $this->db->execute($sql, [$cartId, $productId]);
    }

    public function clearCart($cartId) {
        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        return $this->db->execute($sql, [$cartId]);
    }

    public function getCartTotal($cartId) {
        $sql = "SELECT SUM(ci.quantity * COALESCE(p.discount_price, p.price)) as total 
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ?";
        $result = $this->db->queryOne($sql, [$cartId]);
        return $result['total'] ?? 0;
    }
} 