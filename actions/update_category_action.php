<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(get_app_root() . 'views/admin/category.php');
}

$cat_id   = isset($_POST['cat_id']) ? (int)$_POST['cat_id'] : 0;
$cat_name = isset($_POST['cat_name']) ? trim(strip_tags($_POST['cat_name'])) : '';

if ($cat_id <= 0 || empty($cat_name)) {
    $_SESSION['error'] = 'Invalid category details provided.';
    redirect(get_app_root() . 'views/admin/category.php');
}

$controller = new ProductController();
$result = $controller->updateCategory($cat_id, $cat_name);

if ($result) {
    $_SESSION['success'] = 'Category updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update category. Please try again.';
}

redirect(get_app_root() . 'views/admin/category.php');

?>
