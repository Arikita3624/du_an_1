<?php

class ProductModel {
    public function updateStock($productId, $newStock) {
        $sql = "UPDATE products SET stock = ? WHERE id = ?";
        return $this->db->execute($sql, [$newStock, $productId]);
    }
} 