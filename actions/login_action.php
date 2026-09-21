<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../views/login.php');
}

$email = trim(strip_tags($_POST['email'] ?? ''));
$pass = $_POST['pass'] ?? '';

if (empty($email) || empty($pass)) {
    $_SESSION['error'] = 'Please enter both email and password.';
    redirect('../views/login.php');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid email address format.';
    redirect('../views/login.php');
}

$controller = new CustomerController();
$result = $controller->login($email, $pass);

if ($result['success']) {
    $user = $result['user'];
    $_SESSION['customer_id'] = $user['customer_id'];
    $_SESSION['customer_name'] = $user['customer_name'];
    $_SESSION['customer_email'] = $user['customer_email'];
    $_SESSION['user_role'] = (int)$user['user_role'];
    $_SESSION['success'] = 'Welcome back, ' . htmlspecialchars($user['customer_name']) . '!';
    redirect('../index.php');
} else {
    $_SESSION['error'] = $result['error'];
    redirect('../views/login.php');
}

?>
