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
$updated = false;

// Handle array submission: update[] (product IDs) and qty[] (quantities)
$update = $_POST['update'] ?? [];
$quantities = $_POST['qty'] ?? [];

if (is_array($update) && is_array($quantities)) {
    for ($i = 0; $i < count($update); $i++) {
        $product_id = isset($update[$i]) ? (int)$update[$i] : 0;
        $new_qty    = isset($quantities[$i]) ? (int)$quantities[$i] : 0;

        // Validate each quantity is a positive integer >= 1
        if ($product_id > 0 && $new_qty >= 1) {
            $cartController->updateQty($product_id, $new_qty, $ip);
            $updated = true;
        }
    }
}

// Single item update fallback
if (isset($_POST['product_id']) && isset($_POST['qty'])) {
    $product_id = (int)$_POST['product_id'];
    $new_qty    = (int)$_POST['qty'];
    if ($product_id > 0 && $new_qty >= 1) {
        $cartController->updateQty($product_id, $new_qty, $ip);
        $updated = true;
    }
}

if ($updated) {
    $_SESSION['success'] = 'Cart updated successfully.';
} else {
    $_SESSION['error'] = 'Invalid quantity provided. Quantities must be at least 1.';
}

redirect($app_root . 'views/cart.php');
?>
