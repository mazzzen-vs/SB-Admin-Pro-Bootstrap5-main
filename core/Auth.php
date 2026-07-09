<?php
class Auth {
    public static function login($email, $password, $remember = false) {
        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful
            session_regenerate_id(true);
            Session::set('user_id', $user['id']);
            Session::set('user_role', $user['role']);
            
            if ($remember) {
                self::rememberUser($user['id']);
            }
            
            return true;
        }
        
        return false;
    }

    public static function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $userModel = new User();
        return $userModel->create($data);
    }

    public static function logout() {
        $userId = Session::get('user_id');
        
        if ($userId) {
            $userModel = new User();
            $userModel->deleteAllRememberTokens($userId);
        }
        
        if (Cookie::has('remember_token')) {
            Cookie::delete('remember_token');
        }
        
        Session::destroy();
    }

    public static function check() {
        if (Session::has('user_id')) {
            return true;
        }
        
        return self::loginFromCookie();
    }

    public static function user() {
        if (self::check()) {
            $userModel = new User();
            return $userModel->findById(Session::get('user_id'));
        }
        return null;
    }

    public static function role() {
        if (self::check()) {
            return Session::get('user_role');
        }
        return null;
    }

    private static function rememberUser($userId) {
        $config = require __DIR__ . '/../config/app.php';
        
        $selector = bin2hex(random_bytes(16));
        $validator = bin2hex(random_bytes(32));
        
        $token = $selector . ':' . $validator;
        $tokenHash = hash('sha256', $validator);
        $expiresAt = date('Y-m-d H:i:s', time() + $config['remember_me_duration']);
        
        $userModel = new User();
        $userModel->saveRememberToken($userId, $selector, $tokenHash, $expiresAt);
        
        Cookie::set('remember_token', $token, $config['remember_me_duration']);
    }

    private static function loginFromCookie() {
        if (!Cookie::has('remember_token')) {
            return false;
        }
        
        $token = Cookie::get('remember_token');
        if (strpos($token, ':') === false) {
            return false;
        }
        
        list($selector, $validator) = explode(':', $token);
        
        $userModel = new User();
        $tokenRecord = $userModel->findRememberToken($selector);
        
        if ($tokenRecord) {
            if (hash_equals($tokenRecord['token_hash'], hash('sha256', $validator))) {
                if (strtotime($tokenRecord['expires_at']) > time()) {
                    // Valid token
                    $user = $userModel->findById($tokenRecord['user_id']);
                    if ($user) {
                        session_regenerate_id(true);
                        Session::set('user_id', $user['id']);
                        Session::set('user_role', $user['role']);
                        return true;
                    }
                } else {
                    // Expired token
                    $userModel->deleteRememberToken($selector);
                }
            }
        }
        
        Cookie::delete('remember_token');
        return false;
    }
}
