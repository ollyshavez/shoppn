<?php

// Bring in the Customer model class
require_once __DIR__ . "/../classes/CustomerClass.php";

// The controller sits between actions/functions/views and the model (Customer).
class CustomerController
{
    // Holds the Customer instance
    private $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    // Insert a new customer (template method signature)
    public function insert($name, $email, $pass, $country, $city, $contact, $image = null, $role = 2)
    {
        return $this->customer->insertCustomer($name, $email, $pass, $country, $city, $contact, $image, $role);
    }

    // Get the full list of customers
    public function selectAll()
    {
        return $this->customer->getAllCustomers();
    }

    // Registration handling for array data
    public function register($data)
    {
        $name    = $data['name'] ?? $data['customer_name'] ?? '';
        $email   = $data['email'] ?? $data['customer_email'] ?? '';
        $pass    = $data['password'] ?? $data['pass'] ?? $data['customer_pass'] ?? '';
        $country = $data['country'] ?? $data['customer_country'] ?? '';
        $city    = $data['city'] ?? $data['customer_city'] ?? '';
        $contact = $data['contact'] ?? $data['customer_contact'] ?? '';
        $image   = $data['image'] ?? $data['customer_image'] ?? null;
        $role    = $data['role'] ?? $data['user_role'] ?? 2;

        if ($this->customer->emailExists($email)) {
            return ["success" => false, "message" => "Email address is already registered."];
        }

        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        $inserted   = $this->customer->insertCustomer($name, $email, $hashedPass, $country, $city, $contact, $image, $role);

        if ($inserted) {
            return ["success" => true, "message" => "Registration successful."];
        }
        return ["success" => false, "message" => "Registration failed."];
    }

    // Authenticate customer login
    public function login($email, $pass)
    {
        return $this->customer->login($email, $pass);
    }

    // Get customer details by email
    public function getCustomerByEmail($email)
    {
        return $this->customer->getCustomerByEmail($email);
    }
}

?>
