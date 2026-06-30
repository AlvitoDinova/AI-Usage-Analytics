<?php
/**
 * AuthController
 */
class AuthController {

    public function login() {
        echo "Placeholder Login Page - AuthController";
    }

    public function register() {
        echo "Placeholder Register Page - AuthController";
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?page=landing');
        exit;
    }
}
