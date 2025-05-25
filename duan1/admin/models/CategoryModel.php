<?php
require_once __DIR__ . '/../../commons/Database.php';

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY name ASC";
        return $this->db->query($sql);
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categories WHERE id = :id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }

    public function createCategory($data) {
        // Kiểm tra danh mục đã tồn tại chưa
        if ($this->checkCategoryExists($data['name'])) {
            return false;
        }

        $sql = "INSERT INTO categories (name, description) VALUES (:name, :description)";
        return $this->db->execute($sql, [
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function checkCategoryExists($name, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM categories WHERE name = :name";
        $params = ['name' => $name];
        
        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }
        
        $result = $this->db->queryOne($sql, $params);
        return $result['count'] > 0;
    }

    public function updateCategory($id, $data) {
        // Kiểm tra danh mục đã tồn tại chưa (trừ danh mục hiện tại)
        if ($this->checkCategoryExists($data['name'], $id)) {
            return false;
        }

        $sql = "UPDATE categories SET name = :name, description = :description WHERE id = :id";
        return $this->db->execute($sql, [
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    public function deleteCategory($id) {
        // Kiểm tra xem có sản phẩm nào thuộc danh mục này không
        $sql = "SELECT COUNT(*) as count FROM products WHERE category_id = :id";
        $result = $this->db->queryOne($sql, ['id' => $id]);

        if ($result['count'] > 0) {
            // Nếu có sản phẩm, trả về false và thông báo lỗi
            $_SESSION['error'] = "Không thể xóa danh mục này vì có " . $result['count'] . " sản phẩm đang thuộc danh mục này.";
            return false;
        }

        // Nếu không có sản phẩm, tiến hành xóa danh mục
        $sql = "DELETE FROM categories WHERE id = :id";
        $result = $this->db->execute($sql, ['id' => $id]);
        
        if ($result) {
            $_SESSION['success'] = "Xóa danh mục thành công!";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi xóa danh mục!";
        }
        
        return $result;
    }

    public function searchCategories($keyword) {
        $sql = "SELECT * FROM categories WHERE name LIKE :keyword OR description LIKE :keyword ORDER BY name ASC";
        return $this->db->query($sql, ['keyword' => '%' . $keyword . '%']);
    }
} 