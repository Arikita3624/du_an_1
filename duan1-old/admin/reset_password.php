<?php
require_once '../commons/Database.php';

$db = new Database();

// Tạo mật khẩu mới
$password = 'password';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cập nhật mật khẩu admin
$sql = "UPDATE admins SET password = ? WHERE username = 'admin'";
$result = $db->execute($sql, [$hashed_password]);

if ($result) {
    echo "Đã reset mật khẩu admin thành công!<br>";
    echo "Username: admin<br>";
    echo "Password: password";
} else {
    echo "Có lỗi xảy ra khi reset mật khẩu!";
}
?> 