<?php
require_once '../commons/Database.php';

$db = Database::getInstance();

// Kiểm tra tất cả user có role admin
echo "<h3>Danh sách tất cả user có role admin:</h3>";
$sql = "SELECT * FROM users WHERE role = 'admin'";
$admins = $db->query($sql);

if ($admins) {
    echo "<pre>";
    print_r($admins);
    echo "</pre>";
} else {
    echo "Không có user nào có role admin!";
}

// Kiểm tra cấu trúc bảng users
echo "<h3>Cấu trúc bảng users:</h3>";
$sql = "DESCRIBE users";
$structure = $db->query($sql);

if ($structure) {
    echo "<pre>";
    print_r($structure);
    echo "</pre>";
} else {
    echo "Không thể lấy cấu trúc bảng users!";
}

// Kiểm tra database hiện tại
echo "<h3>Database hiện tại:</h3>";
$sql = "SELECT DATABASE() as db_name";
$result = $db->queryOne($sql);
if ($result) {
    echo "Database name: " . $result['db_name'];
} else {
    echo "Không thể lấy tên database!";
}
?> 