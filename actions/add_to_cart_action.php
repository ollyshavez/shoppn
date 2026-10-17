<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';

$app_root = get_app_root();

// Read product ID from GET (matching ?add_cart=N pattern) or POST fallback
$product_id = 0;
if (isset($_GET['add_cart'])) {
    $product_id = (int)$_GET['add_cart'];
} elseif (isset($_POST['add_cart'])) {
    $product_id = (int)$_POST['add_cart'];
} elseif (isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
}

// Determine safe return URL (referring page or store home)
$redirect_url = $app_root . 'index.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
    $ref_parts = parse_url($_SERVER['HTTP_REFERER']);
    $ref_path = $ref_parts['path'] ?? '';
    $ref_query = isset($ref_parts['query']) ? '?' . $ref_parts['query'] : '';
    if (!empty($ref_path)) {
        $redirect_url = $ref_path . $ref_query;
    }
}

if ($product_id <= 0) {
    $_SESSION['error'] = 'Invalid product selected.';
    redirect($redirect_url);
}

// Client IP for cart identification
$ip = get_ip();

// Customer ID if logged in (null for guests)
$customer_id = is_logged_in() ? core_get_user_id() : null;

$cartController = new CartController();

// Check if item is already in cart
if ($cartController->isInCart($product_id, $ip)) {
    $_SESSION['error'] = 'This item is already in your cart. Go to cart to update quantity.';
    redirect($redirect_url);
}

// Desired quantity (default to 1)
$qty = isset($_REQUEST['qty']) ? (int)$_REQUEST['qty'] : 1;
if ($qty < 1) {
    $qty = 1;
}

// Add item to cart
$success = $cartController->addToCart($product_id, $qty, $ip, $customer_id);

if ($success) {
    $_SESSION['success'] = 'Item added to cart successfully!';
} else {
    $_SESSION['error'] = 'Failed to add item to cart. Please try again.';
}

redirect($redirect_url);
?>
