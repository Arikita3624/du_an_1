<?php

class CartModel {
    public function getCartItem($cartId, $productId) {
        $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?";
        return $this->db->queryOne($sql, [$cartId, $productId]);
    }
} 