<?php

require_once __DIR__ . '/../classes/CartClass.php';

// CartController mediates between cart actions/views and the CartClass model
class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new CartClass();
    }

    /**
     * Check if a product is in the cart
     */
    public function isInCart($product_id, $ip)
    {
        return $this->cartModel->isInCart($product_id, $ip);
    }

    /**
     * Add product to cart
     */
    public function addToCart($product_id, $qty, $ip, $customer_id = null)
    {
        return $this->cartModel->addToCart($product_id, $qty, $ip, $customer_id);
    }

    /**
     * Get all cart items for a given IP
     */
    public function getCartItems($ip)
    {
        return $this->cartModel->getCartItems($ip);
    }

    /**
     * Get total count of cart items for a given IP
     */
    public function getCartCount($ip)
    {
        return $this->cartModel->getCartCount($ip);
    }

    /**
     * Get cart monetary total for a given IP
     */
    public function getCartTotal($ip)
    {
        return $this->cartModel->getCartTotal($ip);
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart($product_id, $ip)
    {
        return $this->cartModel->removeFromCart($product_id, $ip);
    }

    /**
     * Update quantity of product in cart
     */
    public function updateQty($product_id, $new_qty, $ip)
    {
        return $this->cartModel->updateQty($product_id, $new_qty, $ip);
    }
}
