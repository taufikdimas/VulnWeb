<?php
// =========================================
// Front Controller - Entry Point
// IntraCorp Portal (Vulnerable Edition)
// =========================================

// Start session
session_start();

// Error reporting (untuk development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define base path for assets
define('BASE_PATH', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'));

// Load core files
require_once '../app/Core/Router.php';
require_once '../app/Core/BaseController.php';

// Initialize router
$router = new Router();
