<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class ProductController
{
    private $productModel;
    private $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $limit = 10; // Số sản phẩm trên mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $keyword = $_GET['keyword'] ?? null;
        $categoryId = $_GET['category_id'] ?? null;

        // Lấy tổng số sản phẩm (có filter)
        $totalProducts = $this->productModel->getProductCount($keyword, $categoryId);
        $totalPages = ceil($totalProducts / $limit);

        // Lấy danh sách sản phẩm cho trang hiện tại (có filter)
        $products = $this->productModel->getProductsWithPagination($limit, $offset, $keyword, $categoryId, 'DESC');

        // Lấy danh sách danh mục cho bộ lọc
        $categories = $this->categoryModel->getAllCategories();

        require_once __DIR__ . '/../views/product/index.php';
    }

    public function create()
    {
        $categories = $this->categoryModel->getAllCategories();
        $errors = [];
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $category_id = $_POST['category_id'] ?? '';
            $stock = trim($_POST['stock'] ?? '');

            // Validate từng trường
            if ($name === '') {
                $errors['name'] = 'Tên sản phẩm không được để trống!';
            }
            if ($price === '' || !is_numeric($price) || $price <= 0) {
                $errors['price'] = 'Giá phải là số dương!';
            }
            if ($category_id === '' || !is_numeric($category_id)) {
                $errors['category_id'] = 'Vui lòng chọn danh mục!';
            }
            if ($stock === '' || !is_numeric($stock) || $stock < 0) {
                $errors['stock'] = 'Tồn kho phải là số không âm!';
            }

            // Xử lý upload ảnh (nếu cần kiểm tra lỗi ảnh, thêm vào $errors['image'])
            $image = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $uploadFile = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $image = 'uploads/products/' . $fileName;
                } else {
                    $errors['image'] = "Lỗi upload ảnh!";
                }
            }

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'category_id' => $category_id,
                    'stock' => $stock,
                    'image' => $image
                ];
                if ($this->productModel->createProduct($data)) {
                    $success = "Thêm sản phẩm thành công!";
                } else {
                    $errors['general'] = "Có lỗi xảy ra khi thêm sản phẩm!";
                }
            }
        }
        require_once __DIR__ . '/../views/product/create.php';
    }
    public function edit()
    {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getProductById($id);
        $categories = $this->categoryModel->getAllCategories();
        $errors = [];
        $success = '';

        if (!$product) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm!";
            header('Location: index.php?controller=product');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $category_id = $_POST['category_id'] ?? '';
            $stock = trim($_POST['stock'] ?? '');

            // Validate từng trường
            if ($name === '') {
                $errors['name'] = 'Tên sản phẩm không được để trống!';
            }
            if ($price === '' || !is_numeric($price) || $price <= 0) {
                $errors['price'] = 'Giá phải là số dương!';
            }
            if ($category_id === '' || !is_numeric($category_id)) {
                $errors['category_id'] = 'Vui lòng chọn danh mục!';
            }
            if ($stock === '' || !is_numeric($stock) || $stock < 0) {
                $errors['stock'] = 'Tồn kho phải là số không âm!';
            }

            // Xử lý upload ảnh (nếu cần kiểm tra lỗi ảnh, thêm vào $errors['image'])
            $image = $product['image'];
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
                    $image = 'uploads/products/' . $fileName;
                } else {
                    $errors['image'] = "Lỗi upload ảnh!";
                }
            }

            if (empty($errors)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'category_id' => $category_id,
                    'stock' => $stock,
                    'image' => $image
                ];
                if ($this->productModel->updateProduct($id, $data)) {
                    $_SESSION['success'] = "Cập nhật sản phẩm thành công!";
                    header('Location: index.php?controller=product');
                    exit;
                } else {
                    $errors['general'] = "Có lỗi xảy ra khi cập nhật sản phẩm!";
                }
            }
            // Cập nhật lại $product để giữ giá trị nhập lại khi có lỗi
            $product = array_merge($product, [
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'stock' => $stock,
                'image' => $image
            ]);
        }
        require_once __DIR__ . '/../views/product/edit.php';
    }

    public function delete()
    {
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

    public function detail()
    {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->getProductById($id);
        require_once __DIR__ . '/../views/Product/detail.php';
    }
}
