<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Invalid request method.';
    redirect(get_app_root() . 'views/admin/product.php');
}

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$title      = isset($_POST['product_title']) ? trim(strip_tags($_POST['product_title'])) : '';
$price      = isset($_POST['product_price']) ? trim($_POST['product_price']) : '';
$cat_id     = isset($_POST['product_cat']) ? (int)$_POST['product_cat'] : 0;
$brand_id   = isset($_POST['product_brand']) ? (int)$_POST['product_brand'] : 0;
$desc       = isset($_POST['product_desc']) ? trim(strip_tags($_POST['product_desc'])) : '';
$keywords   = isset($_POST['product_keywords']) ? trim(strip_tags($_POST['product_keywords'])) : '';
$existing_image = isset($_POST['existing_image']) ? trim($_POST['existing_image']) : '';

if ($product_id <= 0 || empty($title) || empty($price) || empty($desc) || $cat_id <= 0 || $brand_id <= 0) {
    $_SESSION['error'] = 'Please fill in all required product fields.';
    redirect(get_app_root() . 'views/admin/product.php?edit_id=' . $product_id);
}

if (!is_numeric($price) || (float)$price <= 0) {
    $_SESSION['error'] = 'Product price must be a valid positive number.';
    redirect(get_app_root() . 'views/admin/product.php?edit_id=' . $product_id);
}

$price = (float)$price;
$image_filename = $existing_image;

// Check if new image was uploaded
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $fileTmp  = $_FILES['product_image']['tmp_name'];
    $fileSize = $_FILES['product_image']['size'];
    $fileName = $_FILES['product_image']['name'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $fileTmp);
    finfo_close($finfo);

    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, GIF, and WEBP images are allowed.';
        redirect(get_app_root() . 'views/admin/product.php?edit_id=' . $product_id);
    }

    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['error'] = 'Image size exceeds maximum limit of 5MB.';
        redirect(get_app_root() . 'views/admin/product.php?edit_id=' . $product_id);
    }

    $cleanName = preg_replace('/[^a-zA-Z0-9._-]/', '', basename($fileName));
    $new_filename = uniqid('prod_') . '_' . $cleanName;

    $uploadDir = __DIR__ . '/../images/products/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $targetPath = $uploadDir . $new_filename;
    if (move_uploaded_file($fileTmp, $targetPath)) {
        $image_filename = $new_filename;
    } else {
        $_SESSION['error'] = 'Failed to upload new product image.';
        redirect(get_app_root() . 'views/admin/product.php?edit_id=' . $product_id);
    }
}

$controller = new ProductController();
$result = $controller->updateProduct($product_id, $cat_id, $brand_id, $title, $price, $desc, $image_filename, $keywords);

if ($result) {
    $_SESSION['success'] = 'Product updated successfully.';
} else {
    $_SESSION['error'] = 'Failed to update product details.';
}

redirect(get_app_root() . 'views/admin/product.php');

?>
