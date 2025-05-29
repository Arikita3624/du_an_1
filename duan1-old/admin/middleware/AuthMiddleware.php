<?php
class AuthMiddleware {
    public static function isLoggedIn() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }

    public static function isNotLoggedIn() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=dashboard');
            exit;
        }
    }
}
?> 