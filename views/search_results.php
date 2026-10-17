<?php
require_once __DIR__ . '/layout/header.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$app_root = get_app_root();
$query = isset($_GET['user_query']) ? trim($_GET['user_query']) : '';

$productController = new ProductController();
$products = !empty($query) ? $productController->searchProducts($query) : [];
?>

<div style="display: flex; gap: 30px; margin-top: 25px; align-items: flex-start;">
    <!-- Sidebar for Categories & Brands Filtering -->
    <?php include_once __DIR__ . '/layout/sidebar.php'; ?>

    <!-- Main Search Results Section -->
    <section style="flex: 1;">
        <div style="border-bottom: 2px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #0f172a; font-size: 22px;">Search Results for "<?= htmlspecialchars($query) ?>"</h2>
            <span style="color: #64748b; font-size: 14px;"><?= count($products) ?> matching product(s) found</span>
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

        <?php if (!empty($products)): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px;">
                <?php foreach ($products as $p): ?>
                    <div style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                        <div style="height: 180px; background: #f8fafc; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                            <?php if (!empty($p['product_image'])): ?>
                                <img src="<?= $app_root ?>images/products/<?= htmlspecialchars($p['product_image']) ?>" alt="<?= htmlspecialchars($p['product_title']) ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            <?php else: ?>
                                <div style="color: #94a3b8; font-size: 13px;">No image available</div>
                            <?php endif; ?>
                        </div>

                        <div style="padding: 15px; display: flex; flex-direction: column; flex-grow: 1;">
                            <span style="font-size: 11px; text-transform: uppercase; color: #0284c7; font-weight: bold; margin-bottom: 4px;">
                                <?= htmlspecialchars($p['brand_name'] ?? 'Brand') ?> &bull; <?= htmlspecialchars($p['cat_name'] ?? 'Category') ?>
                            </span>

                            <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #0f172a; line-height: 1.3;">
                                <a href="<?= $app_root ?>views/single_product.php?pro_id=<?= htmlspecialchars($p['product_id']) ?>" style="color: inherit; text-decoration: none;">
                                    <?= htmlspecialchars($p['product_title']) ?>
                                </a>
                            </h3>

                            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                <span style="font-size: 17px; font-weight: bold; color: #166534;">
                                    GHS <?= number_format((float)$p['product_price'], 2) ?>
                                </span>
                            </div>

                            <div style="display: flex; gap: 8px; margin-top: 12px;">
                                <a href="<?= $app_root ?>views/single_product.php?pro_id=<?= htmlspecialchars($p['product_id']) ?>" style="flex: 1; text-align: center; background: #f1f5f9; color: #334155; padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-decoration: none;">
                                    Details
                                </a>
                                <a href="<?= $app_root ?>actions/add_to_cart_action.php?add_cart=<?= htmlspecialchars($p['product_id']) ?>" style="flex: 1; text-align: center; background: #0284c7; color: white; padding: 7px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; text-decoration: none;">
                                    Add to Cart
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="padding: 40px; text-align: center; background: #fff; border-radius: 8px; border: 1px dashed #cbd5e1;">
                <p style="color: #64748b; font-size: 16px; margin: 0;">No products matched your search "<?= htmlspecialchars($query) ?>".</p>
                <a href="<?= $app_root ?>index.php" style="display: inline-block; margin-top: 12px; color: #0284c7; text-decoration: none; font-weight: bold;">View All Products</a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php
require_once __DIR__ . '/layout/footer.php';
?>
