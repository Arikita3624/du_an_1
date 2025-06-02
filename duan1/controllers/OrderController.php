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

    public function view() {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        $order_id = $_GET['order_id'] ?? null;
        if (!$order_id) {
            header('Location: ?act=order-list');
            exit;
        }

        $user_id = $_SESSION['user']['id'];
        $order = $this->checkoutModel->getOrderById($order_id);

        // Kiểm tra xem đơn hàng có thuộc về user hiện tại không
        if (!$order || $order['user_id'] != $user_id) {
            $_SESSION['error'] = "Không tìm thấy đơn hàng";
            header('Location: ?act=order-list');
            exit;
        }

        // Debug: In ra thông tin request
        error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
        error_log("POST Data: " . print_r($_POST, true));
        error_log("Order Status: " . $order['status']);

        // Xử lý hủy đơn hàng
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cancel') {
            error_log("Processing cancel order request");
            
            // Kiểm tra trạng thái đơn hàng
            if (!in_array($order['status'], ['pending', 'processing'])) {
                $_SESSION['error'] = "Không thể hủy đơn hàng ở trạng thái này";
                header("Location: index.php?act=order-confirmation&order_id=$order_id");
                exit;
            }

            // Cập nhật trạng thái đơn hàng
            $result = $this->checkoutModel->updateOrderStatus($order_id, 'cancelled');
            error_log("Update result: " . ($result ? 'true' : 'false'));
            
            if ($result) {
                $_SESSION['success'] = "Đã hủy đơn hàng thành công";
                header('Location: index.php?act=order-list');
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi hủy đơn hàng";
                header("Location: index.php?act=order-confirmation&order_id=$order_id");
            }
            exit;
        }

        $order_details = $this->checkoutModel->getOrderDetails($order_id);
        require_once __DIR__ . '/../views/pages/OrderConfirmation.php';
    }
}