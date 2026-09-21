<?php

// Bring in the Database class so Customer can extend it
require_once __DIR__ . "/../core/db_class.php";

// This is the "model" layer for the customer table. It only knows about
// the `customer` table and the SQL needed to read/write it.
// "extends Database" means Customer automatically inherits the connection
// logic and the fetchAll()/fetchOne()/execute() helper methods.
class Customer extends Database
{
    // Insert a new customer row (registration)
    public function insertCustomer($name, $email, $pass, $country, $city, $contact, $image = null, $role = 2)
    {
        $sql = "
            INSERT INTO customer (
                customer_name,
                customer_email,
                customer_pass,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ";

        return $this->execute(
            $sql,
            [$name, $email, $pass, $country, $city, $contact, $image, $role]
        );
    }

    // Alias for insertCustomer
    public function addCustomer($name, $email, $pass, $country, $city, $contact, $image = null, $role = 2)
    {
        return $this->insertCustomer($name, $email, $pass, $country, $city, $contact, $image, $role);
    }

    // Get every customer in the table, newest first
    public function getAllCustomers()
    {
        $sql = "
            SELECT
                customer_id,
                customer_name,
                customer_email,
                customer_country,
                customer_city,
                customer_contact,
                customer_image,
                user_role
            FROM customer
            ORDER BY customer_id DESC
        ";

        return $this->fetchAll($sql);
    }

    // Find a customer by email address
    public function getCustomerByEmail($email)
    {
        $sql = "SELECT * FROM customer WHERE customer_email = ?";
        return $this->fetchOne($sql, [$email]);
    }

    // Check if an email address already exists in database
    public function emailExists($email)
    {
        $user = $this->getCustomerByEmail($email);
        return !empty($user);
    }

    // Find a customer by ID
    public function getCustomerById($id)
    {
        $sql = "SELECT customer_id, customer_name, customer_email, customer_country, customer_city, customer_contact, customer_image, user_role FROM customer WHERE customer_id = ?";
        return $this->fetchOne($sql, [$id]);
    }

    // Authenticate a customer with email and password
    public function login($email, $pass)
    {
        $user = $this->getCustomerByEmail($email);
        if ($user && password_verify($pass, $user['customer_pass'])) {
            return $user;
        }
        return false;
    }
}

// Backward compatibility alias class
if (!class_exists('CustomerClass')) {
    class CustomerClass extends Customer {}
}

?>
