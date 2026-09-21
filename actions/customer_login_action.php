<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CustomerController.php";

header("Content-Type: application/json");

$email = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : (isset($_POST['email']) ? trim($_POST['email']) : '');
$pass  = isset($_POST['customer_pass']) ? trim($_POST['customer_pass']) : (isset($_POST['password']) ? trim($_POST['password']) : '');

if (empty($email) || empty($pass)) {
    echo json_encode(["success" => false, "message" => "Email and password are required."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Please enter a valid email address."]);
    exit;
}

$controller = new CustomerController();
$user = $controller->login($email, $pass);

if ($user) {
    $_SESSION['customer_id']    = $user['customer_id'];
    $_SESSION['customer_name']  = $user['customer_name'];
    $_SESSION['customer_email'] = $user['customer_email'];
    $_SESSION['user_role']      = $user['user_role'];

    echo json_encode(["success" => true, "message" => "Login successful."]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid email or password."]);
}

?>
