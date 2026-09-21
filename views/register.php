<?php
require_once __DIR__ . '/layout/header.php';

if (is_logged_in()) {
    redirect('../views/account/my_account.php');
}
?>

<div class="form-card">
    <h2>Create Customer Account</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="../actions/register_action.php" method="POST" id="register-form">
        <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" name="name" id="name" placeholder="John Doe" required maxlength="100">
            <div class="error-text" id="name-error"></div>
        </div>

        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" name="email" id="email" placeholder="john@example.com" required maxlength="50">
            <div class="error-text" id="email-error"></div>
        </div>

        <div class="form-group">
            <label for="pass">Password *</label>
            <input type="password" name="pass" id="pass" placeholder="At least 8 chars & 1 digit" required>
            <div class="error-text" id="pass-error"></div>
        </div>

        <div class="form-group">
            <label for="confirm_pass">Confirm Password *</label>
            <input type="password" name="confirm_pass" id="confirm_pass" placeholder="Re-enter password" required>
            <div class="error-text" id="confirm-pass-error"></div>
        </div>

        <div class="form-group">
            <label for="country">Country *</label>
            <select name="country" id="country" required>
                <option value="">-- Select Country --</option>
                <option value="Ghana">Ghana</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Kenya">Kenya</option>
                <option value="South Africa">South Africa</option>
                <option value="Rwanda">Rwanda</option>
                <option value="United States">United States</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="Canada">Canada</option>
            </select>
            <div class="error-text" id="country-error"></div>
        </div>

        <div class="form-group">
            <label for="city">City *</label>
            <input type="text" name="city" id="city" placeholder="Accra" required maxlength="30">
            <div class="error-text" id="city-error"></div>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number *</label>
            <input type="text" name="contact" id="contact" placeholder="+233200000000" required maxlength="15">
            <div class="error-text" id="contact-error"></div>
        </div>

        <button type="submit" class="btn-primary">Register Account</button>
    </form>

    <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #64748b;">
        Already have an account? <a href="login.php" style="color: #0284c7; font-weight: 600;">Sign in here</a>
    </p>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
