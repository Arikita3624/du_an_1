<?php

require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';

class HomePageModels
{
    public function getAllProducts()
    {
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
class CategoryModels
{
    public function getAll()
    {
        $conn = connectDB();
        return $conn->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
    }
}

class ProductModels
{
    public function getFiltered($search, $price, $category_id, $limit, $offset)
    {
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

    public function countFiltered($search, $price, $category_id)
    {
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
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelated($category_id, $except_id, $limit = 4)
    {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = :cat AND id != :id LIMIT :limit");
        $stmt->bindValue(':cat', $category_id, PDO::PARAM_INT);
        $stmt->bindValue(':id', $except_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTopViews($limit = 4)
    {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT * FROM products ORDER BY views DESC LIMIT :limit");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLatest($limit = 8) {
    $db = connectDB();
    $stmt = $db->prepare("SELECT * FROM products ORDER BY created_at DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
