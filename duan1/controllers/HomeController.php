<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/../models/Client.php';

class HomeController
{
    public function index()
    {
        $productModel = new ProductModels();
        $latestProducts = $productModel->getLatest(8); // Lấy 8 sản phẩm mới nhất
        require_once __DIR__ . '/../views/pages/HomePage.php';
    }
}
