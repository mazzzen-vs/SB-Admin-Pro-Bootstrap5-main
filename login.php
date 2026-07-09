<?php
require_once __DIR__ . '/init.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->handleLogin();
} else {
    $authController->showLogin();
}
