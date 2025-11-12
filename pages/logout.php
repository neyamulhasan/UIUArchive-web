<?php
/**
 * Logout
 * UIUArchive - Built by UIU Minds
 */

session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Clear remember me cookie
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/');
}

// Redirect to homepage
header("Location: index.php");
exit();
?>
