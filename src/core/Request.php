<?php

require_once __DIR__ . '/../../config/AppConfig.php';

class Request
{
    public static function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $baseEndpoint = BASE_ENDPOINT;
        if (strpos($uri, $baseEndpoint) === 0) {
            $uri = substr($uri, strlen($baseEndpoint));
        }
        return $uri;
    }

    public static function get(string $key, $default = null)
    {
        return self::sanitize($_GET[$key] ?? $default);
    }

    public static function post(string $key, $default = null)
    {
        return self::sanitize($_POST[$key] ?? $default);
    }

    public static function put(string $key, $default = null)
    {
        parse_str(file_get_contents('php://input'), $putData);
        return self::sanitize($putData[$key] ?? $default);
    }

    public static function delete(string $key, $default = null)
    {
        parse_str(file_get_contents('php://input'), $deleteData);
        return self::sanitize($deleteData[$key] ?? $default);
    }

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


    private static function sanitize($value)
    {
        if (is_array($value)) {
            return array_map([self::class, 'sanitize'], $value);
        }

        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}