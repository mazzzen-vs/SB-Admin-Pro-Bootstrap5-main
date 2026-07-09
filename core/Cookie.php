<?php
class Cookie {
    public static function set($name, $value, $expiry) {
        $appConfig = require __DIR__ . '/../config/app.php';
        setcookie($name, $value, [
            'expires' => time() + $expiry,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    public static function get($name, $default = null) {
        return $_COOKIE[$name] ?? $default;
    }

    public static function has($name) {
        return isset($_COOKIE[$name]);
    }

    public static function delete($name) {
        self::set($name, '', -3600);
        if (self::has($name)) {
            unset($_COOKIE[$name]);
        }
    }
}
