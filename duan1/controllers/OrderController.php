<?php
// controllers/OrderController.php
require_once __DIR__ . '/../models/Checkout.php';

class OrderController
{
    private $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
    }

    public function list()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }
        $user_id = $_SESSION['user']['id'];
        $orders = $this->checkoutModel->getOrdersByUserId($user_id);
        require_once __DIR__ . '/../views/pages/OrderList.php';
    }
    public function view()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        $order_id = $_POST['order_id'] ?? ($_GET['order_id'] ?? null);
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

            // Lấy lý do hủy (nếu có)
            $cancel_reason = $_POST['cancel_reason'] ?? null;

            // Cập nhật trạng thái đơn hàng
            $result = $this->checkoutModel->updateOrderStatus($order_id, 'cancelled', $cancel_reason);
            error_log("Update result: " . ($result ? 'true' : 'false'));

            if ($result) {
                // HOÀN LẠI SỐ LƯỢNG SẢN PHẨM
                require_once __DIR__ . '/../models/Client.php';
                $productModel = new ProductModels();
                $order_details = $this->checkoutModel->getOrderDetails($order_id);
                foreach ($order_details as $item) {
                    $product = $productModel->getById($item['product_id']);
                    if ($product) {
                        $newStock = $product['stock'] + $item['quantity'];
                        $productModel->updateStock($item['product_id'], $newStock);
                    }
                }

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

    public function markAsReceived()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
            $order_id = intval($_POST['order_id']);
            $user_id = $_SESSION['user']['id'];

            $order = $this->checkoutModel->getOrderById($order_id);

            // Kiểm tra đơn hàng tồn tại, thuộc về user và ở trạng thái 'completed'
            if ($order && $order['user_id'] == $user_id && $order['status'] === 'completed') {
                // Cập nhật trạng thái sang 'finished'
                $result = $this->checkoutModel->updateOrderStatus($order_id, 'finished');

                if ($result) {
                    $_SESSION['success'] = "Đã xác nhận nhận hàng!";
                } else {
                    $_SESSION['error'] = "Có lỗi xảy ra khi xác nhận nhận hàng.";
                }
            } else if ($order && $order['user_id'] == $user_id && $order['status'] !== 'completed') {
                $_SESSION['error'] = "Đơn hàng chưa ở trạng thái sẵn sàng để xác nhận nhận hàng.";
            } else {
                $_SESSION['error'] = "Không tìm thấy đơn hàng hoặc bạn không có quyền thao tác.";
            }

            // Chuyển hướng về trang chi tiết đơn hàng
            header('Location: index.php?act=order-confirmation&order_id=' . $order_id);
            exit;
        }

        // Nếu không phải POST request hợp lệ, chuyển hướng về danh sách đơn hàng
        header('Location: ?act=order-list');
        exit;
    }
}
