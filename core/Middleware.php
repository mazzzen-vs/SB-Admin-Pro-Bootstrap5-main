<?php
class Middleware {
    public static function requireAuth() {
        if (!Auth::check()) {
            Session::flash('error', 'You must be logged in to view that page.');
            redirect('login.php');
        }
    }

    public static function requireRole($role) {
        self::requireAuth();
        if (Auth::role() !== $role) {
            http_response_code(403);
            require __DIR__ . '/../views/errors/403.php';
            exit;
        }
    }

    public static function requireGuest() {
        if (Auth::check()) {
            redirect('dashboard.php');
        }
    }
}
