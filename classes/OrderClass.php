<?php

require_once __DIR__ . '/../core/db_class.php';

/**
 * OrderClass handles database operations for orders, orderdetails, and payment
 */
class OrderClass extends Database
{
    /**
     * Create a new order record
     *
     * @param int $customer_id
     * @param int $invoice_no
     * @param string $order_date
     * @param string $order_status
     * @return int|false Returns newly inserted order_id or false on failure
     */
    public function createOrder($customer_id, $invoice_no, $order_date, $order_status = 'paid')
    {
        $sql = "INSERT INTO orders (customer_id, invoice_no, order_date, order_status) VALUES (?, ?, ?, ?)";
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([(int)$customer_id, (int)$invoice_no, $order_date, $order_status]);
        if ($success) {
            return (int)$conn->lastInsertId();
        }
        return false;
    }

    /**
     * Add product item to orderdetails
     *
     * @param int $order_id
     * @param int $product_id
     * @param int $qty
     * @return bool
     */
    public function addOrderDetail($order_id, $product_id, $qty)
    {
        $sql = "INSERT INTO orderdetails (order_id, product_id, qty) VALUES (?, ?, ?)";
        return $this->execute($sql, [(int)$order_id, (int)$product_id, (int)$qty]);
    }

    /**
     * Record a payment transaction
     *
     * @param float $amt
     * @param int $customer_id
     * @param int $order_id
     * @param string $currency
     * @param string $payment_date
     * @return int|false
     */
    public function recordPayment($amt, $customer_id, $order_id, $currency, $payment_date)
    {
        $sql = "INSERT INTO payment (amt, customer_id, order_id, currency, payment_date) VALUES (?, ?, ?, ?, ?)";
        $conn = $this->getConnection();
        $stmt = $conn->prepare($sql);
        $success = $stmt->execute([(float)$amt, (int)$customer_id, (int)$order_id, $currency, $payment_date]);
        if ($success) {
            return (int)$conn->lastInsertId();
        }
        return false;
    }

    /**
     * Get order summary by order ID
     *
     * @param int $order_id
     * @return array|false
     */
    public function getOrderById($order_id)
    {
        $sql = "SELECT o.*, c.customer_name, c.customer_email, c.customer_contact 
                FROM orders o 
                JOIN customer c ON o.customer_id = c.customer_id 
                WHERE o.order_id = ?";
        return $this->fetchOne($sql, [(int)$order_id]);
    }

    /**
     * Get payment info by order ID
     *
     * @param int $order_id
     * @return array|false
     */
    public function getPaymentByOrderId($order_id)
    {
        $sql = "SELECT * FROM payment WHERE order_id = ?";
        return $this->fetchOne($sql, [(int)$order_id]);
    }

    /**
     * Get list of items in an order with product info
     *
     * @param int $order_id
     * @return array
     */
    public function getOrderItems($order_id)
    {
        $sql = "SELECT od.*, p.product_title, p.product_price, p.product_image 
                FROM orderdetails od 
                JOIN products p ON od.product_id = p.product_id 
                WHERE od.order_id = ?";
        return $this->fetchAll($sql, [(int)$order_id]) ?: [];
    }

    /**
     * Get all orders for a specific customer
     *
     * @param int $customer_id
     * @return array
     */
    public function getOrdersByCustomer($customer_id)
    {
        $sql = "SELECT o.*, p.amt, p.currency, p.payment_date 
                FROM orders o 
                LEFT JOIN payment p ON o.order_id = p.order_id 
                WHERE o.customer_id = ? 
                ORDER BY o.order_id DESC";
        return $this->fetchAll($sql, [(int)$customer_id]) ?: [];
    }
}
