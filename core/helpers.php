<?php

function base_url($path = '') {
    $config = require __DIR__ . '/../config/app.php';
    return rtrim($config['base_url'], '/') . '/' . ltrim($path, '/');
}

function redirect($path) {
    header("Location: " . base_url($path));
    exit;
}

function old($key, $default = '') {
    return isset($_SESSION['old'][$key]) ? escape($_SESSION['old'][$key]) : $default;
}

function clear_old() {
    if (isset($_SESSION['old'])) {
        unset($_SESSION['old']);
    }
}

function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
