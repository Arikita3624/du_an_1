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
        require_once __DIR__ . '/../views/pages/ProductDetail.php';
    }
}
