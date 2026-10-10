<?php
require_once __DIR__ . '/../../core/core.php';
$app_root = get_app_root();
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
    <main class="container">