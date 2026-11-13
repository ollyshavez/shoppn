<?php
require_once __DIR__ . '/../layout/header.php';

require_login();

require_once __DIR__ . '/../../classes/CustomerClass.php';
require_once __DIR__ . '/../../controllers/OrderController.php';

$customerModel = new CustomerClass();
$customer = $customerModel->getCustomerByEmail($_SESSION['customer_email'] ?? '');

$orderController = new OrderController();
$my_orders = $orderController->getOrdersByCustomer((int)core_get_user_id());
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

    <!-- Order History Section -->
    <h3 style="color: #0f172a; margin-top: 35px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">My Orders</h3>
    <?php if (empty($my_orders)): ?>
        <p style="color: #64748b; font-size: 14px;">You have not placed any orders yet.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 10px;">Invoice #</th>
                    <th style="padding: 10px;">Order Date</th>
                    <th style="padding: 10px; text-align: right;">Amount</th>
                    <th style="padding: 10px; text-align: center;">Status</th>
                    <th style="padding: 10px; text-align: center;">Receipt</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($my_orders as $ord): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 10px; font-weight: bold; color: #0f172a;">#<?= htmlspecialchars($ord['invoice_no']) ?></td>
                        <td style="padding: 10px; color: #64748b;"><?= htmlspecialchars($ord['order_date']) ?></td>
                        <td style="padding: 10px; text-align: right; font-weight: bold; color: #166534;">
                            <?= htmlspecialchars($ord['currency'] ?? 'GHS') ?> <?= number_format((float)($ord['amt'] ?? 0), 2) ?>
                        </td>
                        <td style="padding: 10px; text-align: center;">
                            <span style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: bold; text-transform: uppercase;">
                                <?= htmlspecialchars($ord['order_status']) ?>
                            </span>
                        </td>
                        <td style="padding: 10px; text-align: center;">
                            <a href="<?= $app_root ?>views/payment_success.php?order_id=<?= (int)$ord['order_id'] ?>" style="color: #0284c7; text-decoration: none; font-weight: bold;">
                                View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
