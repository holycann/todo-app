<?php

require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../core/Response.php';

class Router
{
    private static $routes = [];
    private static $middlewares = [];

    public static function get(string $path, $handler)
    {
        self::addRoute('GET', $path, $handler);
    }

    public static function post(string $path, $handler)
    {
        self::addRoute('POST', $path, $handler);
    }

    public static function put(string $path, $handler)
    {
        self::addRoute('PUT', $path, $handler);
    }

    public static function delete(string $path, $handler)
    {
        self::addRoute('DELETE', $path, $handler);
    }

    public static function middleware($middleware)
    {
        self::$middlewares[] = $middleware;
    }

    private static function addRoute(string $method, string $path, $handler)
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middlewares' => self::$middlewares
        ];
        self::$middlewares = [];
    }

    public static function dispatch()
    {
            $requestMethod = Request::method();
            $requestUri = Request::uri();

            foreach (self::$routes as $route) {
                $pattern = '#^' . preg_replace('/\{(\w+)\}/', '(?<$1>[^/]+)', $route['path']) . '$#';

                if ($route['method'] === $requestMethod && preg_match($pattern, $requestUri, $matches)) {
                        // Apply middlewares
                        foreach ($route['middlewares'] as $middleware) {
                            if (is_array($middleware)) {
                                [$class, $method] = $middleware;
                        if (class_exists($class) && method_exists($class, $method)) {
                            call_user_func([$class, $method]);
                        }
                            } elseif (is_callable($middleware)) {
                        call_user_func($middleware);
                            }
                        }

                        // Handle the request
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                        if (is_callable($route['handler'])) {
                    return call_user_func_array($route['handler'], $params);
                } elseif (is_array($route['handler'])) {
                            [$controller, $method] = $route['handler'];
                    if (method_exists($controller, $method)) {
                        return call_user_func_array([new $controller, $method], $params);
                    }
                        }

                throw new Exception('Invalid route handler');
            }
        }

        require_once __DIR__ . '/../views/pages/404.php';
    }
}