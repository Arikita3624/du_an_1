<?php

class ProductModel{
  private $conn;

  public function __construct() {
    $this->conn = connectDB();
  }

  public function get_list(){
      $sql = "SELECT 
                  id, 
                  name, 
                  price, 
                  quantity
              FROM products";
      $data = $this->conn->prepare($sql);
      $data->execute();
      return $data->fetchAll(PDO::FETCH_ASSOC);
  }
}