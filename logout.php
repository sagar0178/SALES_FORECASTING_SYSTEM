<?php
// Start the session
session_start();

// Destroy all session variables
$_SESSION = array();

// If there is a session cookie, delete it
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: admin_login.php");
exit;