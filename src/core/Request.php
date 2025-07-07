<?php
/**
 * Request Class
 * 
 * This utility class provides a clean interface for accessing HTTP request data.
 * It handles different request methods (GET, POST, PUT, DELETE) and provides
 * methods to extract and sanitize request parameters, ensuring data safety.
 * 
 * The class is designed using the static facade pattern to provide a simple
 * API for controllers to access request data without managing request objects.
 */

require_once __DIR__ . '/../../config/AppConfig.php';

class Request
{
    /**
     * Gets the current HTTP request method
     * 
     * @return string The request method (GET, POST, PUT, DELETE, etc.)
     */
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Gets the current request URI path
     * 
     * This method removes the base endpoint from the URI to get the relevant
     * application path for routing purposes.
     * 
     * @return string The processed URI path
     */
    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $baseEndpoint = BASE_ENDPOINT;
        if (strpos($uri, $baseEndpoint) === 0) {
            $uri = substr($uri, strlen($baseEndpoint));
        }
        return $uri;
    }

    /**
     * Gets a sanitized value from the GET parameters
     * 
     * @param string $key The parameter key to retrieve
     * @param mixed $default Default value if the key doesn't exist
     * @return mixed The sanitized value or default if not found
     */
    public static function get(string $key, $default = null)
    {
        return self::sanitize($_GET[$key] ?? $default);
    }

    /**
     * Gets a sanitized value from the POST parameters
     * 
     * @param string $key The parameter key to retrieve
     * @param mixed $default Default value if the key doesn't exist
     * @return mixed The sanitized value or default if not found
     */
    public static function post(string $key, $default = null)
    {
        return self::sanitize($_POST[$key] ?? $default);
    }

    /**
     * Gets a sanitized value from the PUT request data
     * 
     * Parses the raw request body for PUT requests to extract parameters.
     * 
     * @param string $key The parameter key to retrieve
     * @param mixed $default Default value if the key doesn't exist
     * @return mixed The sanitized value or default if not found
     */
    public static function put(string $key, $default = null)
    {
        parse_str(file_get_contents('php://input'), $putData);
        return self::sanitize($putData[$key] ?? $default);
    }

    /**
     * Gets a sanitized value from the DELETE request data
     * 
     * Parses the raw request body for DELETE requests to extract parameters.
     * 
     * @param string $key The parameter key to retrieve
     * @param mixed $default Default value if the key doesn't exist
     * @return mixed The sanitized value or default if not found
     */
    public static function delete(string $key, $default = null)
    {
        parse_str(file_get_contents('php://input'), $deleteData);
        return self::sanitize($deleteData[$key] ?? $default);
    }

    /**
     * Gets all request parameters combined from different sources
     * 
     * This method merges data from GET, POST, and the request body for
     * PUT, PATCH, and DELETE requests, supporting both URL-encoded and JSON formats.
     * All values are sanitized before being returned.
     * 
     * @return array Array of all request parameters
     */
    public static function all(): array
    {
        $data = array_merge($_GET, $_POST);

        if (in_array(self::method(), ['PUT', 'PATCH', 'DELETE'])) {
            $rawInput = file_get_contents('php://input');

            $jsonData = json_decode($rawInput, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $data = array_merge($data, $jsonData);
            } else {
                parse_str($rawInput, $inputData);
                $data = array_merge($data, $inputData);
            }
        }

        return array_map([self::class, 'sanitize'], $data);
    }

    /**
     * Sanitizes input data to prevent XSS attacks
     * 
     * Recursively processes arrays and applies htmlspecialchars to string values.
     * 
     * @param mixed $value The value to sanitize
     * @return mixed The sanitized value
     */
    private static function sanitize($value)
    {
        if (is_array($value)) {
            return array_map([self::class, 'sanitize'], $value);
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}