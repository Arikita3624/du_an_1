<?php
require_once __DIR__ . '/../models/OrderModel.php';

class OrderController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        require_once __DIR__ . '/../views/order/index.php';
    }

    public function view() {
        $id = $_GET['id'] ?? 0;
        $order = $this->orderModel->getOrderById($id);
        
        if (!$order) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng!";
            header('Location: index.php?controller=order');
            exit;
        }

        $orderItems = $this->orderModel->getOrderItems($id);
        require_once __DIR__ . '/../views/order/view.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $status = $_POST['status'] ?? '';
            
            if ($this->orderModel->updateOrderStatus($id, $status)) {
                $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công!";
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật trạng thái đơn hàng!";
            }
        }
        header('Location: index.php?controller=order');
        exit;
    }

    public function delete() {
        $id = $_GET['id'] ?? 0;
        $result = $this->orderModel->deleteOrder($id);
        if ($result) {
            header('Location: index.php?controller=order');
            exit;
        }
    }
} 