<?php
require_once __DIR__ . '/../../commons/Database.php';

class ProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getProductCount() {
        $sql = "SELECT COUNT(*) as count FROM products";
        $result = $this->db->queryOne($sql);
        return $result['count'];
    }

    public function getAllProducts() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        return $this->db->query($sql);
    }

    public function getProductById($id) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }

    public function createProduct($data) {
        $sql = "INSERT INTO products (name, description, price, category_id, image, stock, created_at) 
                VALUES (:name, :description, :price, :category_id, :image, :stock, NOW())";
        return $this->db->execute($sql, $data);
    }

    public function updateProduct($id, $data) {
        try {
            $sql = "UPDATE products SET 
                    name = :name,
                    description = :description,
                    price = :price,
                    category_id = :category_id,
                    stock = :stock,
                    updated_at = NOW()
                    WHERE id = :id";
            
            $params = [
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':price' => $data['price'],
                ':category_id' => $data['category_id'],
                ':stock' => $data['stock'],
                ':id' => $id
            ];
            
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật sản phẩm: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }
}
