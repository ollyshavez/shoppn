<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require_once __DIR__ . '/../../controllers/ProductController.php';
$productController = new ProductController();

$edit_mode = false;
$edit_product = null;

if (isset($_GET['edit_id']) && (int)$_GET['edit_id'] > 0) {
    $edit_id = (int)$_GET['edit_id'];
    $edit_product = $productController->getProductById($edit_id);
    if ($edit_product) {
        $edit_mode = true;
    }
}

$categories = $productController->getAllCategories();
$brands     = $productController->getAllBrands();
$products   = $productController->getAllProducts();
$app_root   = get_app_root();

require_once __DIR__ . '/../layout/header.php';
?>

<div style="padding: 20px; max-width: 1000px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 20px;">
    <h2>Product Management (Admin)</h2>
    <p style="color: #64748b;">Add and edit products with images, categories, and brands.</p>

    <?php if (isset($_SESSION['success'])): ?>
        <div style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 4px; margin-top: 15px; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 4px; margin-top: 15px; font-weight: bold;">
            <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Product Form -->
    <div style="margin-top: 25px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
        <h3 style="margin-top: 0;"><?= $edit_mode ? 'Edit Product' : 'Add New Product' ?></h3>

        <form action="<?= $app_root ?><?= $edit_mode ? 'actions/update_product_action.php' : 'actions/add_product_action.php' ?>" method="POST" enctype="multipart/form-data">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($edit_product['product_id']) ?>">
                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($edit_product['product_image']) ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Product Title *</label>
                    <input type="text" name="product_title" value="<?= $edit_mode ? htmlspecialchars($edit_product['product_title']) : '' ?>" placeholder="e.g. iPhone 15 Pro" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Price (GHS) *</label>
                    <input type="number" step="0.01" min="0.01" name="product_price" value="<?= $edit_mode ? htmlspecialchars($edit_product['product_price']) : '' ?>" placeholder="e.g. 1500.00" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Category *</label>
                    <select name="product_cat" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Select Category --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['cat_id']) ?>" <?= ($edit_mode && $edit_product['product_cat'] == $cat['cat_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['cat_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Brand *</label>
                    <select name="product_brand" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
                        <option value="">-- Select Brand --</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= htmlspecialchars($brand['brand_id']) ?>" <?= ($edit_mode && $edit_product['product_brand'] == $brand['brand_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($brand['brand_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Product Description *</label>
                <textarea name="product_desc" rows="4" placeholder="Detailed product specifications and details..." required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;"><?= $edit_mode ? htmlspecialchars($edit_product['product_desc']) : '' ?></textarea>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Keywords * (comma-separated)</label>
                <input type="text" name="product_keywords" value="<?= $edit_mode ? htmlspecialchars($edit_product['product_keywords']) : '' ?>" placeholder="e.g. apple, phone, 5g, smartphone" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Product Image <?= $edit_mode ? '(Leave empty to keep existing image)' : '*' ?></label>
                <input type="file" name="product_image" accept="image/jpeg,image/png,image/gif,image/webp" <?= $edit_mode ? '' : 'required' ?> style="padding: 5px 0;">
                
                <?php if ($edit_mode && !empty($edit_product['product_image'])): ?>
                    <div style="margin-top: 10px;">
                        <span style="font-size: 13px; color: #64748b;">Current Image:</span><br>
                        <img src="<?= $app_root ?>images/products/<?= htmlspecialchars($edit_product['product_image']) ?>" alt="Product Preview" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #cbd5e1; border-radius: 4px; margin-top: 5px;">
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <button type="submit" style="background: <?= $edit_mode ? '#0284c7' : '#16a34a' ?>; color: white; border: none; padding: 10px 25px; border-radius: 4px; font-weight: bold; cursor: pointer; font-size: 14px;">
                    <?= $edit_mode ? 'Update Product' : 'Add Product' ?>
                </button>
                <?php if ($edit_mode): ?>
                    <a href="product.php" style="margin-left: 15px; color: #64748b; text-decoration: none;">Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Existing Products Table -->
    <div style="margin-top: 35px;">
        <h3>Product Inventory</h3>
        <table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; background: #fff; border-color: #e2e8f0;">
            <thead style="background: #0f172a; color: white;">
                <tr>
                    <th style="width: 8%;">ID</th>
                    <th style="width: 12%;">Image</th>
                    <th style="text-align: left;">Title</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: center; width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td style="text-align: center;">#<?= htmlspecialchars($p['product_id']) ?></td>
                            <td style="text-align: center;">
                                <?php if (!empty($p['product_image'])): ?>
                                    <img src="<?= $app_root ?>images/products/<?= htmlspecialchars($p['product_image']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                <?php else: ?>
                                    <span style="color: #94a3b8; font-size: 12px;">No image</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?= htmlspecialchars($p['product_title']) ?></strong></td>
                            <td style="text-align: center;"><?= htmlspecialchars($p['cat_name'] ?? 'N/A') ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($p['brand_name'] ?? 'N/A') ?></td>
                            <td style="text-align: right; font-weight: bold; color: #166534;">GHS <?= number_format((float)$p['product_price'], 2) ?></td>
                            <td style="text-align: center;">
                                <a href="product.php?edit_id=<?= htmlspecialchars($p['product_id']) ?>" style="background: #0284c7; color: white; padding: 4px 8px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold;">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #64748b; padding: 20px;">No products added yet. Add your first product using the form above!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
