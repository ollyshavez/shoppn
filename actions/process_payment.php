<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CartController.php';
require_once __DIR__ . '/../controllers/OrderController.php';

require_login();

$app_root = get_app_root();
$reference = trim($_GET['reference'] ?? '');

if (empty($reference)) {
    $_SESSION['error'] = 'No payment reference provided.';
    redirect($app_root . 'views/cart.php');
}

$secret_key = defined('PAYSTACK_SECRET_KEY') ? PAYSTACK_SECRET_KEY : '';

// 1. Verify payment with Paystack API
$url = "https://api.paystack.co/transaction/verify/" . rawurlencode($reference);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $secret_key,
    "Cache-Control: no-cache"
]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local environments

$response = curl_exec($ch);
$curl_err = curl_error($ch);
curl_close($ch);

if ($curl_err) {
    $_SESSION['error'] = 'Unable to verify payment with gateway: ' . $curl_err;
    redirect($app_root . 'views/payment.php');
}

$result = json_decode($response, true);

if (!$result || !isset($result['status']) || !$result['status']) {
    $msg = $result['message'] ?? 'Transaction verification failed.';
    $_SESSION['error'] = 'Verification error: ' . $msg;
    redirect($app_root . 'views/payment.php');
}

$tx_data = $result['data'] ?? [];
$gateway_status = $tx_data['status'] ?? '';

if ($gateway_status !== 'success') {
    $_SESSION['error'] = 'Payment was not successful. Status: ' . htmlspecialchars($gateway_status);
    redirect($app_root . 'views/payment.php');
}

// 2. Fetch cart items for current customer / IP
$cartController = new CartController();
$cart_ip = get_ip();
$cart_items = $cartController->getCartItems($cart_ip);
$customer_id = (int)core_get_user_id();

if (empty($cart_items)) {
    // If cart was already cleared or empty
    $_SESSION['error'] = 'Order already processed or your cart is empty.';
    redirect($app_root . 'views/account/my_account.php');
}

$orderController = new OrderController();

// 3. Create Order
$invoice_no = mt_rand(100000, 999999);
$order_date = date('Y-m-d');
$order_id = $orderController->createOrder($customer_id, $invoice_no, $order_date, 'paid');

if (!$order_id) {
    $_SESSION['error'] = 'Failed to generate order record. Please contact support with reference: ' . htmlspecialchars($reference);
    redirect($app_root . 'views/cart.php');
}

// 4. Save each cart item to orderdetails
foreach ($cart_items as $item) {
    $orderController->addOrderDetail($order_id, (int)$item['p_id'], (int)$item['qty']);
}

// 5. Record Payment
$amt = isset($tx_data['amount']) ? ((float)$tx_data['amount'] / 100) : $cartController->getCartTotal($cart_ip);
$currency = $tx_data['currency'] ?? 'GHS';
$payment_date = date('Y-m-d');

$payment_id = $orderController->recordPayment($amt, $customer_id, $order_id, $currency, $payment_date);

// 6. Clear customer cart
$cartController->clearCart($cart_ip);

// 7. Store success message and redirect to invoice/receipt view
$_SESSION['success'] = 'Payment successful! Your order has been placed.';
redirect($app_root . 'views/payment_success.php?order_id=' . (int)$order_id);
