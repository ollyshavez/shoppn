<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/OrderController.php';

require_login();

$app_root = get_app_root();
$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$orderController = new OrderController();

$order = $orderController->getOrderById($order_id);

if (!$order || (int)$order['customer_id'] !== (int)core_get_user_id()) {
    $_SESSION['error'] = 'Order not found or unauthorized access.';
    redirect($app_root . 'index.php');
}

$payment = $orderController->getPaymentByOrderId($order_id);
$order_items = $orderController->getOrderItems($order_id);
?>

<div style="max-width: 750px; margin: 30px auto; background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 35px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
    <!-- Success Banner -->
    <div style="text-align: center; margin-bottom: 25px;">
        <div style="width: 60px; height: 60px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 30px; font-weight: bold; margin-bottom: 12px;">
            &#10003;
        </div>
        <h2 style="color: #0f172a; margin: 0 0 6px 0;">Payment Successful!</h2>
        <p style="color: #64748b; margin: 0; font-size: 15px;">Thank you for your purchase. Here is your official order receipt.</p>
    </div>

    <!-- Order Meta Card -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; font-size: 14px;">
            <div>
                <span style="color: #64748b;">Invoice No:</span><br>
                <strong style="color: #0f172a; font-size: 16px;">#<?= htmlspecialchars($order['invoice_no']) ?></strong>
            </div>
            <div>
                <span style="color: #64748b;">Order Date:</span><br>
                <strong style="color: #0f172a;"><?= htmlspecialchars($order['order_date']) ?></strong>
            </div>
            <div>
                <span style="color: #64748b;">Customer Name:</span><br>
                <strong style="color: #0f172a;"><?= htmlspecialchars($order['customer_name']) ?></strong>
            </div>
            <div>
                <span style="color: #64748b;">Order Status:</span><br>
                <span style="background: #dcfce7; color: #166534; padding: 3px 10px; border-radius: 12px; font-weight: bold; font-size: 12px; text-transform: uppercase;">
                    <?= htmlspecialchars($order['order_status']) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Items Purchased Table -->
    <h3 style="color: #0f172a; margin-bottom: 12px; font-size: 17px; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">Order Details</h3>
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left; font-size: 14px; color: #475569;">
                <th style="padding: 10px;">Product</th>
                <th style="padding: 10px; width: 80px; text-align: center;">Qty</th>
                <th style="padding: 10px; width: 120px; text-align: right;">Unit Price</th>
                <th style="padding: 10px; width: 120px; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $subtotal_sum = 0;
            foreach ($order_items as $item): 
                $item_total = (int)$item['qty'] * (float)$item['product_price'];
                $subtotal_sum += $item_total;
            ?>
                <tr style="border-bottom: 1px solid #f1f5f9; font-size: 14px;">
                    <td style="padding: 12px 10px;">
                        <strong style="color: #0f172a;"><?= htmlspecialchars($item['product_title']) ?></strong>
                    </td>
                    <td style="padding: 12px 10px; text-align: center;"><?= (int)$item['qty'] ?></td>
                    <td style="padding: 12px 10px; text-align: right; color: #475569;">GHS <?= number_format((float)$item['product_price'], 2) ?></td>
                    <td style="padding: 12px 10px; text-align: right; font-weight: bold; color: #0f172a;">GHS <?= number_format($item_total, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background: #f8fafc; font-weight: bold; font-size: 15px;">
                <td colspan="3" style="padding: 14px 10px; text-align: right; color: #0f172a;">Total Paid:</td>
                <td style="padding: 14px 10px; text-align: right; color: #166534; font-size: 17px;">
                    <?= htmlspecialchars($payment['currency'] ?? 'GHS') ?> <?= number_format((float)($payment['amt'] ?? $subtotal_sum), 2) ?>
                </td>
            </tr>
        </tfoot>
    </table>

    <div style="display: flex; gap: 12px; justify-content: center; margin-top: 25px;">
        <a href="<?= $app_root ?>index.php" style="background: #0284c7; color: white; padding: 11px 24px; border-radius: 6px; font-weight: bold; text-decoration: none;">
            Continue Shopping
        </a>
        <a href="<?= $app_root ?>views/account/my_account.php" style="background: #f1f5f9; color: #334155; padding: 11px 24px; border-radius: 6px; font-weight: bold; text-decoration: none;">
            View Order History
        </a>
    </div>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
