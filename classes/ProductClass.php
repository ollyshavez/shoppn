<?php

require_once __DIR__ . '/../core/db_class.php';

// ProductClass extends Database (Model layer for brands, categories, and products)
class ProductClass extends Database
{
    // ==========================================
    // BRAND METHODS (Tasks 5 & 6)
    // ==========================================

    // Insert a new brand
    public function addBrand($name)
    {
        $sql = "INSERT INTO brands (brand_name) VALUES (?)";
        return $this->execute($sql, [$name]);
    }

    // Get all brands ordered by name ASC
    public function getAllBrands()
    {
        $sql = "SELECT * FROM brands ORDER BY brand_name ASC";
        return $this->fetchAll($sql) ?: [];
    }

    // Get single brand by brand_id
    public function getBrandById($id)
    {
        $sql = "SELECT * FROM brands WHERE brand_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Update existing brand by brand_id
    public function updateBrand($id, $name)
    {
        $sql = "UPDATE brands SET brand_name = ? WHERE brand_id = ?";
        return $this->execute($sql, [$name, $id]);
    }

    // ==========================================
    // CATEGORY METHODS (Tasks 7 & 8)
    // ==========================================

    // Insert a new category
    public function addCategory($name)
    {
        $sql = "INSERT INTO categories (cat_name) VALUES (?)";
        return $this->execute($sql, [$name]);
    }

    // Get all categories ordered by name ASC
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories ORDER BY cat_name ASC";
        return $this->fetchAll($sql) ?: [];
    }

    // Get single category by cat_id
    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM categories WHERE cat_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Update existing category by cat_id
    public function updateCategory($id, $name)
    {
        $sql = "UPDATE categories SET cat_name = ? WHERE cat_id = ?";
        return $this->execute($sql, [$name, $id]);
    }

    // ==========================================
    // PRODUCT METHODS (Task 9: Add & Edit)
    // ==========================================

    // Insert a new product
    public function addProduct($cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $sql = "INSERT INTO products (
            product_cat, 
            product_brand, 
            product_title, 
            product_price, 
            product_desc, 
            product_image, 
            product_keywords
        ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        return $this->execute($sql, [
            $cat,
            $brand,
            $title,
            $price,
            $desc,
            $image_filename,
            $keywords
        ]);
    }

    // Update an existing product
    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image_filename, $keywords)
    {
        $sql = "UPDATE products SET 
            product_cat = ?, 
            product_brand = ?, 
            product_title = ?, 
            product_price = ?, 
            product_desc = ?, 
            product_image = ?, 
            product_keywords = ? 
            WHERE product_id = ?";

        return $this->execute($sql, [
            $cat,
            $brand,
            $title,
            $price,
            $desc,
            $image_filename,
            $keywords,
            $id
        ]);
    }

    // Get single product by ID joined with category and brand names
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_id = ?";

        return $this->fetchOne($sql, [$id]);
    }

    // Get all products ordered newest first
    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                ORDER BY p.product_id DESC";

        return $this->fetchAll($sql) ?: [];
    }

    // ==========================================
    // PRODUCT DISPLAY & SEARCH (Task 10)
    // ==========================================

    // Get featured/random products
    public function getFeaturedProducts($limit = 6)
    {
        $limit = max(1, (int)$limit);
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                ORDER BY RAND() LIMIT $limit";

        return $this->fetchAll($sql) ?: [];
    }

    // Filter products by category
    public function getProductsByCategory($cat_id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_cat = ? 
                ORDER BY p.product_id DESC";

        return $this->fetchAll($sql, [$cat_id]) ?: [];
    }

    // Filter products by brand
    public function getProductsByBrand($brand_id)
    {
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_brand = ? 
                ORDER BY p.product_id DESC";

        return $this->fetchAll($sql, [$brand_id]) ?: [];
    }

    // Search products by title or keywords
    public function searchProducts($query)
    {
        $term = '%' . trim($query) . '%';
        $sql = "SELECT p.*, c.cat_name, b.brand_name 
                FROM products p 
                LEFT JOIN categories c ON p.product_cat = c.cat_id 
                LEFT JOIN brands b ON p.product_brand = b.brand_id 
                WHERE p.product_title LIKE ? OR p.product_keywords LIKE ? 
                ORDER BY p.product_id DESC";

        return $this->fetchAll($sql, [$term, $term]) ?: [];
    }
}

// Alias for ProductClass
if (!class_exists('Product')) {
    class Product extends ProductClass {}
}

?>
