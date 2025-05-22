<?php
session_start();

// Xóa tất cả các biến session
$_SESSION = array();

// Xóa session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Hủy session
session_destroy();

// Chuyển về trang đăng nhập
header('Location: login.php');
exit; 