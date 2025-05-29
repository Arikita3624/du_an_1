<?php
require_once '../commons/Database.php';

// Bật hiển thị lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = Database::getInstance();

// Thông tin đăng nhập test
$username = 'admin2'; // Thay đổi username này thành username bạn đang sử dụng
$password = '123456'; // Thay đổi password này thành password bạn đang sử dụng

echo "<h3>Thông tin đăng nhập test:</h3>";
echo "Username: " . $username . "<br>";
echo "Password: " . $password . "<br><br>";

// 1. Kiểm tra user trong database
$sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
$user = $db->queryOne($sql, [$username]);

echo "<h3>1. Kiểm tra user trong database:</h3>";
if ($user) {
    echo "Tìm thấy user:<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Username: " . $user['username'] . "<br>";
    echo "Password hash: " . $user['password'] . "<br>";
    echo "Role: " . $user['role'] . "<br>";
    echo "Status: " . $user['status'] . "<br><br>";
} else {
    echo "Không tìm thấy user với username: " . $username . "<br><br>";
}

// 2. Kiểm tra verify password
if ($user) {
    echo "<h3>2. Kiểm tra verify password:</h3>";
    $verify_result = password_verify($password, $user['password']);
    echo "Kết quả verify: " . ($verify_result ? "TRUE" : "FALSE") . "<br><br>";
}

// 3. Hiển thị tất cả admin trong database
echo "<h3>3. Danh sách tất cả admin trong database:</h3>";
$all_admins = $db->query("SELECT * FROM users WHERE role = 'admin'");
if ($all_admins) {
    echo "<pre>";
    print_r($all_admins);
    echo "</pre>";
} else {
    echo "Không có admin nào trong database<br>";
}

// 4. Kiểm tra cấu trúc bảng users
echo "<h3>4. Cấu trúc bảng users:</h3>";
$structure = $db->query("DESCRIBE users");
if ($structure) {
    echo "<pre>";
    print_r($structure);
    echo "</pre>";
} else {
    echo "Không thể lấy cấu trúc bảng users<br>";
}
?> 