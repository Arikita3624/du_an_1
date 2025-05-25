<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/../models/Client.php';


class ProductControllerCLient
{
    public function list()
    {
        $categoryModel = new Category();
        $productModel = new Product();

        $categories = $categoryModel->getAll();
        $search = $_GET['search'] ?? '';
        $price = $_GET['price'] ?? '';
        $category_id = $_GET['category_id'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = 12;
        $offset = ($page - 1) * $limit;

        $products = $productModel->getFiltered($search, $price, $category_id, $limit, $offset);
        $total = $productModel->countFiltered($search, $price, $category_id);

        require __DIR__ . '/../views/pages/ProductsList.php';
    }
}

class ProductDetailController
{
    public function index()
    {
        // Get product ID from URL
        $product_id = $_GET['id'] ?? null;

        if (!$product_id) {
            // Redirect or show error if product ID is missing
            $_SESSION['message'] = 'Không tìm thấy ID sản phẩm!';
            $_SESSION['message_type'] = 'error';
            header('Location: /DUAN1/du_an_1/duan1/?act=product-list'); // Redirect to product list
            exit();
        }

        try {
            // Load Product Model
            require_once __DIR__ . '/../models/Client.php'; // Product class is in Client.php
            $productModel = new Product();

            // Get product details by ID
            $product = $productModel->getById($product_id);

            if (!$product) {
                // Redirect or show error if product not found
                $_SESSION['message'] = 'Sản phẩm không tồn tại!';
                $_SESSION['message_type'] = 'error';
                header('Location: /DUAN1/du_an_1/duan1/?act=product-list'); // Redirect to product list
                exit();
            }

            // Get related products
            $relatedProducts = $productModel->getRelatedProducts($product['id'], $product['category_id']);

            // Load the view and pass the product data
            require_once __DIR__ . '/../views/pages/ProductDetail.php';
        } catch (Exception $e) {
            // Display any errors during data fetching or view loading
            echo "<div style=\"color: red; padding: 10px; border: 1px solid red;\">";
            echo "Lỗi khi xem chi tiết sản phẩm: " . htmlspecialchars($e->getMessage());
            echo "</div>";
             // Log the error for debugging on the server side
             error_log("Product Detail Error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }
}
