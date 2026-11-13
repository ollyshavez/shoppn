<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/CartController.php';

require_login();

$app_root = get_app_root();
$cartController = new CartController();
$cart_ip = get_ip();
$cart_items = $cartController->getCartItems($cart_ip);
$cart_total = $cartController->getCartTotal($cart_ip);

// If cart is empty, redirect back to cart
if (empty($cart_items) || $cart_total <= 0) {
    $_SESSION['error'] = 'Your cart is empty. Add items before paying.';
    redirect($app_root . 'views/cart.php');
}

$customer_id = (int)core_get_user_id();
$customer_email = $_SESSION['customer_email'] ?? '';
$customer_name = $_SESSION['customer_name'] ?? 'Valued Customer';
$public_key = defined('PAYSTACK_PUBLIC_KEY') ? PAYSTACK_PUBLIC_KEY : '';
$amount_in_pesewas = (int)round($cart_total * 100);
$currency = 'GHS';
?>

<div style="max-width: 680px; margin: 30px auto; background: #fff; border-radius: 10px; border: 1px solid #e2e8f0; padding: 32px; box-shadow: 0 4px 12px rgba(0,0,0,0.06);">
    <div style="text-align: center; margin-bottom: 24px;">
        <span style="background: #e0f2fe; color: #0284c7; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
            Secure Checkout
        </span>
        <h2 style="color: #0f172a; margin: 12px 0 6px 0;">Complete Your Payment</h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">Powered by Paystack &mdash; Cards & Mobile Money (MTN, Telecel, AT)</p>
    </div>

    <!-- Customer Details & Order Summary Card -->
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px; margin-bottom: 24px;">
        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; color: #475569;">
            <span>Customer Name:</span>
            <strong style="color: #0f172a;"><?= htmlspecialchars($customer_name) ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; color: #475569;">
            <span>Email Address:</span>
            <strong style="color: #0f172a;"><?= htmlspecialchars($customer_email) ?></strong>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; margin-bottom: 8px; color: #475569;">
            <span>Items to Purchase:</span>
            <strong style="color: #0f172a;"><?= count($cart_items) ?> item(s)</strong>
        </div>
        <hr style="border: 0; border-top: 1px solid #cbd5e1; margin: 12px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: 16px;">
            <span style="font-weight: bold; color: #0f172a;">Total Payable Amount:</span>
            <span style="font-size: 22px; font-weight: bold; color: #166534;">
                GHS <?= number_format($cart_total, 2) ?>
            </span>
        </div>
    </div>

    <!-- Payment Notice -->
    <div style="background: #fefce8; border-left: 4px solid #eab308; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 13px; color: #713f12;">
        <strong>Test Mode Notice:</strong> Use any valid format email. On the Paystack modal, select "Success" or use test card / MoMo numbers to simulate payment without real charges.
    </div>

    <!-- Pay Button -->
    <div style="display: flex; flex-direction: column; gap: 12px;">
        <button id="payButton" type="button" style="width: 100%; background: #0284c7; color: white; border: none; padding: 14px 24px; border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background 0.2s; box-shadow: 0 2px 6px rgba(2,132,199,0.3);">
            Pay GHS <?= number_format($cart_total, 2) ?> Now
        </button>

        <a href="<?= $app_root ?>views/checkout.php" style="text-align: center; color: #64748b; font-size: 14px; text-decoration: none; padding: 8px;">
            &larr; Cancel and return to review order
        </a>
    </div>
</div>

<!-- Paystack Inline Popup JS -->
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    const payBtn = document.getElementById('payButton');

    payBtn.addEventListener('click', function () {
        const handler = PaystackPop.setup({
            key: '<?= htmlspecialchars($public_key) ?>',
            email: '<?= htmlspecialchars($customer_email) ?>',
            amount: <?= (int)$amount_in_pesewas ?>,
            currency: '<?= htmlspecialchars($currency) ?>',
            ref: 'SHP_' + Math.floor((Math.random() * 1000000000) + 1),
            metadata: {
                custom_fields: [
                    {
                        display_name: "Customer Name",
                        variable_name: "customer_name",
                        value: "<?= htmlspecialchars($customer_name) ?>"
                    },
                    {
                        display_name: "Customer ID",
                        variable_name: "customer_id",
                        value: "<?= (int)$customer_id ?>"
                    }
                ]
            },
            callback: function (response) {
                // Payment was successful on Paystack popup
                // Redirect to process_payment.php to verify on server side
                window.location.href = '<?= $app_root ?>actions/process_payment.php?reference=' + encodeURIComponent(response.reference);
            },
            onClose: function () {
                alert('Payment was cancelled. You can retry whenever you are ready.');
            }
        });

        handler.openIframe();
    });
</script>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
