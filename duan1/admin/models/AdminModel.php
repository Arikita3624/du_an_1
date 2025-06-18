<?php
class AdminModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->queryOne($sql, [$username]);
        if (!$user) {
            return ['status' => 'not_found'];
        }
        if ($user['role'] !== 'admin') {
            return ['status' => 'not_admin'];
        }
        if (!password_verify($password, $user['password'])) {
            return ['status' => 'wrong_password'];
        }
        return ['status' => 'success', 'user' => $user];
    }

    public function getAdminById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ? AND role = 'admin'";
        return $this->db->queryOne($sql, [$id]);
    }

    public function updateLastLogin($id)
    {
        $sql = "UPDATE users SET last_login = NOW() WHERE id = ? AND role = 'admin'";
        return $this->db->execute($sql, [$id]);
    }
}
