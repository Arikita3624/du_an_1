<?php
require_once '../commons/Database.php';

$db = Database::getInstance();

// Thông tin tài khoản admin
$username = 'admin3';
$password = '123456';
$full_name = 'Admin 3';
$email = 'admin3@example.com';

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Kiểm tra xem username đã tồn tại chưa
$check_sql = "SELECT * FROM users WHERE username = ?";
$existing_user = $db->queryOne($check_sql, [$username]);

if ($existing_user) {
    // Nếu user đã tồn tại, cập nhật mật khẩu
    $update_sql = "UPDATE users SET password = ?, role = 'admin', status = 'active' WHERE username = ?";
    $result = $db->execute($update_sql, [$hashed_password, $username]);
    echo "Đã cập nhật mật khẩu cho tài khoản admin!<br>";
} else {
    // Nếu user chưa tồn tại, tạo mới
    $insert_sql = "INSERT INTO users (username, password, full_name, email, role, status) 
                   VALUES (?, ?, ?, ?, 'admin', 'active')";
    $result = $db->execute($insert_sql, [$username, $hashed_password, $full_name, $email]);
    echo "Đã tạo tài khoản admin mới!<br>";
}

// Hiển thị thông tin tài khoản
echo "<h3>Thông tin tài khoản:</h3>";
echo "Username: " . $username . "<br>";
echo "Password: " . $password . "<br>";
echo "Password hash: " . $hashed_password . "<br><br>";

// Kiểm tra verify password
echo "<h3>Kiểm tra verify password:</h3>";
echo "Verify test: " . (password_verify($password, $hashed_password) ? "TRUE - Mật khẩu hợp lệ" : "FALSE - Mật khẩu không hợp lệ") . "<br><br>";

// Hiển thị tất cả admin trong database
echo "<h3>Danh sách tất cả admin:</h3>";
$all_admins = $db->query("SELECT * FROM users WHERE role = 'admin'");
if ($all_admins) {
    echo "<pre>";
    print_r($all_admins);
    echo "</pre>";
} else {
    echo "Không có admin nào trong database";
}
?> 