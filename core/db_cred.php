<?php

$is_local = (isset($_SERVER['HTTP_HOST']) && ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1')) 
            || (php_sapi_name() === 'cli' && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');

if ($is_local) {
    // Local XAMPP Credentials
    define('SERVER', 'localhost');
    define('USERNAME', 'root');
    define('PASSWD', '');
    define('DATABASE', 'shoppn');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'shoppn');
} else {
    // Live Server Credentials
    define('SERVER', 'localhost');
    define('USERNAME', 'kwizera.olivier');
    define('PASSWD', '1510123456');
    define('DATABASE', 'ecommerce_2026A_kwizera_olivier');

    define('DB_HOST', 'localhost');
    define('DB_USER', 'kwizera.olivier');
    define('DB_PASS', '1510123456');
    define('DB_NAME', 'ecommerce_2026A_kwizera_olivier');
}

?>