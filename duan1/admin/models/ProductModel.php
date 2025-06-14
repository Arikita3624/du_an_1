<?php
require_once __DIR__ . '/../../commons/Database.php';

class ProductModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.id DESC";
        return $this->db->query($sql);
    }

    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }

    public function createProduct($data)
    {
        $sql = "INSERT INTO products (name, description, price, category_id, image, stock, created_at)
                VALUES (:name, :description, :price, :category_id, :image, :stock, NOW())";
        return $this->db->execute($sql, $data);
    }

    public function updateProduct($id, $data)
    {
        try {
            $sql = "UPDATE products SET
                name = :name,
                description = :description,
                price = :price,
                category_id = :category_id,
                stock = :stock,
                updated_at = NOW()";
            $params = [
                ':name' => $data['name'],
                ':description' => $data['description'],
                ':price' => $data['price'],
                ':category_id' => $data['category_id'],
                ':stock' => $data['stock'],
                ':id' => $id
            ];
            // Nếu có ảnh mới thì cập nhật
            if (!empty($data['image'])) {
                $sql .= ", image = :image";
                $params[':image'] = $data['image'];
            }
            $sql .= " WHERE id = :id";
            return $this->db->execute($sql, $params);
        } catch (PDOException $e) {
            error_log("Lỗi cập nhật sản phẩm: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    public function getProductCount($keyword = null, $categoryId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE 1=1";
        $params = [];

        if ($keyword) {
            $sql .= " AND (p.name LIKE :keyword OR p.description LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($categoryId) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        $result = $this->db->queryOne($sql, $params);
        return $result['count'];
    }

    public function getProductsWithPagination($limit, $offset, $keyword = null, $categoryId = null)
    {
        $sql = "SELECT p.*, c.name as category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE 1=1";
        $params = [];

        if ($keyword) {
            $sql .= " AND (p.name LIKE :keyword OR p.description LIKE :keyword)";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        if ($categoryId) {
            $sql .= " AND p.category_id = :category_id";
            $params[':category_id'] = $categoryId;
        }

        $sql .= " ORDER BY p.id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        return $this->db->query($sql, $params);
    }

    public function getBestSellingProducts($limit = 5)
    {
        $limit = (int)$limit; // Đảm bảo là số nguyên
        $sql = "SELECT p.id, p.name, SUM(oi.quantity) AS total_sold
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            JOIN orders o ON oi.order_id = o.id
            WHERE o.status IN ('finished', 'completed')
            GROUP BY p.id, p.name
            ORDER BY total_sold DESC
            LIMIT $limit";
        return $this->db->query($sql);
    }

    public function getBestSellingProductsByDate($startDate, $endDate, $limit = 5)
    {
        $sql = "SELECT p.id, p.name, SUM(oi.quantity) AS total_sold
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        JOIN orders o ON oi.order_id = o.id
        WHERE o.status IN ('finished', 'completed')
          AND o.created_at BETWEEN :start AND :end
        GROUP BY p.id, p.name
        ORDER BY total_sold DESC
        LIMIT $limit";
        return $this->db->query($sql, ['start' => $startDate, 'end' => $endDate]);
    }

    public function getTopStockProducts($limit = 5)
    {
        $sql = "SELECT id, name, stock FROM products
            WHERE status = 'active'
            ORDER BY stock DESC
            LIMIT $limit";
        return $this->db->query($sql);
    }
}
