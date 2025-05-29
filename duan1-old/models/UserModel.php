<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($username, $password) {
        try {
            // Debug
            error_log("Attempting login for username: " . $username);
            
            // Kiểm tra username trước
            $sql = "SELECT * FROM users WHERE username = ?";
            $user = $this->db->queryOne($sql, [$username]);
            
            if (!$user) {
                error_log("User not found: " . $username);
                return false;
            }

            // Kiểm tra password
            if (!password_verify($password, $user['password'])) {
                error_log("Invalid password for user: " . $username);
                return false;
            }

            // Kiểm tra trạng thái
            if ($user['status'] !== 'active') {
                error_log("User is not active: " . $username);
                return false;
            }

            // Cập nhật last_login
            $this->updateLastLogin($user['id']);
            
            error_log("Login successful for user: " . $username);
            return $user;
        } catch (Exception $e) {
            error_log("Login error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        return $this->db->queryOne($sql, [$id]);
    }

    public function updateLastLogin($id) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO users (username, password, email, full_name, phone, address, role, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [
            $data['username'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['email'],
            $data['full_name'],
            $data['phone'],
            $data['address'],
            $data['role'] ?? 'user',
            $data['status'] ?? 'active'
        ];
        return $this->db->execute($sql, $params);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET 
                email = ?, 
                full_name = ?, 
                phone = ?, 
                address = ?, 
                role = ?, 
                status = ? 
                WHERE id = ?";
        $params = [
            $data['email'],
            $data['full_name'],
            $data['phone'],
            $data['address'],
            $data['role'],
            $data['status'],
            $id
        ];
        return $this->db->execute($sql, $params);
    }

    public function updatePassword($id, $newPassword) {
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        return $this->db->execute($sql, [password_hash($newPassword, PASSWORD_DEFAULT), $id]);
    }

    public function getAll($search = '') {
        $sql = "SELECT * FROM users WHERE 1=1";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (username LIKE ? OR email LIKE ? OR full_name LIKE ? OR phone LIKE ?)";
            $search = "%$search%";
            $params = [$search, $search, $search, $search];
        }
        
        $sql .= " ORDER BY id DESC";
        return $this->db->query($sql, $params);
    }
} 