<?php

require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../core/Response.php';

/**
 * Router Class
 * 
 * A simple static router implementation that handles HTTP request routing
 * for the application. It maps URIs to their corresponding handlers based on
 * HTTP methods (GET, POST, PUT, DELETE) and supports dynamic route parameters.
 */
class Router
{
    /**
     * Array to store all registered routes
     * @var array
     */
    private static $routes = [];

    /**
     * Register a route for GET requests
     * 
     * @param string $path The URI path pattern to match
     * @param mixed $handler The handler function or controller method to execute
     * @return void
     */
    public static function get(string $path, $handler)
    {
        self::addRoute('GET', $path, $handler);
    }

    /**
     * Register a route for POST requests
     * 
     * @param string $path The URI path pattern to match
     * @param mixed $handler The handler function or controller method to execute
     * @return void
     */
    public static function post(string $path, $handler)
    {
        self::addRoute('POST', $path, $handler);
    }

    /**
     * Register a route for PUT requests
     * 
     * @param string $path The URI path pattern to match
     * @param mixed $handler The handler function or controller method to execute
     * @return void
     */
    public static function put(string $path, $handler)
    {
        self::addRoute('PUT', $path, $handler);
    }

    /**
     * Register a route for DELETE requests
     * 
     * @param string $path The URI path pattern to match
     * @param mixed $handler The handler function or controller method to execute
     * @return void
     */
    public static function delete(string $path, $handler)
    {
        self::addRoute('DELETE', $path, $handler);
    }

    /**
     * Helper method to add a route to the routes collection
     * 
     * @param string $method The HTTP method (GET, POST, PUT, DELETE)
     * @param string $path The URI path pattern to match
     * @param mixed $handler The handler function or controller method to execute
     * @return void
     */
    private static function addRoute(string $method, string $path, $handler)
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }

    /**
     * Match the current request against registered routes and dispatch to the appropriate handler
     * 
     * This method:
     * 1. Gets the current request method and URI
     * 2. Iterates through registered routes to find a match
     * 3. Extracts dynamic parameters from the URI
     * 4. Executes the corresponding handler with the extracted parameters
     * 5. Shows a 404 page if no matching route is found
     * 
     * @return mixed The result of the executed handler
     * @throws Exception If the route handler is invalid
     */
    public static function dispatch()
    {
            $requestMethod = Request::method();
            $requestUri = Request::uri();

            foreach (self::$routes as $route) {
                // Create a regex pattern to match route parameters like {id}
                $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?<$1>[^/]+)', $route['path']) . '$#';

                if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {

                // Extract named parameters from the URI
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                        if (is_callable($route['handler'])) {
                    // Execute callable handlers directly
                    return call_user_func_array($route['handler'], $params);
                } elseif (is_array($route['handler'])) {
                            // Handle controller class methods [ControllerClass, methodName]
                            [$controller, $method] = $route['handler'];
                    if (method_exists($controller, $method)) {
                        return call_user_func_array([new $controller, $method], $params);
                    }
                        }

                throw new Exception('Invalid route handler');
            }
        }

        // No matching route found, show 404 page
        require_once __DIR__ . '/../views/pages/404.php';
    }
}