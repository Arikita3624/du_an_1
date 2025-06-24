<?php

class CheckoutModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function saveOrder($user_id, $full_name, $email, $phone, $address, $total_price, $payment_method, $order_reason)
    {
        $stmt = $this->conn->prepare(
            "INSERT INTO orders (user_id, full_name, email, phone, address, total_price, status, payment_status, payment_method, reason, created_at, updated_at)
            VALUES (:user_id, :full_name, :email, :phone, :address, :total_price, 'pending', 'pending', :payment_method, :reason, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)"
        );
        $stmt->execute([
            ':user_id' => $user_id,
            ':full_name' => $full_name,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':total_price' => $total_price,
            ':payment_method' => $payment_method,
            ':reason' => $order_reason
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
            SELECT o.*,
                   o.full_name,
                   o.email,
                   o.phone,
                   o.address
            FROM orders o
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

    public function updateOrderStatus($order_id, $status, $reason = null)
    {
        try {
            if ($status === 'cancelled') {
                $stmt = $this->conn->prepare("
                UPDATE orders
                SET status = :status,
                    payment_status = 'failed',
                    reason = :reason,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :order_id
            ");
                return $stmt->execute([
                    ':status' => $status,
                    ':reason' => $reason,
                    ':order_id' => $order_id
                ]);
            } elseif ($reason !== null) {
                $stmt = $this->conn->prepare("
                UPDATE orders
                SET status = :status,
                    reason = :reason,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = :order_id
            ");
                return $stmt->execute([
                    ':status' => $status,
                    ':reason' => $reason,
                    ':order_id' => $order_id
                ]);
            } else {
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
            }
        } catch (PDOException $e) {
            error_log("Error updating order status: " . $e->getMessage());
            return false;
        }
    }

    public function updateOrderStatusAndPayment($order_id, $status, $payment_status)
    {
        $sql = "UPDATE orders SET status = ?, payment_status = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $payment_status, $order_id]);
    }
    public function hasUserPurchasedProduct($user_id, $product_id)
    {
        $stmt = $this->conn->prepare("
        SELECT COUNT(*) as total
        FROM order_items oi
        JOIN orders o ON oi.order_id = o.id
        WHERE o.user_id = :user_id
          AND oi.product_id = :product_id
          AND o.status IN ('finished')
    ");
        $stmt->execute([
            ':user_id' => $user_id,
            ':product_id' => $product_id
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($row && $row['total'] > 0);
    }
}
