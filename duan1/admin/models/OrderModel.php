<?php
require_once __DIR__ . '/../../commons/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllOrders() {
        $sql = "SELECT o.*, u.full_name as customer_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        return $this->db->query($sql);
    }

    public function getTotalOrders($keyword = '', $status = '') {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (full_name LIKE ? OR email LIKE ? OR phone LIKE ?)";
            $keyword = "%$keyword%";
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        if (!empty($status)) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        try {
            $result = $this->db->queryOne($sql, $params);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function getOrders($keyword = '', $status = '', $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT o.*, 
                COALESCE(SUM(oi.quantity * oi.price), 0) as total_amount,
                COALESCE(u.full_name, o.full_name) as customer_name
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id
                LEFT JOIN users u ON o.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND (o.full_name LIKE ? OR o.email LIKE ? OR o.phone LIKE ? OR u.full_name LIKE ?)";
            $keyword = "%$keyword%";
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        if (!empty($status)) {
            $sql .= " AND o.status = ?";
            $params[] = $status;
        }

        $sql .= " GROUP BY o.id ORDER BY o.created_at DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;

        try {
            return $this->db->query($sql, $params);
        } catch (Exception $e) {
            error_log("Lỗi khi lấy danh sách đơn hàng admin: " . $e->getMessage());
            return [];
        }
    }

    public function getOrderById($id) {
        $sql = "SELECT o.*, 
                COALESCE(SUM(oi.quantity * oi.price), 0) as total_amount,
                COALESCE(u.full_name, o.full_name) as full_name,
                COALESCE(u.address, o.address) as address
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                LEFT JOIN users u ON o.user_id = u.id
                WHERE o.id = :id 
                GROUP BY o.id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.name as product_name, p.image 
                FROM order_items oi 
                LEFT JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = :order_id";
        return $this->db->query($sql, ['order_id' => $orderId]);
    }

    public function updateOrderStatus($id, $status) {
        $sql = "UPDATE orders SET status = :status, updated_at = NOW() WHERE id = :id";
        return $this->db->execute($sql, [
            'id' => $id,
            'status' => $status
        ]);
    }

    public function deleteOrder($id) {
        // Xóa các order items trước
        $sql = "DELETE FROM order_items WHERE order_id = :id";
        $this->db->execute($sql, ['id' => $id]);
        
        // Sau đó xóa order
        $sql = "DELETE FROM orders WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    public function getOrderStatistics() {
        try {
        $sql = "SELECT 
                        COUNT(DISTINCT o.id) as total_orders,
                        COALESCE(SUM(oi.quantity * oi.price), 0) as total_revenue
                    FROM orders o 
                    LEFT JOIN order_items oi ON o.id = oi.order_id
                    WHERE o.status != 'cancelled'";
            $result = $this->db->queryOne($sql);
            
            if (!$result) {
                return [
                    'total_orders' => 0,
                    'total_revenue' => 0
                ];
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Lỗi khi lấy thống kê đơn hàng: " . $e->getMessage());
            return [
                'total_orders' => 0,
                'total_revenue' => 0
            ];
        }
    }

    public function getLatestOrders($limit = 5) {
        $sql = "SELECT o.*, 
                       COALESCE(SUM(oi.quantity * oi.price), 0) as total_amount,
                       u.full_name 
                FROM orders o 
                LEFT JOIN order_items oi ON o.id = oi.order_id 
                LEFT JOIN users u ON o.user_id = u.id 
                GROUP BY o.id 
                ORDER BY o.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }
} 