<?php
require_once '../commons/Database.php';

$db = Database::getInstance();

// Test đăng nhập
$username = 'admin';
$password = 'password';

echo "<h3>Test đăng nhập với:</h3>";
echo "Username: " . $username . "<br>";
echo "Password: " . $password . "<br><br>";

// Tìm user trong database
$sql = "SELECT * FROM users WHERE username = ? AND role = 'admin'";
$user = $db->queryOne($sql, [$username]);

if ($user) {
    echo "<h3>Tìm thấy user trong database:</h3>";
    echo "<pre>";
    print_r($user);
    echo "</pre>";
    
    // Kiểm tra mật khẩu
    $verify = password_verify($password, $user['password']);
    echo "<h3>Kết quả verify password:</h3>";
    echo $verify ? "TRUE - Mật khẩu khớp" : "FALSE - Mật khẩu không khớp";
    
    if ($verify) {
        echo "<br><br>Đăng nhập thành công!";
    } else {
        echo "<br><br>Đăng nhập thất bại - Mật khẩu không đúng!";
    }
} else {
    echo "<h3>Không tìm thấy user trong database!</h3>";
    echo "SQL Query: " . $sql . "<br>";
    echo "Username: " . $username;
}
?> 