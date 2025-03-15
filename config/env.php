<?php
/**
 * Environment Configuration
 * 
 * This file contains environment-specific configuration settings for the application,
 * including database connection details and application paths.
 * 
 * In a production environment, this file would typically be excluded from version control
 * and configured differently on each deployment environment.
 */

return [
    // Application name used for branding and titles
    'app_name' => 'Todo App',
    
    // Base URL for the application, dynamically determined from the server environment
    'base_url' => 'http://' . $_SERVER['HTTP_HOST'],
    
    // Base endpoint for the application, useful for applications not running in the web root
    'base_endpoint' => dirname($_SERVER['SCRIPT_NAME']),
    
    // Database connection configuration
    'db' => [
        'host' => 'localhost',      // Database server hostname
        'dbname' => 'todo_app_db',  // Database name
        'username' => 'root',       // Database username
        'password' => '',           // Database password (empty for local development)
        'charset' => 'utf8mb4',     // Character set for proper Unicode handling
    ],
];

?>