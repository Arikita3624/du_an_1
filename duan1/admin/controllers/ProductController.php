<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        require_once __DIR__ . '/../views/product/index.php';
    }

    public function create() {
        $categories = $this->categoryModel->getAllCategories();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'category_id' => $_POST['category_id'] ? (int)$_POST['category_id'] : null,
                'stock' => $_POST['stock'] ?? 0
            ];

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $data['image'] = 'uploads/products/' . $fileName;
                }
            }

            if ($this->productModel->createProduct($data)) {
                $_SESSION['success'] = "Thêm sản phẩm thành công!";
                header('Location: index.php?controller=product');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi thêm sản phẩm!";
            }
        }
        require_once __DIR__ . '/../views/product/create.php';
    }

    public function edit() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategories();
        
        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header('Location: index.php?controller=product');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'category_id' => $_POST['category_id'] ? (int)$_POST['category_id'] : null,
                'stock' => $_POST['stock'] ?? 0
            ];

            // Xử lý upload ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Xóa ảnh cũ nếu có
                    if (!empty($product['image'])) {
                        $oldFile = __DIR__ . '/../' . $product['image'];
                        if (file_exists($oldFile)) {
                            unlink($oldFile);
                        }
                    }
                    $data['image'] = 'uploads/products/' . $fileName;
                }
            }

            if ($this->productModel->updateProduct($id, $data)) {
                $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
                header('Location: index.php?controller=product');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật sản phẩm!";
            }
        }
        require_once __DIR__ . '/../views/product/edit.php';
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getProductById($id);
        
        if ($product) {
            // Xóa ảnh sản phẩm nếu có
            if (!empty($product['image'])) {
                $imageFile = __DIR__ . '/../' . $product['image'];
                if (file_exists($imageFile)) {
                    unlink($imageFile);
                }
            }
            
            if ($this->productModel->deleteProduct($id)) {
                $_SESSION['success'] = "Xóa sản phẩm thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi xóa sản phẩm!";
            }
        } else {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
        }
        
        header('Location: index.php?controller=product');
        exit;
    }
}


?>