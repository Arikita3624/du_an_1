<?php
// Mật khẩu bạn muốn sử dụng
$password = '123456'; // Thay đổi mật khẩu này theo ý bạn

// Mã hóa mật khẩu
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

echo "<h3>Thông tin để thêm vào phpMyAdmin:</h3>";
echo "Mật khẩu gốc: " . $password . "<br>";
echo "Mật khẩu đã mã hóa: " . $hashed_password . "<br><br>";

echo "<h3>Hướng dẫn thêm tài khoản trong phpMyAdmin:</h3>";
echo "1. Mở phpMyAdmin<br>";
echo "2. Chọn database 'base_du_an_1'<br>";
echo "3. Chọn bảng 'users'<br>";
echo "4. Click 'Insert' để thêm mới<br>";
echo "5. Điền thông tin:<br>";
echo "- username: (tên đăng nhập bạn muốn)<br>";
echo "- password: (copy chuỗi mật khẩu đã mã hóa ở trên)<br>";
echo "- full_name: (tên đầy đủ)<br>";
echo "- email: (email của bạn)<br>";
echo "- role: 'admin'<br>";
echo "- status: 'active'<br><br>";

echo "<h3>Kiểm tra mật khẩu:</h3>";
echo "Verify test: " . (password_verify($password, $hashed_password) ? "TRUE - Mật khẩu hợp lệ" : "FALSE - Mật khẩu không hợp lệ");
?> 