<?php
require_once __DIR__ . '/../../core/core.php';
require_admin();

require_once __DIR__ . '/../../controllers/ProductController.php';
$productController = new ProductController();

$edit_mode = false;
$edit_category = null;

if (isset($_GET['edit_id']) && (int)$_GET['edit_id'] > 0) {
    $edit_id = (int)$_GET['edit_id'];
    $edit_category = $productController->getCategoryById($edit_id);
    if ($edit_category) {
        $edit_mode = true;
    }
}

$categories = $productController->getAllCategories();
$app_root = get_app_root();

require_once __DIR__ . '/../layout/header.php';
?>

<div style="padding: 20px; max-width: 800px; margin: 0 auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); margin-top: 20px;">
    <h2>Category Management (Admin)</h2>
    <p style="color: #64748b;">Add and edit product categories for your e-commerce store.</p>

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

    <!-- Add / Edit Category Form -->
    <div style="margin-top: 25px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px;">
        <h3 style="margin-top: 0;"><?= $edit_mode ? 'Edit Category' : 'Add New Category' ?></h3>
        
        <form action="<?= $app_root ?><?= $edit_mode ? 'actions/update_category_action.php' : 'actions/add_category_action.php' ?>" method="POST">
            <?php if ($edit_mode): ?>
                <input type="hidden" name="cat_id" value="<?= htmlspecialchars($edit_category['cat_id']) ?>">
            <?php endif; ?>

            <div style="margin-bottom: 15px;">
                <label style="display: block; font-weight: bold; margin-bottom: 5px;">Category Name *</label>
                <input type="text" name="cat_name" value="<?= $edit_mode ? htmlspecialchars($edit_category['cat_name']) : '' ?>" placeholder="Enter category name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; box-sizing: border-box;">
            </div>

            <div>
                <button type="submit" style="background: <?= $edit_mode ? '#0284c7' : '#16a34a' ?>; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-weight: bold; cursor: pointer;">
                    <?= $edit_mode ? 'Update Category' : 'Add Category' ?>
                </button>
                <?php if ($edit_mode): ?>
                    <a href="category.php" style="margin-left: 10px; color: #64748b; text-decoration: none;">Cancel Edit</a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Categories Table -->
    <div style="margin-top: 30px;">
        <h3>Existing Categories</h3>
        <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse; background: #fff; border-color: #e2e8f0;">
            <thead style="background: #0f172a; color: white;">
                <tr>
                    <th style="width: 15%;">ID</th>
                    <th style="text-align: left;">Category Name</th>
                    <th style="width: 20%; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr>
                            <td style="text-align: center;">#<?= htmlspecialchars($cat['cat_id']) ?></td>
                            <td><?= htmlspecialchars($cat['cat_name']) ?></td>
                            <td style="text-align: center;">
                                <a href="category.php?edit_id=<?= htmlspecialchars($cat['cat_id']) ?>" style="background: #0284c7; color: white; padding: 4px 10px; border-radius: 4px; text-decoration: none; font-size: 13px; font-weight: bold;">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: #64748b; padding: 20px;">No categories found. Add your first category above!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once __DIR__ . '/../layout/footer.php';
?>
