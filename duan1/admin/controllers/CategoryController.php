<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        require_once __DIR__ . '/../views/category/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];
            
            if ($this->categoryModel->createCategory($data)) {
                $_SESSION['success'] = "Thêm danh mục thành công!";
                header('Location: index.php?controller=category');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm danh mục!";
            }
        }
        require_once __DIR__ . '/../views/category/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $category = $this->categoryModel->getCategoryById($id);
        
        if (!$category) {
            $_SESSION['error'] = "Không tìm thấy danh mục!";
            header('Location: index.php?controller=category');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description']
            ];
            
            if ($this->categoryModel->updateCategory($id, $data)) {
                $_SESSION['success'] = "Cập nhật danh mục thành công!";
                header('Location: index.php?controller=category');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật danh mục!";
            }
        }
        require_once __DIR__ . '/../views/category/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $result = $this->categoryModel->deleteCategory($id);
        
        // Luôn chuyển hướng về trang quản lý danh mục
        header('Location: index.php?controller=category');
        exit;
    }

    private function createSlug($str) {
        $str = mb_strtolower($str, 'UTF-8');
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return trim($str, '-');
    }
} 