<?php

// This is a "function" file - a small helper that a view (page) can
// include when it needs data but doesn't need the full action/JSON flow.
require_once __DIR__ . "/../controller/CustomerController.php";

// Get all customers via the controller.
function getAllCustomersList()
{
    $controller = new CustomerController();
    return $controller->selectAll();
}

?>
