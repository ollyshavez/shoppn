<?php
require_once __DIR__ . '/layout/header.php';

if (is_logged_in()) {
    redirect('../views/account/my_account.php');
}
?>

<div class="form-card">
    <h2>Sign In to Shoppn</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST" id="login-form">
        <div class="form-group">
            <label for="login-email">Email Address *</label>
            <input type="email" name="email" id="login-email" placeholder="john@example.com" required maxlength="50">
            <div class="error-text" id="login-email-error"></div>
        </div>

        <div class="form-group">
            <label for="login-pass">Password *</label>
            <input type="password" name="pass" id="login-pass" placeholder="Enter your password" required>
            <div class="error-text" id="login-pass-error"></div>
        </div>

        <button type="submit" class="btn-primary">Sign In</button>
    </form>

    <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #64748b;">
        Don't have an account? <a href="register.php" style="color: #0284c7; font-weight: 600;">Register here</a>
    </p>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
