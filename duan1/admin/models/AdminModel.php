<?php
class AdminModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function login($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = ?";
        $admin = $this->db->queryOne($sql, [$username]);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }
        return false;
    }

    public function getAdminById($id) {
        $sql = "SELECT * FROM admins WHERE id = ?";
        return $this->db->queryOne($sql, [$id]);
    }

    public function updateLastLogin($id) {
        $sql = "UPDATE admins SET last_login = NOW() WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}
?> 