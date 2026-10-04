<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(get_app_root() . 'views/admin/brand.php');
}

$brand_id   = isset($_POST['brand_id']) ? (int)$_POST['brand_id'] : 0;
$brand_name = isset($_POST['brand_name']) ? trim(strip_tags($_POST['brand_name'])) : '';

if ($brand_id <= 0 || empty($brand_name)) {
    $_SESSION['error'] = 'Invalid brand details provided.';
    redirect(get_app_root() . 'views/admin/brand.php');
}

$controller = new ProductController();
$result = $controller->updateBrand($brand_id, $brand_name);

if ($result) {
    $_SESSION['success'] = 'Brand updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update brand. Please try again.';
}

redirect(get_app_root() . 'views/admin/brand.php');

?>
