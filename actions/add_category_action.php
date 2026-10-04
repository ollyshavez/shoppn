<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(get_app_root() . 'views/admin/category.php');
}

$cat_name = isset($_POST['cat_name']) ? trim(strip_tags($_POST['cat_name'])) : '';

if (empty($cat_name)) {
    $_SESSION['error'] = 'Category name cannot be empty.';
    redirect(get_app_root() . 'views/admin/category.php');
}

$controller = new ProductController();
$result = $controller->addCategory($cat_name);

if ($result) {
    $_SESSION['success'] = 'Category added successfully.';
} else {
    $_SESSION['error'] = 'Failed to add category. Please try again.';
}

redirect(get_app_root() . 'views/admin/category.php');

?>
