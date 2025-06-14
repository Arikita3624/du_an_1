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
        // Lấy tham số lọc thời gian
        $startDate = $_GET['start_date'] ?? null;
        $endDate = $_GET['end_date'] ?? null;

        // Nếu chưa chọn, mặc định lấy 30 ngày gần nhất
        if (empty($startDate) || empty($endDate)) {
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', strtotime('-30 days'));
        }

        // Thống kê tổng quan (nếu muốn lọc theo thời gian thì truyền $startDate, $endDate vào các hàm)
        $orderStats = $this->orderModel->getOrderStatistics(); // tổng đơn hàng, tổng doanh thu (có thể thêm lọc nếu muốn)
        $orderStatusCounts = $this->orderModel->getOrderStatusCounts();
        $productCount = $this->productModel->getProductCount();
        $userCount = $this->userModel->getUserCount();

        // Dữ liệu theo thời gian
        $latestOrders = $this->orderModel->getLatestOrdersByDate($startDate, $endDate, 5);
        $bestSellingProducts = $this->productModel->getBestSellingProductsByDate($startDate, $endDate, 5);
        $topStockProducts = $this->productModel->getTopStockProducts(5); // tồn kho không lọc thời gian
        $topBuyers = $this->userModel->getTopBuyersByDate($startDate, $endDate, 5);

        // Biểu đồ doanh thu/ngày (nếu cần)
        $revenueByDate = $this->orderModel->getRevenueByDateRange($startDate, $endDate);
        $revenueLabels = array_column($revenueByDate, 'date');
        $revenueData = array_map('floatval', array_column($revenueByDate, 'revenue'));

        // Tổng doanh thu trong khoảng thời gian
        $totalRevenue = array_sum($revenueData);

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
