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
        return $this->fetchAll($sql);
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
        return $this->fetchAll($sql);
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
}

// Alias for ProductClass
if (!class_exists('Product')) {
    class Product extends ProductClass {}
}

?>
