<?php
class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            // Optional: Secure session settings
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);
            
            $appConfig = require __DIR__ . '/../config/app.php';
            session_set_cookie_params([
                'lifetime' => $appConfig['session_lifetime'],
                'path' => '/',
                'domain' => $_SERVER['HTTP_HOST'],
                'secure' => isset($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax'
            ]);
            
            session_start();
        }
    }

    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function remove($key) {
        if (self::has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public static function flash($key, $value = null) {
        if ($value !== null) {
            self::set('flash_' . $key, $value);
        } else {
            $flashKey = 'flash_' . $key;
            if (self::has($flashKey)) {
                $msg = self::get($flashKey);
                self::remove($flashKey);
                return $msg;
            }
            return null;
        }
    }

    public static function destroy() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
        }
    }
}
