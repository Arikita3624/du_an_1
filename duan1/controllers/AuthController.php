<?php

 class SignUpController {
    public function  index() {
        require_once __DIR__ . '/../views/pages/auth/SignUp.php';
    }
 }

 class SignInController {
    public function index() {
        require_once __DIR__ . '/../views/pages/auth/SignIn.php';
 }
}
?>