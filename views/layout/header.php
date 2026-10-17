<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/CartController.php';

$app_root = get_app_root();

$cartController = new CartController();
$cart_ip = get_ip();
$cart_count = $cartController->getCartCount($cart_ip);
$cart_total = $cartController->getCartTotal($cart_ip);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppn - E-Commerce Store</title>
    <link rel="stylesheet" href="<?= $app_root ?>css/style.css">
    <script src="<?= $app_root ?>js/validate.js" defer></script>
</head>
<body>
    <header class="header-bar">
        <div class="brand-logo">
            <a href="<?= $app_root ?>index.php">Shoppn</a>
        </div>

        <form action="<?= $app_root ?>views/search_results.php" method="GET" class="search-bar" style="display: flex; align-items: center; margin: 0 20px;">
            <input type="text" name="user_query" placeholder="Search products, keywords..." required style="padding: 8px 12px; border-radius: 4px 0 0 4px; border: 1px solid #cbd5e1; outline: none; width: 220px; font-size: 14px;">
            <button type="submit" style="padding: 8px 15px; background: #0284c7; color: white; border: none; border-radius: 0 4px 4px 0; cursor: pointer; font-weight: bold; font-size: 14px;">Search</button>
        </form>

        <nav>
            <ul class="nav-links">
                <li><a href="<?= $app_root ?>index.php">Home</a></li>
                <li><a href="<?= $app_root ?>views/all_products.php">All Products</a></li>
                <li><a href="<?= $app_root ?>views/cart.php">Cart (<?= (int)$cart_count ?>)</a></li>
                <li><a href="<?= $app_root ?>view/customers.php">Customers</a></li>
                <?php if (is_logged_in()): ?>
                    <li class="nav-user">Welcome, <?= htmlspecialchars($_SESSION['customer_name'] ?? 'User') ?></li>
                    <li><a href="<?= $app_root ?>views/account/my_account.php">My Account</a></li>
                    <?php if (is_admin()): ?>
                        <li><a href="<?= $app_root ?>views/admin/brand.php">Brands</a></li>
                        <li><a href="<?= $app_root ?>views/admin/category.php">Categories</a></li>
                        <li><a href="<?= $app_root ?>views/admin/product.php">Products</a></li>
                    <?php endif; ?>
                    <li><a href="<?= $app_root ?>logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="<?= $app_root ?>view/register.php">Register</a></li>
                    <li><a href="<?= $app_root ?>view/login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <!-- Shopping Cart Summary Bar (Task 11) -->
    <div class="cart-summary-bar" style="background: #0f172a; color: #e2e8f0; padding: 8px 24px; font-size: 13px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08);">
        <div>
            <span>Welcome to <strong>Shoppn</strong> &mdash; Your One-Stop Store</span>
        </div>
        <div>
            <span>Shopping Cart &mdash; Total Items: <strong><?= (int)$cart_count ?></strong> | Total Price: <strong>GHS <?= number_format((float)$cart_total, 2) ?></strong> | </span>
            <a href="<?= $app_root ?>views/cart.php" style="color: #38bdf8; font-weight: bold; text-decoration: none; margin-left: 4px;">Go to Cart &rarr;</a>
        </div>
    </div>

    <main class="container">