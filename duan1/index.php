<?php

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/HomeController.php';
require_once './controllers/AboutsController.php';
require_once './controllers/ProductController.php';
require_once './controllers/CartsController.php';
require_once './controllers/CheckoutController.php';
require_once './controllers/AuthController.php';

// Require toàn bộ file Models

// Route
$act = $_GET['act'] ?? '/';

require_once __DIR__ . '/views/layouts/layouttop.php';

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/'                 => (new HomeController())->index(),
    'about' => (new AboutsController())->index(),
    'product-list' =>(new ProductController()) -> index(),
    'product-detail' =>(new ProductDetailController()) -> index(),
    'carts' => (new CartsController()) -> index(),
    'checkout' => (new CheckoutController()) -> index(),
    'login' => (new SignInController()) -> index(),
    'register' => (new SignUpController()) -> index(),
};

require_once __DIR__ . '/views/layouts/layoutbottom.php';