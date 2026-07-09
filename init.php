<?php
// Initialize session, load config and core classes
require_once __DIR__ . '/core/helpers.php';
require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/Session.php';
require_once __DIR__ . '/core/Cookie.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/core/Auth.php';
require_once __DIR__ . '/core/Middleware.php';
require_once __DIR__ . '/core/Validator.php';
require_once __DIR__ . '/core/CSRF.php';

// Load Controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/DashboardController.php';

Session::start();
