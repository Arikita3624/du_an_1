<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $keyword = $_GET['keyword'] ?? '';

        if (!empty($keyword)) {
            $categories = $this->categoryModel->searchCategories($keyword);
        } else {
            $categories = $this->categoryModel->getAllCategories();
        }

        require_once __DIR__ . '/../views/category/index.php';
    }

    public function create()
    {
        $errors = [];
        $name = '';
        $description = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if ($name === '') {
                $errors['name'] = 'Tên danh mục không được để trống!';
            } elseif ($this->categoryModel->checkCategoryExists($name)) {
                $errors['name'] = 'Danh mục này đã tồn tại!';
            }

            // Có thể kiểm tra thêm cho description nếu muốn

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];
                if ($this->categoryModel->createCategory($data)) {
                    $_SESSION['success'] = "Thêm danh mục thành công!";
                    header('Location: index.php?controller=category');
                    exit;
                } else {
                    $errors['general'] = "Có lỗi xảy ra khi thêm danh mục!";
                }
            }
        }
        require_once __DIR__ . '/../views/category/create.php';
    }

    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $category = $this->categoryModel->getCategoryById($id);
        $errors = [];

        if (!$category) {
            $_SESSION['error'] = "Không tìm thấy danh mục!";
            header('Location: index.php?controller=category');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if ($name === '') {
                $errors['name'] = 'Tên danh mục không được để trống!';
            } elseif ($this->categoryModel->checkCategoryExists($name, $id)) {
                $errors['name'] = 'Danh mục này đã tồn tại!';
            }

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description
                ];
                if ($this->categoryModel->updateCategory($id, $data)) {
                    $_SESSION['success'] = "Cập nhật danh mục thành công!";
                    header('Location: index.php?controller=category');
                    exit;
                } else {
                    $errors['general'] = "Có lỗi xảy ra khi cập nhật danh mục!";
                }
            }
            // Cập nhật lại dữ liệu nhập khi có lỗi
            $category['name'] = $name;
            $category['description'] = $description;
        }
        require_once __DIR__ . '/../views/category/edit.php';
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $result = $this->categoryModel->deleteCategory($id);

        // Luôn chuyển hướng về trang quản lý danh mục
        header('Location: index.php?controller=category');
        exit;
    }

    private function createSlug($str)
    {
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
