<?php

require_once __DIR__ . "/../core/core.php";
require_once __DIR__ . "/../controller/CustomerController.php";

$isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || 
          (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => false, "message" => "Invalid request method."]);
        exit;
    }
    redirect("../views/register.php");
}

$name    = isset($_POST['customer_name']) ? trim(strip_tags($_POST['customer_name'])) : '';
$email   = isset($_POST['customer_email']) ? trim($_POST['customer_email']) : '';
$pass    = isset($_POST['customer_pass']) ? trim($_POST['customer_pass']) : '';
$country = isset($_POST['customer_country']) ? trim(strip_tags($_POST['customer_country'])) : '';
$city    = isset($_POST['customer_city']) ? trim(strip_tags($_POST['customer_city'])) : '';
$contact = isset($_POST['customer_contact']) ? trim(strip_tags($_POST['customer_contact'])) : '';
$image   = isset($_POST['customer_image']) && $_POST['customer_image'] !== '' ? trim($_POST['customer_image']) : null;

if (empty($name) || empty($email) || empty($pass) || empty($country) || empty($city) || empty($contact)) {
    $msg = "All required fields must be filled.";
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => false, "message" => $msg]);
        exit;
    }
    $_SESSION['error'] = $msg;
    redirect("../views/register.php");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg = "Please enter a valid email address.";
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => false, "message" => $msg]);
        exit;
    }
    $_SESSION['error'] = $msg;
    redirect("../views/register.php");
}

$controller = new CustomerController();
$res = $controller->register([
    'name' => $name,
    'email' => $email,
    'pass' => $pass,
    'country' => $country,
    'city' => $city,
    'contact' => $contact,
    'image' => $image,
    'role' => 2
]);

if ($res['success']) {
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "message" => $res['message']]);
        exit;
    }
    $_SESSION['success'] = "Registration successful. Please login.";
    redirect("../views/login.php");
} else {
    if ($isAjax) {
        header("Content-Type: application/json");
        echo json_encode(["success" => false, "message" => $res['message']]);
        exit;
    }
    $_SESSION['error'] = $res['message'];
    redirect("../views/register.php");
}

?>
