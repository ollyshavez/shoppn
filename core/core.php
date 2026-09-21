<?php

// Start output buffering to ensure redirect headers work safely
if (ob_get_level() == 0) {
    ob_start();
}

// Start session if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Africa/Accra');

require_once __DIR__ . '/db_class.php';

// Dynamic App Root URL path calculation
function get_app_root()
{
    $script_name = $_SERVER['SCRIPT_NAME'] ?? '';
    $dir = str_replace('\\', '/', dirname($script_name));
    
    $pattern = '#/(view|views|account|admin|actions|controllers|controller|classes|core|functions)$#i';
    while (preg_match($pattern, $dir)) {
        $dir = preg_replace($pattern, '', $dir);
    }
    
    if ($dir === '/' || $dir === '.') {
        return '/';
    }
    return rtrim($dir, '/') . '/';
}

// IP helper function
function get_ip()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}

// Safe redirection helper
function redirect($url)
{
    header("Location: $url");
    exit();
}

// Check if user is logged in
function is_logged_in()
{
    return isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id']);
}

// Check if logged in user is admin (role 1)
function is_admin()
{
    return is_logged_in() && isset($_SESSION['user_role']) && (int)$_SESSION['user_role'] === 1;
}

// Get logged-in user ID helper
function core_get_user_id()
{
    return $_SESSION['customer_id'] ?? null;
}

// Get logged-in user role helper
function core_get_user_role()
{
    return $_SESSION['user_role'] ?? null;
}

// Enforce login requirement for protected pages
function require_login()
{
    if (!is_logged_in()) {
        $root = get_app_root();
        redirect($root . 'view/login.php');
    }
}

// Enforce admin requirement for admin pages
function require_admin()
{
    if (!is_admin()) {
        $root = get_app_root();
        $_SESSION['error'] = 'Access denied. Admin privileges required.';
        redirect($root . 'index.php');
    }
}

?>