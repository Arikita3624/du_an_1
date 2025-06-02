<?php

class CheckoutModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function saveOrder($user_id, $full_name, $email, $phone, $address, $total_price, $payment_method, $order_notes)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO orders (user_id, full_name, email, phone, address, total_price, status, payment_status, payment_method, note, created_at, updated_at)
            VALUES (:user_id, :full_name, :email, :phone, :address, :total_price, 'pending', 'pending', :payment_method, :note, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"
        );
        $stmt->execute([
            ':user_id' => $user_id,
            ':full_name' => $full_name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':total_price' => $total_price,
            ':payment_method' => $payment_method,
            ':note' => $order_notes
        ]);
        return $this->conn->lastInsertId();
    }

    public function saveOrderDetails($order_id, $cartItems)
    {
        foreach ($cartItems as $item) {
            $stmt = $this->conn->prepare(
                "INSERT INTO order_items (order_id, product_id, quantity, price, total_price)
                VALUES (:order_id, :product_id, :quantity, :price, :total_price)"
            );
            $stmt->execute([
                ':order_id' => $order_id,
                ':product_id' => $item['product_id'],
                ':quantity' => $item['quantity'],
                ':price' => $item['price'],
                ':total_price' => $item['total_price']
            ]);
        }
    }
    public function getOrderById($order_id)
    {
        $stmt = $this->conn->prepare("
            SELECT o.*, u.full_name, u.email, u.phone, u.address 
            FROM orders o
            LEFT JOIN users u ON o.user_id = u.id
            WHERE o.id = :order_id
        ");
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($order_id)
    {
        $stmt = $this->conn->prepare("
            SELECT oi.*, p.name, p.image 
            FROM order_items oi
            LEFT JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute([':order_id' => $order_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getOrdersByUserId($user_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute([':user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($order_id, $status)
    {
        try {
            $stmt = $this->conn->prepare("
                UPDATE orders 
                SET status = :status, 
                    updated_at = CURRENT_TIMESTAMP 
                WHERE id = :order_id
            ");
            return $stmt->execute([
                ':status' => $status,
                ':order_id' => $order_id
            ]);
        } catch (PDOException $e) {
            error_log("Error updating order status: " . $e->getMessage());
            return false;
        }
    }
}
