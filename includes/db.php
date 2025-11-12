<?php
/**
 * Database Connection File
 * MadeInUIU - Built by UIU Minds
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'uiuarchive');

// Base URL Configuration
define('BASE_URL', '/MadeInUIU-web');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4 for emoji and special character support
mysqli_set_charset($conn, "utf8mb4");

// Function to close database connection
function closeConnection() {
    global $conn;
    if ($conn) {
        mysqli_close($conn);
    }
}
?>
