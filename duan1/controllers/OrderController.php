<?php
// controllers/OrderController.php
require_once __DIR__ . '/../models/Checkout.php';

class OrderController {
    private $checkoutModel;

    public function __construct() {
        $this->checkoutModel = new CheckoutModel();
    }

    public function list() {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }
        $user_id = $_SESSION['user']['id'];
        $orders = $this->checkoutModel->getOrdersByUserId($user_id);
        require_once __DIR__ . '/../views/pages/OrderList.php';
    }
}