<?php
require_once '../commons/Database.php';

$db = new Database();

// Kiểm tra xem đã có tài khoản admin chưa
$sql = "SELECT * FROM users WHERE username = 'admin' AND role = 'admin'";
$admin = $db->queryOne($sql);

if ($admin) {
    echo "Đã tồn tại tài khoản admin:<br>";
    echo "Username: " . $admin['username'] . "<br>";
    echo "Email: " . $admin['email'] . "<br>";
    echo "Role: " . $admin['role'] . "<br>";
    echo "Status: " . $admin['status'] . "<br>";
    
    // Reset mật khẩu
    $password = 'password';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $update_sql = "UPDATE users SET password = ? WHERE id = ?";
    $result = $db->execute($update_sql, [$hashed_password, $admin['id']]);
    
    if ($result) {
        echo "<br>Đã reset mật khẩu thành công!<br>";
        echo "Mật khẩu mới: password";
    } else {
        echo "<br>Lỗi khi reset mật khẩu!";
    }
} else {
    // Tạo tài khoản admin mới
    $password = 'password';
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $insert_sql = "INSERT INTO users (username, password, full_name, email, role, status) 
                   VALUES (?, ?, ?, ?, 'admin', 'active')";
    $result = $db->execute($insert_sql, ['admin', $hashed_password, 'Administrator', 'admin@example.com']);
    
    if ($result) {
        echo "Đã tạo tài khoản admin thành công!<br>";
        echo "Username: admin<br>";
        echo "Password: password";
    } else {
        echo "Lỗi khi tạo tài khoản admin!";
    }
}

// Hiển thị tất cả user có role admin
echo "<br><br>Danh sách tất cả tài khoản admin:<br>";
$all_admins_sql = "SELECT * FROM users WHERE role = 'admin'";
$all_admins = $db->query($all_admins_sql);

if ($all_admins) {
    echo "<pre>";
    print_r($all_admins);
    echo "</pre>";
} else {
    echo "Không có tài khoản admin nào!";
}
?> 