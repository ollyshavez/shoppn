<?php

require_once __DIR__ . '/../classes/OrderClass.php';

/**
 * OrderController bridges views/actions with OrderClass
 */
class OrderController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderClass();
    }

    public function createOrder($customer_id, $invoice_no, $order_date, $order_status = 'paid')
    {
        return $this->orderModel->createOrder($customer_id, $invoice_no, $order_date, $order_status);
    }

    public function addOrderDetail($order_id, $product_id, $qty)
    {
        return $this->orderModel->addOrderDetail($order_id, $product_id, $qty);
    }

    public function recordPayment($amt, $customer_id, $order_id, $currency, $payment_date)
    {
        return $this->orderModel->recordPayment($amt, $customer_id, $order_id, $currency, $payment_date);
    }

    public function getOrderById($order_id)
    {
        return $this->orderModel->getOrderById($order_id);
    }

    public function getPaymentByOrderId($order_id)
    {
        return $this->orderModel->getPaymentByOrderId($order_id);
    }

    public function getOrderItems($order_id)
    {
        return $this->orderModel->getOrderItems($order_id);
    }

    public function getOrdersByCustomer($customer_id)
    {
        return $this->orderModel->getOrdersByCustomer($customer_id);
    }
}
