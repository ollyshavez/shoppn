<?php
require_once __DIR__ . '/layout/header.php';
?>

<div style="background: #ffffff; padding: 40px; border-radius: 10px; border: 1px solid #e2e8f0; text-align: center; margin-top: 20px;">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <h1 style="color: #0f172a; font-size: 32px; margin-bottom: 15px;">Welcome to Shoppn Store</h1>
    <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto 30px auto;">
        Your trusted destination for premium products, smooth customer registration, and secure shopping experience.
    </p>

    <?php if (!is_logged_in()): ?>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="views/register.php" class="btn-primary" style="display: inline-block; width: auto; padding: 12px 28px; text-decoration: none;">Get Started / Register</a>
            <a href="views/login.php" style="display: inline-block; padding: 12px 28px; border: 1px solid #cbd5e1; border-radius: 6px; text-decoration: none; color: #334155; font-weight: 600;">Customer Login</a>
        </div>
    <?php else: ?>
        <p style="color: #0284c7; font-weight: 600; font-size: 16px;">
            You are logged in as <?= htmlspecialchars($_SESSION['customer_name']) ?>.
        </p>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>