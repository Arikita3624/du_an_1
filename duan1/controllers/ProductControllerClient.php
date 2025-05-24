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
    $productModel = new Product();
    $categoryModel = new Category();

    $id = $_GET['id'] ?? 0;
    $product = $productModel->getById($id);

    if (!$product) {
        // Xử lý khi không tìm thấy sản phẩm
        die('Không tìm thấy sản phẩm!');
    }

    // Lấy sản phẩm tương tự cùng danh mục (trừ sản phẩm hiện tại)
    $relatedProducts = $productModel->getRelated($product['category_id'], $product['id']);

    $categories = $categoryModel->getAll(); // Nếu cần danh mục

    require_once __DIR__ . '/../views/pages/ProductDetail.php';
}
}
