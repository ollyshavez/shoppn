<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$app_root = get_app_root();

// POST only requirement
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect($app_root . 'views/cart.php');
}

$ip = get_ip();
$cartController = new CartController();
$removed = false;

// Support multi-select removal via checkboxes name="remove[]"
if (isset($_POST['remove']) && is_array($_POST['remove'])) {
    foreach ($_POST['remove'] as $pid) {
        $product_id = (int)$pid;
        if ($product_id > 0) {
            $cartController->removeFromCart($product_id, $ip);
            $removed = true;
        }
    }
}

// Support single product removal via name="product_id"
if (isset($_POST['product_id']) && (int)$_POST['product_id'] > 0) {
    $product_id = (int)$_POST['product_id'];
    $cartController->removeFromCart($product_id, $ip);
    $removed = true;
}

if ($removed) {
    $_SESSION['success'] = 'Selected item(s) removed from your cart.';
} else {
    $_SESSION['error'] = 'Please select at least one item to remove.';
}

redirect($app_root . 'views/cart.php');
?>
