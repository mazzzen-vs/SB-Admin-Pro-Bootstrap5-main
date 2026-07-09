<?php
class CSRF {
    public static function generateToken() {
        if (!Session::has('csrf_token')) {
            Session::set('csrf_token', bin2hex(random_bytes(32)));
        }
        return Session::get('csrf_token');
    }

    public static function field() {
        $token = self::generateToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public static function verify($token) {
        if (!Session::has('csrf_token') || !hash_equals(Session::get('csrf_token'), $token)) {
            return false;
        }
        return true;
    }
}
