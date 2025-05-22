<?php
require_once __DIR__ . '/../../commons/Database.php';

class OrderModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getAllOrders() {
        $sql = "SELECT o.*, u.full_name as customer_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC";
        return $this->db->query($sql);
    }

    public function getOrderById($id) {
        $sql = "SELECT o.*, u.full_name as customer_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                WHERE o.id = :id";
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
        $sql = "SELECT 
                    COUNT(*) as total_orders,
                    COALESCE(SUM(total_amount), 0) as total_revenue
                FROM orders 
                WHERE status != 'cancelled'";
        return $this->db->queryOne($sql);
    }

    public function getLatestOrders($limit = 5) {
        $sql = "SELECT o.*, u.full_name 
                FROM orders o 
                LEFT JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }
} 