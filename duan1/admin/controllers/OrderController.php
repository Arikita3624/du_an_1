<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../../commons/helpers.php';

class OrderController
{
    private $orderModel;
    private $itemsPerPage = 10; // Số đơn hàng hiển thị trên mỗi trang

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        // Lấy các tham số tìm kiếm và phân trang
        $keyword = $_GET['keyword'] ?? '';
        $status = $_GET['status'] ?? '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, $page); // Đảm bảo trang không nhỏ hơn 1

        // Lấy tổng số đơn hàng để tính số trang
        $totalOrders = $this->orderModel->getTotalOrders($keyword, $status);
        $totalPages = ceil($totalOrders / $this->itemsPerPage);

        // Lấy danh sách đơn hàng cho trang hiện tại
        $orders = $this->orderModel->getOrders($keyword, $status, $page, $this->itemsPerPage);

        require_once __DIR__ . '/../views/order/index.php';
    }

    public function view()
    {
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

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $newStatus = $_POST['status'] ?? '';

            // Lấy thông tin đơn hàng hiện tại để kiểm tra trạng thái cũ
            $order = $this->orderModel->getOrderById($id);

            if (!$order) {
                $_SESSION['error'] = "Không tìm thấy đơn hàng!";
                header('Location: index.php?controller=order');
                exit;
            }

            $currentStatus = $order['status'];

            // Định nghĩa thứ tự các trạng thái
            $statusOrder = ['pending', 'processing', 'delivering', 'completed'];

            // Kiểm tra xem trạng thái mới có hợp lệ theo thứ tự không
            $isUpdateAllowed = false;

            // Không cho phép admin cập nhật sang trạng thái "cancelled"
            if ($newStatus === 'cancelled') {
                $_SESSION['error'] = "Chỉ khách hàng mới được phép huỷ đơn hàng!";
                header('Location: index.php?controller=order&action=view&id=' . $id);
                exit;
            }

            // Không cho phép cập nhật sang trạng thái "finished" (chỉ khi khách xác nhận đã nhận hàng)
            if ($newStatus === 'finished') {
                $_SESSION['error'] = "Đơn hàng chỉ hoàn thành khi khách hàng xác nhận đã nhận hàng!";
                header('Location: index.php?controller=order&action=view&id=' . $id);
                exit;
            }

            // Trường hợp cập nhật theo luồng thông thường
            $currentIndex = array_search($currentStatus, $statusOrder);
            $newIndex = array_search($newStatus, $statusOrder);

            // Chỉ cho phép chuyển sang trạng thái kế tiếp
            if ($newIndex !== false && $currentIndex !== false && $newIndex === $currentIndex + 1) {
                $isUpdateAllowed = true;
            } else {
                $_SESSION['error'] = "Không thể cập nhật trạng thái từ '" . getStatusText($currentStatus) . "' sang '" . getStatusText($newStatus) . "'! Vui lòng cập nhật theo đúng thứ tự.";
                header('Location: index.php?controller=order&action=view&id=' . $id);
                exit;
            }

            // Thực hiện cập nhật nếu được phép
            if ($this->orderModel->updateOrderStatus($id, $newStatus)) {
                // Chỉ cập nhật trạng thái thanh toán thành paid khi trạng thái là finished
                if ($newStatus === 'finished') {
                    $this->orderModel->updatePaymentStatus($id, 'paid');
                }
                // Nếu trạng thái mới là cancelled thì cập nhật trạng thái thanh toán thành failed
                if ($newStatus === 'cancelled') {
                    $this->orderModel->updatePaymentStatus($id, 'failed');
                }
                $_SESSION['success'] = "Cập nhật trạng thái đơn hàng thành công!";
                header('Location: index.php?controller=order');
                exit;
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật trạng thái đơn hàng!";
                header('Location: index.php?controller=order');
                exit;
            }

            // Chuyển hướng trở lại trang chi tiết đơn hàng để thấy kết quả
            header('Location: index.php?controller=order&action=view&id=' . $id);
            exit;
        }
        // Nếu không phải POST request, chuyển hướng về danh sách đơn hàng
        header('Location: index.php?controller=order');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? 0;
        $result = $this->orderModel->deleteOrder($id);
        if ($result) {
            header('Location: index.php?controller=order');
            exit;
        }
    }
}
