<?php
class Database {
    private static $instance = null;
    private $host = 'localhost';
    private $db_name = 'base_du_an_1';
    private $username = 'root';
    private $password = '';
    private $conn;

    private function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log("Database connection error: " . $e->getMessage(), 0);
            // Store error in session for display
            if (!isset($_SESSION)) { session_start(); }
            $_SESSION['db_error_details'] = "Database connection error: " . $e->getMessage();
            die("Lỗi kết nối database. Vui lòng kiểm tra log hoặc thông báo lỗi chi tiết.");
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Database query error: " . $e->getMessage() . " in SQL: " . $sql, 0);
            // Store error in session for display
            if (!isset($_SESSION)) { session_start(); }
            $_SESSION['db_error_details'] = "Database query error: " . $e->getMessage() . " in SQL: " . $sql;
            return false;
        }
    }

    public function queryOne($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch(PDOException $e) {
            error_log("Database queryOne error: " . $e->getMessage() . " in SQL: " . $sql, 0);
            // Store error in session for display
            if (!isset($_SESSION)) { session_start(); }
            $_SESSION['db_error_details'] = "Database queryOne error: " . $e->getMessage() . " in SQL: " . $sql;
            return false;
        }
    }

    public function execute($sql, $params = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch(PDOException $e) {
            error_log("Database execute error: " . $e->getMessage() . " in SQL: " . $sql, 0);
            // Store error in session for display
             if (!isset($_SESSION)) { session_start(); }
            $_SESSION['db_error_details'] = "Database execute error: " . $e->getMessage() . " in SQL: " . $sql;
            return false;
        }
    }

    public function lastInsertId() {
        return $this->conn->lastInsertId();
    }

    public function beginTransaction() {
        return $this->conn->beginTransaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollBack() {
        return $this->conn->rollBack();
    }
}