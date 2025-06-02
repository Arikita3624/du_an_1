<?php
require_once '../commons/Database.php';

$db = Database::getInstance();

// Thông tin tài khoản user
$username = 'user1';
$password = '123456';
$full_name = 'Người Dùng 1';
$email = 'user1@gmail.com';
$phone = '0123456789';
$address = 'Hà Nội';

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Kiểm tra xem username đã tồn tại chưa
$check_sql = "SELECT * FROM users WHERE username = ?";
$existing_user = $db->queryOne($check_sql, [$username]);

if ($existing_user) {
    // Nếu user đã tồn tại, cập nhật thông tin
    $update_sql = "UPDATE users SET 
                   password = ?, 
                   full_name = ?,
                   email = ?,
                   phone = ?,
                   address = ?,
                   role = 'user',
                   status = 'active' 
                   WHERE username = ?";
    $result = $db->execute($update_sql, [
        $hashed_password,
        $full_name,
        $email,
        $phone,
        $address,
        $username
    ]);
    echo "Đã cập nhật thông tin tài khoản user!<br>";
} else {
    // Nếu user chưa tồn tại, tạo mới
    $insert_sql = "INSERT INTO users (
                   username, password, full_name, email, phone, address, role, status
                   ) VALUES (?, ?, ?, ?, ?, ?, 'user', 'active')";
    $result = $db->execute($insert_sql, [
        $username,
        $hashed_password,
        $full_name,
        $email,
        $phone,
        $address
    ]);
    echo "Đã tạo tài khoản user mới!<br>";
}

// Hiển thị thông tin tài khoản
echo "<h3>Thông tin tài khoản:</h3>";
echo "Username: " . $username . "<br>";
echo "Password: " . $password . "<br>";
echo "Full name: " . $full_name . "<br>";
echo "Email: " . $email . "<br>";
echo "Phone: " . $phone . "<br>";
echo "Address: " . $address . "<br>";
echo "Role: user<br>";
echo "Status: active<br><br>";

// Kiểm tra verify password
echo "<h3>Kiểm tra verify password:</h3>";
echo "Verify test: " . (password_verify($password, $hashed_password) ? "TRUE - Mật khẩu hợp lệ" : "FALSE - Mật khẩu không hợp lệ") . "<br><br>";

// Hiển thị tất cả user trong database
echo "<h3>Danh sách tất cả user:</h3>";
$all_users = $db->query("SELECT * FROM users WHERE role = 'user'");
if ($all_users) {
    echo "<pre>";
    print_r($all_users);
    echo "</pre>";
} else {
    echo "Không có user nào trong database";
}
?> 