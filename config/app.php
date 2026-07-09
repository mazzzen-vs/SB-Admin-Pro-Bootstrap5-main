<?php
// config/app.php

return [
    'app_name' => 'SB Admin E-commerce',
    // Calculate base URL dynamically
    'base_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/SB-Admin-Pro-Bootstrap5-main',
    'remember_me_duration' => 30 * 24 * 60 * 60, // 30 days in seconds
    'session_lifetime' => 120 * 60, // 120 minutes in seconds
];
