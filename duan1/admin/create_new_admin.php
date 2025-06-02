<?php
require_once '../commons/Database.php';

$db = Database::getInstance();

// Thông tin tài khoản admin mới
$username = 'admin2'; // Bạn có thể thay đổi username này
$password = '123456'; // Bạn có thể thay đổi password này
$full_name = 'Admin 2';
$email = 'admin2@example.com';

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Kiểm tra xem username đã tồn tại chưa
$check_sql = "SELECT * FROM users WHERE username = ?";
$existing_user = $db->queryOne($check_sql, [$username]);

if ($existing_user) {
    echo "Username '$username' đã tồn tại! Vui lòng chọn username khác.";
} else {
    // Tạo tài khoản admin mới
    $sql = "INSERT INTO users (username, password, full_name, email, role, status) 
            VALUES (?, ?, ?, ?, 'admin', 'active')";
    
    $result = $db->execute($sql, [$username, $hashed_password, $full_name, $email]);
    
    if ($result) {
        echo "Đã tạo tài khoản admin thành công!<br>";
        echo "Username: " . $username . "<br>";
        echo "Password: " . $password . "<br>";
        echo "Full name: " . $full_name . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Role: admin<br>";
        echo "Status: active<br>";
        
        // Hiển thị thông tin để verify
        echo "<br><h3>Thông tin để verify:</h3>";
        echo "Password hash: " . $hashed_password . "<br>";
        echo "Verify test: " . (password_verify($password, $hashed_password) ? "TRUE" : "FALSE");
    } else {
        echo "Lỗi khi tạo tài khoản admin!";
    }
}

// Hiển thị danh sách tất cả admin
echo "<br><br><h3>Danh sách tất cả tài khoản admin:</h3>";
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