<?php
require_once __DIR__ . '/init.php';

$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $authController->handleRegister();
} else {
    $authController->showRegister();
}
