<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/../models/Client.php';

class HomeController
{
    public function index() {
        $model = new HomePageModels();
        $products = $model->getAllProducts(); // Lấy sản phẩm bán chạy
        require_once __DIR__ . '/../views/pages/HomePage.php';
    }
}