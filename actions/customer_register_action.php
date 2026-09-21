<?php

// This is an "action" file - the endpoint the browser's JavaScript sends
// the registration form to (see js/customer.js -> fetch("../actions/customer_register_action.php")).
require_once __DIR__ . "/../controller/CustomerController.php";

// Tell the browser the response body will be JSON, not HTML
header("Content-Type: application/json");

// Read each form field from $_POST
$name    = isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '';
$email   = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
$pass    = isset($_POST['customer_pass']) ? trim($_POST['customer_pass']) : '';
$country = isset($_POST['customer_country']) ? trim($_POST['customer_country']) : '';
$city    = isset($_POST['customer_city']) ? trim($_POST['customer_city']) : '';
$contact = isset($_POST['customer_contact']) ? trim($_POST['customer_contact']) : '';
$image   = isset($_POST['customer_image']) && $_POST['customer_image'] !== '' ? trim($_POST['customer_image']) : null;

// user_role isn't collected from the form - regular customer is role 2
$role    = 2;

// Server-side validation
if ($name === '' || $email === '' || $pass === '' || $country === '' || $city === '' || $contact === '') {
    echo json_encode(["success" => false, "message" => "All required fields must be filled."]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["success" => false, "message" => "Please enter a valid email address."]);
    exit;
}

// Password hashing
$hashedPass = password_hash($pass, PASSWORD_BCRYPT);

$controller = new CustomerController();

// Check if email already exists
if ($controller->getCustomerByEmail($email)) {
    echo json_encode(["success" => false, "message" => "Email address is already registered."]);
    exit;
}

$result = $controller->insert($name, $email, $hashedPass, $country, $city, $contact, $image, $role);

if ($result) {
    echo json_encode(["success" => true, "message" => "Registration successful."]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed."]);
}

?>
