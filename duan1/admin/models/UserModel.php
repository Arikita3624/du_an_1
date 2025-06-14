<?php
require_once __DIR__ . '/../../commons/Database.php';

class UserModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getUserCount()
    {
        $sql = "SELECT COUNT(*) as count FROM users";
        $result = $this->db->queryOne($sql);
        return $result['count'];
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        return $this->db->query($sql);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->db->queryOne($sql, ['id' => $id]);
    }

    public function createUser($data)
    {
        $sql = "INSERT INTO users (username, password, full_name, email, phone, address, role, created_at)
                VALUES (:username, :password, :full_name, :email, :phone, :address, :role, NOW())";

        // Mã hóa mật khẩu
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        return $this->db->execute($sql, $data);
    }

    public function updateUser($id, $data)
    {
        $sql = "UPDATE users SET
                full_name = :full_name,
                email = :email,
                phone = :phone,
                address = :address,
                role = :role,
                updated_at = NOW()
                WHERE id = :id";

        $data['id'] = $id;
        return $this->db->execute($sql, $data);
    }

    public function updatePassword($id, $newPassword)
    {
        $sql = "UPDATE users SET
                password = :password,
                updated_at = NOW()
                WHERE id = :id";

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        return $this->db->execute($sql, [
            'id' => $id,
            'password' => $hashedPassword
        ]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = :username";
        $user = $this->db->queryOne($sql, ['username' => $username]);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function checkUsernameExists($username, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE username = :username";
        $params = ['username' => $username];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = $this->db->queryOne($sql, $params);
        return $result['count'] > 0;
    }

    public function checkEmailExists($email, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) as count FROM users WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        $result = $this->db->queryOne($sql, $params);
        return $result['count'] > 0;
    }

    public function searchUsers($keyword)
    {
        $sql = "SELECT * FROM users
                WHERE username LIKE :keyword
                OR full_name LIKE :keyword
                OR email LIKE :keyword
                OR phone LIKE :keyword
                OR address LIKE :keyword
                ORDER BY created_at DESC";
        return $this->db->query($sql, ['keyword' => '%' . $keyword . '%']);
    }

    public function toggleUserStatus($id)
    {
        $sql = "UPDATE users SET
                status = CASE WHEN status = 'active' THEN 'locked' ELSE 'active' END,
                updated_at = NOW()
                WHERE id = :id";
        return $this->db->execute($sql, ['id' => $id]);
    }

    public function getUserStatus($id)
    {
        $sql = "SELECT status FROM users WHERE id = :id";
        $result = $this->db->queryOne($sql, ['id' => $id]);
        return $result ? $result['status'] : null;
    }

    public function updateUserRole($id, $role)
    {
        $sql = "UPDATE users SET
                role = :role,
                updated_at = NOW()
                WHERE id = :id";
        return $this->db->execute($sql, [
            'id' => $id,
            'role' => $role
        ]);
    }
    public function getTopBuyers($limit = 5)
    {
        $limit = (int)$limit;
        $sql = "SELECT u.id, u.full_name, u.email, COUNT(o.id) AS total_orders, SUM(o.total_price) AS total_spent
            FROM users u
            JOIN orders o ON u.id = o.user_id
            WHERE o.status IN ('finished', 'completed')
            GROUP BY u.id, u.full_name, u.email
            ORDER BY total_orders DESC, total_spent DESC
            LIMIT $limit";
        return $this->db->query($sql);
    }

    public function getTopBuyersByDate($startDate, $endDate, $limit = 5)
    {
        $sql = "SELECT u.id, u.full_name, u.email, COUNT(o.id) AS total_orders, SUM(o.total_price) AS total_spent
        FROM users u
        JOIN orders o ON u.id = o.user_id
        WHERE o.status IN ('finished', 'completed')
          AND o.created_at BETWEEN :start AND :end
        GROUP BY u.id, u.full_name, u.email
        ORDER BY total_orders DESC, total_spent DESC
        LIMIT $limit";
        return $this->db->query($sql, ['start' => $startDate, 'end' => $endDate]);
    }
}
