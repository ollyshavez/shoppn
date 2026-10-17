<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/CartController.php';

$app_root = get_app_root();
$cartController = new CartController();
$cart_ip = get_ip();

$cart_items = $cartController->getCartItems($cart_ip);
$cart_total = $cartController->getCartTotal($cart_ip);
$cart_count = $cartController->getCartCount($cart_ip);
?>

<div style="max-width: 1000px; margin: 30px auto; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
    <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 20px;">
        <h2 style="margin: 0; color: #0f172a; font-size: 24px;">Your Shopping Cart</h2>
        <span style="color: #64748b; font-size: 14px;"><strong><?= (int)$cart_count ?></strong> item(s) in cart</span>
    </div>

    <!-- Flash Notifications -->
    <?php if (isset($_SESSION['success'])): ?>
        <div style="background: #dcfce7; color: #166534; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; border-left: 4px solid #16a34a;">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-weight: bold; border-left: 4px solid #dc2626;">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($cart_items)): ?>
        <!-- Empty Cart State -->
        <div style="text-align: center; padding: 60px 20px;">
            <div style="font-size: 48px; margin-bottom: 15px;">🛒</div>
            <h3 style="color: #334155; margin-bottom: 10px;">Your shopping cart is empty</h3>
            <p style="color: #64748b; margin-bottom: 25px; font-size: 15px;">Browse our catalog and discover great products to add to your cart.</p>
            <a href="<?= $app_root ?>index.php" style="background: #0284c7; color: white; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-block;">
                &larr; Start Shopping
            </a>
        </div>
    <?php else: ?>
        <!-- Form Declarations (Task 12: Separate Action files for remove vs update) -->
        <form id="removeForm" action="<?= $app_root ?>actions/remove_from_cart_action.php" method="POST"></form>
        <form id="updateForm" action="<?= $app_root ?>actions/update_qty_action.php" method="POST"></form>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 25px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-align: left;">
                        <th style="padding: 12px 10px; width: 60px; text-align: center;">Remove</th>
                        <th style="padding: 12px 15px;">Product</th>
                        <th style="padding: 12px 15px; width: 140px;">Unit Price</th>
                        <th style="padding: 12px 15px; width: 130px;">Quantity</th>
                        <th style="padding: 12px 15px; width: 140px; text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <?php 
                            $item_qty   = (int)$item['qty'];
                            $item_price = (float)$item['product_price'];
                            $item_subtotal = $item_qty * $item_price;
                        ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <!-- Remove Checkbox (name='remove[]') -->
                            <td style="padding: 15px 10px; text-align: center; vertical-align: middle;">
                                <input type="checkbox" name="remove[]" value="<?= htmlspecialchars($item['p_id']) ?>" form="removeForm" style="transform: scale(1.3); cursor: pointer;">
                            </td>

                            <!-- Product Info (Image + Title) -->
                            <td style="padding: 15px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 15px;">
                                    <?php if (!empty($item['product_image'])): ?>
                                        <img src="<?= $app_root ?>images/products/<?= htmlspecialchars($item['product_image']) ?>" alt="<?= htmlspecialchars($item['product_title']) ?>" style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #e2e8f0; border-radius: 6px; padding: 2px; background: #fafafa;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background: #f1f5f9; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 11px; color: #94a3b8;">No Image</div>
                                    <?php endif; ?>
                                    <div>
                                        <a href="<?= $app_root ?>views/single_product.php?pro_id=<?= htmlspecialchars($item['p_id']) ?>" style="font-weight: bold; color: #0284c7; text-decoration: none; font-size: 15px;">
                                            <?= htmlspecialchars($item['product_title']) ?>
                                        </a>
                                        <div style="font-size: 12px; color: #94a3b8; margin-top: 3px;">ID: #<?= htmlspecialchars($item['p_id']) ?></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Unit Price -->
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #334155;">
                                GHS <?= number_format($item_price, 2) ?>
                            </td>

                            <!-- Quantity Input (name='qty[]' with hidden name='update[]') -->
                            <td style="padding: 15px; vertical-align: middle;">
                                <input type="hidden" name="update[]" value="<?= htmlspecialchars($item['p_id']) ?>" form="updateForm">
                                <input type="number" name="qty[]" value="<?= $item_qty ?>" min="1" max="99" form="updateForm" style="width: 75px; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 4px; font-size: 14px; text-align: center;">
                            </td>

                            <!-- Row Total -->
                            <td style="padding: 15px; vertical-align: middle; text-align: right; font-weight: bold; color: #166534;">
                                GHS <?= number_format($item_subtotal, 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr style="background: #f8fafc; border-top: 2px solid #cbd5e1;">
                        <td colspan="4" style="padding: 16px 15px; text-align: right; font-size: 16px; font-weight: bold; color: #0f172a;">
                            Subtotal:
                        </td>
                        <td style="padding: 16px 15px; text-align: right; font-size: 18px; font-weight: bold; color: #166534;">
                            GHS <?= number_format($cart_total, 2) ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Buttons Panel (Task 11 & Task 12) -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 12px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
            <div style="display: flex; gap: 10px;">
                <button type="submit" form="removeForm" style="background: #dc2626; color: white; padding: 10px 18px; border: none; border-radius: 5px; font-weight: bold; font-size: 13px; cursor: pointer;">
                    Remove from Cart
                </button>
                <button type="submit" form="updateForm" style="background: #0284c7; color: white; padding: 10px 18px; border: none; border-radius: 5px; font-weight: bold; font-size: 13px; cursor: pointer;">
                    Update Quantity
                </button>
            </div>

            <div style="display: flex; gap: 10px;">
                <a href="<?= $app_root ?>index.php" style="background: #f1f5f9; color: #334155; padding: 10px 20px; border-radius: 5px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;">
                    Continue Shopping
                </a>
                <a href="<?= $app_root ?>views/checkout.php" style="background: #16a34a; color: white; padding: 10px 22px; border-radius: 5px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;">
                    Checkout &rarr;
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="<?= $app_root ?>js/cart.js"></script>
<?php
require_once __DIR__ . '/layout/footer.php';
?>
