<?php
require_once __DIR__ . '/../layout/header.php';

require_login();

require_once __DIR__ . '/../../classes/CustomerClass.php';
$customerModel = new CustomerClass();
$customer = $customerModel->getCustomerByEmail($_SESSION['customer_email'] ?? '');
?>

<div class="profile-card">
    <h2 style="color: #0f172a; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">My Account Dashboard</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="margin-top: 15px;">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <p style="margin-top: 15px; color: #475569;">Welcome to your personal account dashboard.</p>

    <table>
        <tr>
            <td>Customer ID</td>
            <td>#<?= htmlspecialchars($customer['customer_id'] ?? $_SESSION['customer_id']) ?></td>
        </tr>
        <tr>
            <td>Full Name</td>
            <td><?= htmlspecialchars($customer['customer_name'] ?? $_SESSION['customer_name']) ?></td>
        </tr>
        <tr>
            <td>Email Address</td>
            <td><?= htmlspecialchars($customer['customer_email'] ?? $_SESSION['customer_email']) ?></td>
        </tr>
        <tr>
            <td>Country</td>
            <td><?= htmlspecialchars($customer['customer_country'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>City</td>
            <td><?= htmlspecialchars($customer['customer_city'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>Contact Number</td>
            <td><?= htmlspecialchars($customer['customer_contact'] ?? 'N/A') ?></td>
        </tr>
        <tr>
            <td>Account Role</td>
            <td>
                <?php if ((int)($customer['user_role'] ?? $_SESSION['user_role']) === 1): ?>
                    <span style="background: #dc2626; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Administrator</span>
                <?php else: ?>
                    <span style="background: #0284c7; color: white; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Customer</span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <div style="margin-top: 25px; text-align: right;">
        <a href="<?= $app_root ?>logout.php" style="color: #dc2626; text-decoration: none; font-weight: 600;">Log Out</a>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
