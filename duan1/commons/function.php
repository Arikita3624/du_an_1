<?php

// Kết nối CSDL qua PDO
function connectDB() {
    // Kết nối CSDL
    $host = DB_HOST;
    $port = DB_PORT;
    $dbname = DB_NAME;

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", DB_USERNAME, DB_PASSWORD);

        // cài đặt chế độ báo lỗi là xử lý ngoại lệ
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // cài đặt chế độ trả dữ liệu
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Kiểm tra kết nối
        $test = $conn->query("SELECT 1");
        if (!$test) {
            throw new PDOException("Không thể thực hiện truy vấn test");
        }

        return $conn;
    } catch (PDOException $e) {
        error_log("Lỗi kết nối database: " . $e->getMessage());
        throw new Exception("Không thể kết nối đến database. Vui lòng thử lại sau.");
    }
}
