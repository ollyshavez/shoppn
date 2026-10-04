<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(get_app_root() . 'views/admin/brand.php');
}

$brand_name = isset($_POST['brand_name']) ? trim(strip_tags($_POST['brand_name'])) : '';

if (empty($brand_name)) {
    $_SESSION['error'] = 'Brand name cannot be empty.';
    redirect(get_app_root() . 'views/admin/brand.php');
}

$controller = new ProductController();
$result = $controller->addBrand($brand_name);

if ($result) {
    $_SESSION['success'] = 'Brand added successfully.';
} else {
    $_SESSION['error'] = 'Failed to add brand. Please try again.';
}

redirect(get_app_root() . 'views/admin/brand.php');

?>
