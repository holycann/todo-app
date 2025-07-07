<?php
/**
 * Database Connection Class
 * 
 * This class manages the database connection for the Todo application.
 * It implements the Singleton pattern to ensure only one PDO instance
 * is created throughout the application's lifecycle, reducing overhead
 * and maintaining connection state.
 * 
 * The connection parameters are loaded from the environment configuration file.
 */

class DatabaseConnection
{
    /**
     * PDO instance for database connection
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    /**
     * Establishes and returns a database connection
     * 
     * This method uses lazy loading to create a PDO connection only when needed.
     * If a connection already exists, it returns the existing connection.
     * It configures PDO to throw exceptions on errors and sets the default fetch mode.
     * 
     * @return PDO Active database connection
     * @throws PDOException If connection fails (caught internally)
     */
    public static function connect(): PDO
    {
        if (self::$pdo === null) {
            $env = require __DIR__ . '/../../config/env.php';
            $dbConfig = $env['db'] ?? [];
            $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}";

            try {
                self::$pdo = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

?>