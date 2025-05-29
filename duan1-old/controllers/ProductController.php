<?php

class ProductController {
    public function index() {
        require_once __DIR__ . '/../views/pages/ProductsList.php';
    }
}

class ProductDetailController {
    public function index() {
       require_once __DIR__ . '/../views/pages/ProductDetail.php';
    }
}

?>