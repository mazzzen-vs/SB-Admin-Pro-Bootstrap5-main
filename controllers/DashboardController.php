<?php
class DashboardController {
    public function index() {
        Middleware::requireAuth();

        $user = Auth::user();
        $role = $user['role'];

        if ($role === 'admin') {
            require __DIR__ . '/../views/admin/dashboard.php';
        } elseif ($role === 'merchant') {
            require __DIR__ . '/../views/merchant/dashboard.php';
        } else {
            // Normal user goes to front page
            redirect('index.php');
        }
    }
}
