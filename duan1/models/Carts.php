<?php
require_once __DIR__ . '/../commons/function.php';

class CartModels
{
    private $db;
    public function __construct()
    {
        $this->db = connectDB();
    }

    public function getOrCreateCart($userId)
    {
        $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            return $cart['id'];
        }

        $stmt = $this->db->prepare("INSERT INTO carts (user_id, total_price) VALUES (?, 0)");
        $stmt->execute([$userId]);
        return $this->db->lastInsertId();
    }

    public function getCartItemsByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT ci.*, p.name, p.image
            FROM cart_items ci
            JOIN carts c ON ci.cart_id = c.id
            JOIN products p ON ci.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($cartId, $productId, $quantity, $price)
    {
        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, price = ?, total_price = ? WHERE id = ?");
            $stmt->execute([$newQuantity, $price, $newQuantity * $price, $item['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cartId, $productId, $quantity, $price, $quantity * $price]);
        }
    }

    public function removeCartItem($cartId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
    }

    public function updateCartItem($cartId, $productId, $quantity)
    {
        $stmt = $this->db->prepare("SELECT price FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$cartId, $productId]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        $price = $item ? $item['price'] : 0;

        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, total_price = ? WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$quantity, $quantity * $price, $cartId, $productId]);
    }

    public function getCartItems($cartId, $productId = null)
    {
        if ($productId) {
            $stmt = $this->db->prepare("
            SELECT ci.*, p.name, p.image, p.price, p.stock
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ? AND ci.product_id = ?
        ");
            $stmt->execute([$cartId, $productId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->db->prepare("
            SELECT ci.*, p.name, p.image, p.price, p.stock
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.id
            WHERE ci.cart_id = ?
        ");
            $stmt->execute([$cartId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function clearCart($cartId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->execute([$cartId]);
    }
}
