<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$app_root = get_app_root();

$pro_id = isset($_GET['pro_id']) ? (int)$_GET['pro_id'] : 0;
if ($pro_id <= 0) {
    redirect($app_root . 'index.php');
}

$productController = new ProductController();
$product = $productController->getProductById($pro_id);

if (!$product) {
    $_SESSION['error'] = 'The requested product could not be found.';
    redirect($app_root . 'index.php');
}

require_once __DIR__ . '/layout/header.php';
?>

<div style="max-width: 900px; margin: 30px auto; background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
    <div style="margin-bottom: 20px;">
        <a href="<?= $app_root ?>index.php" style="color: #0284c7; text-decoration: none; font-weight: bold; font-size: 14px;">&larr; Back to Products</a>
    </div>

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

    <div style="display: flex; gap: 40px; flex-wrap: wrap;">
        <!-- Product Image Display -->
        <div style="flex: 1; min-width: 280px; max-width: 400px; display: flex; align-items: center; justify-content: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; min-height: 350px;">
            <?php if (!empty($product['product_image'])): ?>
                <img src="<?= $app_root ?>images/products/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_title']) ?>" style="max-width: 100%; max-height: 350px; object-fit: contain;">
            <?php else: ?>
                <div style="color: #94a3b8; font-size: 16px;">No Image Available</div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div style="flex: 1.2; min-width: 300px; display: flex; flex-direction: column;">
            <div style="margin-bottom: 10px;">
                <span style="display: inline-block; background: #e0f2fe; color: #0369a1; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; margin-right: 8px;">
                    Category: <?= htmlspecialchars($product['cat_name'] ?? 'General') ?>
                </span>
                <span style="display: inline-block; background: #f1f5f9; color: #334155; padding: 3px 10px; border-radius: 4px; font-size: 12px; font-weight: bold;">
                    Brand: <?= htmlspecialchars($product['brand_name'] ?? 'Generic') ?>
                </span>
            </div>

            <h1 style="margin: 0 0 15px 0; color: #0f172a; font-size: 28px; line-height: 1.2;">
                <?= htmlspecialchars($product['product_title']) ?>
            </h1>

            <div style="font-size: 26px; font-weight: bold; color: #166534; margin-bottom: 20px;">
                GHS <?= number_format((float)$product['product_price'], 2) ?>
            </div>

            <div style="margin-bottom: 25px;">
                <h4 style="margin: 0 0 8px 0; color: #334155; font-size: 15px;">Product Description:</h4>
                <p style="color: #64748b; line-height: 1.6; margin: 0; font-size: 15px; white-space: pre-line;">
                    <?= htmlspecialchars($product['product_desc']) ?>
                </p>
            </div>

            <?php if (!empty($product['product_keywords'])): ?>
                <div style="margin-bottom: 25px;">
                    <span style="font-size: 13px; color: #94a3b8; font-weight: bold;">Tags / Keywords:</span>
                    <span style="font-size: 13px; color: #475569;"><?= htmlspecialchars($product['product_keywords']) ?></span>
                </div>
            <?php endif; ?>

            <div style="margin-top: auto; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 15px; align-items: center;">
                <a href="<?= $app_root ?>actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($product['product_id']) ?>" style="background: #16a34a; color: white; padding: 12px 30px; border-radius: 6px; font-size: 15px; font-weight: bold; text-decoration: none; display: inline-block;">
                    Add to Cart
                </a>
                <a href="<?= $app_root ?>index.php" style="color: #64748b; text-decoration: none; font-size: 14px;">
                    Continue Browsing
                </a>
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
