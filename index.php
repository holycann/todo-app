<?php
/**
 * Application Entry Point
 * 
 * This is the main entry point for the Todo Application.
 * It initializes the required environment settings and routes
 * then dispatches the incoming HTTP request to the appropriate handler.
 * 
 * @author  Your Name
 * @version 1.0
 */

// Configure error reporting and timezone
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Bangkok');

// Include all necessary route definitions
require_once __DIR__ . '/src/core/Router.php';
require_once __DIR__ . '/src/routes/UserRoute.php';
require_once __DIR__ . '/src/routes/PagesRoute.php';
require_once __DIR__ . '/src/routes/AuthRoute.php';
require_once __DIR__ . '/src/routes/TaskRoute.php';
require_once __DIR__ . '/src/routes/ReminderRoute.php';

// Dispatch the incoming request to the appropriate handler
// This will match the URL to a registered route and execute the corresponding controller method
Router::dispatch();

?>