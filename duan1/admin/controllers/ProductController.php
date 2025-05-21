<?php

class ProductController{
  private $productModel;
  
  public function __construct() {
    $this->productModel = new ProductModel();
  }
  
  public function getAllProduct(){
    $products = $this->productModel->get_list();
    
    require_once 'views/Product/list.php';
  }
}