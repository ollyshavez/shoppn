<?php

require_once __DIR__ . '/../core/db_class.php';

// CartClass extends Database (Model layer for shopping cart operations)
class CartClass extends Database
{
    /**
     * Check if a product is already in the cart for a given IP address
     * 
     * @param int $product_id
     * @param string $ip
     * @return bool
     */
    public function isInCart($product_id, $ip)
    {
        $sql = "SELECT p_id FROM cart WHERE p_id = ? AND ip_add = ?";
        $result = $this->fetchOne($sql, [(int)$product_id, $ip]);
        return !empty($result);
    }

    /**
     * Add a product to the cart using prepared statements
     * 
     * @param int $product_id
     * @param int $qty
     * @param string $ip
     * @param int|null $customer_id
     * @return bool
     */
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        $product_id = (int)$product_id;
        $qty = (int)$qty >= 1 ? (int)$qty : 1;

        if ($customer_id !== null && (int)$customer_id > 0) {
            $sql = "INSERT INTO cart (p_id, ip_add, qty, c_id) VALUES (?, ?, ?, ?)";
            return $this->execute($sql, [$product_id, $ip, $qty, (int)$customer_id]);
        } else {
            $sql = "INSERT INTO cart (p_id, ip_add, qty) VALUES (?, ?, ?)";
            return $this->execute($sql, [$product_id, $ip, $qty]);
        }
    }

    /**
     * Retrieve all cart items joined with product details for a given IP
     * 
     * @param string $ip
     * @return array
     */
    public function getCartItems($ip)
    {
        $sql = "SELECT cart.*, products.product_title, products.product_price, products.product_image 
                FROM cart 
                JOIN products ON cart.p_id = products.product_id 
                WHERE cart.ip_add = ?";
        return $this->fetchAll($sql, [$ip]) ?: [];
    }

    /**
     * Get count of items in the cart for a given IP
     * 
     * @param string $ip
     * @return int
     */
    public function getCartCount($ip)
    {
        $sql = "SELECT COUNT(*) as count FROM cart WHERE ip_add = ?";
        $result = $this->fetchOne($sql, [$ip]);
        return $result ? (int)$result['count'] : 0;
    }

    /**
     * Calculate total price of cart items for a given IP
     * 
     * @param string $ip
     * @return float
     */
    public function getCartTotal($ip)
    {
        $items = $this->getCartItems($ip);
        $total = 0.0;
        foreach ($items as $item) {
            $total += ((int)$item['qty'] * (float)$item['product_price']);
        }
        return (float)$total;
    }

    /**
     * Remove a product from the cart for a given IP
     * 
     * @param int $product_id
     * @param string $ip
     * @return bool
     */
    public function removeFromCart($product_id, $ip)
    {
        $sql = "DELETE FROM cart WHERE p_id = ? AND ip_add = ?";
        return $this->execute($sql, [(int)$product_id, $ip]);
    }

    /**
     * Update quantity of a product in the cart for a given IP
     * 
     * @param int $product_id
     * @param int $new_qty
     * @param string $ip
     * @return bool
     */
    public function updateQty($product_id, $new_qty, $ip)
    {
        $new_qty = (int)$new_qty;
        if ($new_qty < 1) {
            return false;
        }
        $sql = "UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?";
        return $this->execute($sql, [$new_qty, (int)$product_id, $ip]);
    }
}
