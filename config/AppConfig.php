<?php
/**
 * Application Configuration Constants
 * 
 * This file defines global constants used throughout the application.
 * It loads environment variables from env.php and creates constants
 * for easier access to common configuration values.
 */

// Load environment configuration
$env = require_once __DIR__ . '/env.php';

// Define application constants
define('APP_NAME', $env['app_name']);       // Application name for display purposes
define('BASE_ENDPOINT', $env['base_endpoint']); // Base path for routing
define('ASSETS_URL', $env['base_url'] . $env['base_endpoint'] . '/assets'); // URL for static assets

// Configure session lifetime (1 hour)
ini_set('session.gc_maxlifetime', 3600);

?>