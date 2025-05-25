<?php

require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ .'/../commons/function.php';

class HomePageModels {
    public function getAllProducts() {
        $conn = connectDB();
        $products = $conn->query('SELECT * FROM products')->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as &$product) {
            $categoryId = $product['category_id'];
            $stmt = $conn->prepare('SELECT name FROM categories WHERE id = :id');
            $stmt->execute([':id' => $categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            $product['category_name'] = $category['name'] ?? 'Chưa phân loại';
        }
        return $products;
    }
}
class Category {
    public function getAll() {
        $conn = connectDB();
        return $conn->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
    }
}
class Product {
    public function getFiltered($search, $price, $category_id, $limit, $offset) {
        $conn = connectDB();
        $sql = "SELECT * FROM products WHERE 1";
        $params = [];
        if ($search) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }
        if ($category_id) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        if ($price) {
            [$min, $max] = explode('-', $price);
            $sql .= " AND price >= :min AND price <= :max";
            $params[':min'] = $min;
            $params[':max'] = $max;
        }
        $sql .= " LIMIT $limit OFFSET $offset";
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function countFiltered($search, $price, $category_id) {
        $conn = connectDB();
        $sql = "SELECT COUNT(*) FROM products WHERE 1";
        $params = [];
        if ($search) {
            $sql .= " AND name LIKE :search";
            $params[':search'] = "%$search%";
        }
        if ($category_id) {
            $sql .= " AND category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        if ($price) {
            [$min, $max] = explode('-', $price);
            $sql .= " AND price >= :min AND price <= :max";
            $params[':min'] = $min;
            $params[':max'] = $max;
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }

    public function getById($id)
    {
        $conn = connectDB();
        $sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.id = :id LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts($productId, $categoryId, $limit = 4)
    {
        $conn = connectDB();
        // Select products from the same category, excluding the current product
        $sql = "SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.category_id = :category_id AND p.id != :productId LIMIT :limit";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>