<?php
require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

$sidebarController = new ProductController();
$sidebarCategories = $sidebarController->getAllCategories();
$sidebarBrands     = $sidebarController->getAllBrands();
$app_root          = get_app_root();

$active_cat   = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$active_brand = isset($_GET['brand']) ? (int)$_GET['brand'] : 0;
?>

<aside class="sidebar-box" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.06); min-width: 220px;">
    <h3 style="margin-top: 0; border-bottom: 2px solid #0284c7; padding-bottom: 8px; color: #0f172a; font-size: 16px;">Categories</h3>
    <ul class="sidebar-list" style="list-style: none; padding: 0; margin: 10px 0 25px 0;">
        <li style="margin-bottom: 8px;">
            <a href="<?= $app_root ?>index.php" style="text-decoration: none; color: <?= ($active_cat === 0 && $active_brand === 0) ? '#0284c7; font-weight: bold;' : '#475569;' ?>">
                All Categories
            </a>
        </li>
        <?php foreach ($sidebarCategories as $c): ?>
            <li style="margin-bottom: 8px;">
                <a href="<?= $app_root ?>index.php?cat=<?= htmlspecialchars($c['cat_id']) ?>" style="text-decoration: none; color: <?= ($active_cat === (int)$c['cat_id']) ? '#0284c7; font-weight: bold;' : '#475569;' ?>">
                    <?= htmlspecialchars($c['cat_name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3 style="border-bottom: 2px solid #0284c7; padding-bottom: 8px; color: #0f172a; font-size: 16px;">Brands</h3>
    <ul class="sidebar-list" style="list-style: none; padding: 0; margin: 10px 0 0 0;">
        <li style="margin-bottom: 8px;">
            <a href="<?= $app_root ?>index.php" style="text-decoration: none; color: #475569;">
                All Brands
            </a>
        </li>
        <?php foreach ($sidebarBrands as $b): ?>
            <li style="margin-bottom: 8px;">
                <a href="<?= $app_root ?>index.php?brand=<?= htmlspecialchars($b['brand_id']) ?>" style="text-decoration: none; color: <?= ($active_brand === (int)$b['brand_id']) ? '#0284c7; font-weight: bold;' : '#475569;' ?>">
                    <?= htmlspecialchars($b['brand_name']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</aside>