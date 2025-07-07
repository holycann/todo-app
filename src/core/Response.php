<?php
/**
 * Response Class
 * 
 * This utility class provides methods for generating HTTP responses to clients.
 * It handles response formatting, status codes, and header management to ensure
 * consistent API responses throughout the application.
 * 
 * The class is designed using the static facade pattern to provide a simple
 * API for controllers to return responses without managing response objects.
 */

class Response
{
    /**
     * Sends a JSON response to the client
     * 
     * This method sets the appropriate Content-Type header, HTTP status code,
     * and encodes the provided data as JSON before sending it to the client.
     * 
     * @param mixed $data The data to be encoded as JSON
     * @param int $status The HTTP status code to send (default: 200 OK)
     * @return void
     */
    public static function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }
}