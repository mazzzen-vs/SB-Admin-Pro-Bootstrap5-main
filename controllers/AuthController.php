<?php
class AuthController {
    public function showLogin() {
        Middleware::requireGuest();
        require __DIR__ . '/../views/auth/login.php';
    }

    public function handleLogin() {
        Middleware::requireGuest();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login.php');
        }

        if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid CSRF token.');
            redirect('login.php');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        $validator = new Validator();
        $validator->required('email', $email)
                  ->email('email', $email)
                  ->required('password', $password);

        if ($validator->fails()) {
            $_SESSION['old'] = $_POST;
            Session::flash('errors', $validator->errors());
            redirect('login.php');
        }

        if (Auth::login($email, $password, $remember)) {
            $role = Auth::role();
            if ($role === 'admin' || $role === 'merchant') {
                redirect('dashboard.php');
            } else {
                redirect('index.php');
            }
        } else {
            $_SESSION['old'] = $_POST;
            Session::flash('error', 'Invalid email or password.');
            redirect('login.php');
        }
    }

    public function showRegister() {
        Middleware::requireGuest();
        require __DIR__ . '/../views/auth/register.php';
    }

    public function handleRegister() {
        Middleware::requireGuest();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('register.php');
        }

        if (!CSRF::verify($_POST['csrf_token'] ?? '')) {
            Session::flash('error', 'Invalid CSRF token.');
            redirect('register.php');
        }

        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $validator = new Validator();
        $validator->required('full_name', $fullName, 'Full Name')
                  ->required('email', $email)
                  ->email('email', $email)
                  ->unique('email', $email, 'users', 'email')
                  ->required('password', $password)
                  ->minLength('password', $password, 6)
                  ->required('confirm_password', $confirmPassword, 'Confirm Password')
                  ->match('confirm_password', $confirmPassword, 'password', $password, 'Confirm Password');

        if ($validator->fails()) {
            $_SESSION['old'] = $_POST;
            Session::flash('errors', $validator->errors());
            redirect('register.php');
        }

        $data = [
            'full_name' => $fullName,
            'email' => $email,
            'phone' => $phone,
            'password' => $password
        ];

        if (Auth::register($data)) {
            Session::flash('success', 'Account created successfully! Please login.');
            redirect('login.php');
        } else {
            $_SESSION['old'] = $_POST;
            Session::flash('error', 'Something went wrong. Please try again.');
            redirect('register.php');
        }
    }

    public function logout() {
        Auth::logout();
        redirect('login.php');
    }
}
