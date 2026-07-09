<?php
require_once __DIR__ . '/init.php';

if (Auth::check()) {
    $role = Auth::role();
    if ($role === 'admin' || $role === 'merchant') {
        redirect('dashboard.php');
    } else {
        // Here you would have the main front page.
        // For now, let's just say "Welcome User".
        echo "<h1>Welcome User!</h1>";
        echo "<a href='" . base_url('logout.php') . "'>Logout</a>";
    }
} else {
    redirect('login.php');
}
