<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/CartController.php';

$app_root = get_app_root();
$cartController = new CartController();
$cart_ip = get_ip();
$cart_items = $cartController->getCartItems($cart_ip);
$cart_total = $cartController->getCartTotal($cart_ip);
?>

<div style="max-width: 800px; margin: 30px auto; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
    <h2 style="margin-top: 0; color: #0f172a; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px;">Order Checkout</h2>

    <?php if (empty($cart_items)): ?>
        <p style="color: #64748b;">Your cart is empty. Please add items before checking out.</p>
        <a href="<?= $app_root ?>index.php" style="color: #0284c7; font-weight: bold; text-decoration: none;">&larr; Return to Store</a>
    <?php else: ?>
        <p style="color: #64748b; font-size: 15px;">Review your items before proceeding to payment.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                    <th style="padding: 10px;">Item</th>
                    <th style="padding: 10px; width: 80px; text-align: center;">Qty</th>
                    <th style="padding: 10px; width: 120px; text-align: right;">Price</th>
                    <th style="padding: 10px; width: 120px; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 10px;"><?= htmlspecialchars($item['product_title']) ?></td>
                        <td style="padding: 10px; text-align: center;"><?= (int)$item['qty'] ?></td>
                        <td style="padding: 10px; text-align: right;">GHS <?= number_format((float)$item['product_price'], 2) ?></td>
                        <td style="padding: 10px; text-align: right; font-weight: bold; color: #166534;">
                            GHS <?= number_format((float)($item['qty'] * $item['product_price']), 2) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr style="background: #f8fafc; font-weight: bold;">
                    <td colspan="3" style="padding: 12px 10px; text-align: right;">Grand Total:</td>
                    <td style="padding: 12px 10px; text-align: right; color: #166534; font-size: 16px;">
                        GHS <?= number_format($cart_total, 2) ?>
                    </td>
                </tr>
            </tfoot>
        </table>

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 25px;">
            <a href="<?= $app_root ?>views/cart.php" style="color: #64748b; text-decoration: none; font-size: 14px;">
                &larr; Back to Cart
            </a>
            <?php if (is_logged_in()): ?>
                <a href="<?= $app_root ?>views/payment.php" style="background: #16a34a; color: white; padding: 12px 28px; border-radius: 6px; font-weight: bold; text-decoration: none;">
                    Proceed to Payment &rarr;
                </a>
            <?php else: ?>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <span style="font-size: 13px; color: #64748b;">Please login to proceed:</span>
                    <a href="<?= $app_root ?>view/login.php" style="background: #0284c7; color: white; padding: 10px 18px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 13px;">
                        Login to Checkout
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
