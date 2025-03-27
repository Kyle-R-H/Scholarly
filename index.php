<?php
// Start session if needed
session_start();

// Include the router
require_once 'Core/Router.php';

// Default to login page
if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    header("Location: ?controller=auth&action=loginView");
    exit;
}
?>