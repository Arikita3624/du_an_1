<?php
class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($username, $password) {
        // Debug chi tiết
        error_log("=== DEBUG LOGIN PROCESS ===");
        error_log("Username nhập vào: " . $username);
        error_log("Password nhập vào: " . $password);
        
        $sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
        error_log("SQL Query: " . $sql);
        
        $admin = $this->db->queryOne($sql, [$username]);
        
        if ($admin) {
            error_log("Tìm thấy user trong database:");
            error_log("User data: " . print_r($admin, true));
            error_log("Password hash trong DB: " . $admin['password']);
            
            $verify_result = password_verify($password, $admin['password']);
            error_log("Kết quả verify password: " . ($verify_result ? "TRUE" : "FALSE"));
            
            if ($verify_result) {
                error_log("Đăng nhập thành công!");
                return $admin;
            } else {
                error_log("Mật khẩu không khớp!");
            }
        } else {
            error_log("KHÔNG tìm thấy user trong database!");
        }
        
        return false;
    }

    public function getAdminById($id) {
        $sql = "SELECT * FROM users WHERE id = ? AND role = 'admin'";
        return $this->db->queryOne($sql, [$id]);
    }

    public function updateLastLogin($id) {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ? AND role = 'admin'";
        return $this->db->execute($sql, [$id]);
    }
}
?> 