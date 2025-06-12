<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class DashboardController
{
    private $orderModel;
    private $productModel;
    private $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $orderStats = $this->orderModel->getOrderStatistics();
        $orderStatusCounts = $this->orderModel->getOrderStatusCounts();
        $productCount = $this->productModel->getProductCount();
        $userCount = $this->userModel->getUserCount();
        $latestOrders = $this->orderModel->getLatestOrders(5);
        $bestSellingProducts = $this->productModel->getBestSellingProducts(5);
        $topBuyers = $this->userModel->getTopBuyers(5);

        // Truyền biến sang view
        require_once __DIR__ . '/../views/dashboard.php';
    }

    private function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'pending':
                return 'warning';
            case 'processing':
                return 'info';
            case 'delivering':
                return 'primary';
            case 'completed':
                return 'success';
            case 'finished':
                return 'success';
            case 'cancelled':
                return 'danger';
            default:
                return 'secondary';
        }
    }

    private function getStatusText($status)
    {
        switch ($status) {
            case 'pending':
                return 'Chờ xử lý';
            case 'processing':
                return 'Đang xử lý';
            case 'delivering':
                return 'Đang giao hàng';
            case 'completed':
                return 'Đã giao hàng';
            case 'finished':
                return 'Hoàn thành';
            case 'cancelled':
                return 'Đã hủy';
            default:
                return 'Không xác định';
        }
    }
}
