<?php
class CartModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCartByUserId($userId) {
        $sql = "SELECT * FROM carts WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCart($userId) {
        $sql = "INSERT INTO carts (user_id) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $this->db->lastInsertId();
    }

    public function getCartItems($cartId) {
        $sql = "SELECT ci.*, p.name, p.price, p.discount_price, p.image 
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($cartId, $productId, $quantity = 1) {
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId, $productId]);
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Cập nhật số lượng nếu sản phẩm đã có
            $sql = "UPDATE cart_items SET quantity = quantity + ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$quantity, $existingItem['id']]);
        } else {
            // Thêm mới sản phẩm vào giỏ hàng
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$cartId, $productId, $quantity]);
        }
    }

    public function updateCartItemQuantity($cartItemId, $quantity) {
        $sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$quantity, $cartItemId]);
    }

    public function removeFromCart($cartItemId) {
        $sql = "DELETE FROM cart_items WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cartItemId]);
    }

    public function clearCart($cartId) {
        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cartId]);
    }

    public function getCartTotal($cartId) {
        $sql = "SELECT SUM(
                    CASE 
                        WHEN p.discount_price IS NOT NULL THEN p.discount_price * ci.quantity
                        ELSE p.price * ci.quantity
                    END
                ) as total
                FROM cart_items ci 
                JOIN products p ON ci.product_id = p.id 
                WHERE ci.cart_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cartId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
} 