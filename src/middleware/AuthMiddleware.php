<?php
/**
 * Authentication Middleware
 * 
 * This middleware handles authentication checks across the application.
 * It provides methods to verify user authentication status and manage redirects.
 */

require_once __DIR__ . '/../services/UserService.php';

class AuthMiddleware {
    private UserService $userService;

    public function __construct() {
        $this->userService = new UserService();
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Checks if user is authenticated and redirects to login if not
     * @return void
     */
    public function requireAuth(): void {
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_token'])) {
            header("Location: " . BASE_ENDPOINT . "/login");
            exit;
        }

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : base64_decode($_COOKIE['user_token']);
        $user = $this->userService->getUserById((int) $user_id);

        if (!$user) {
            session_unset();
            session_destroy();
            setcookie("user_token", "", time() - 3600, "/");
            header("Location: " . BASE_ENDPOINT . "/login");
            exit;
        }

        if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_token'])) {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['fullname'] = $user->fullname;
            $_SESSION['email'] = $user->email;
        }
    }

    /**
     * Checks if user is already authenticated and redirects to home if true
     * @return void
     */
    public function redirectIfAuthenticated(): void {
        if (isset($_SESSION['user_id']) || isset($_COOKIE['user_token'])) {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : base64_decode($_COOKIE['user_token']);
            $user = $this->userService->getUserById((int) $user_id);

            if ($user) {
                if (!isset($_SESSION['user_id'])) {
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['fullname'] = $user->fullname;
                    $_SESSION['email'] = $user->email;
                }
                header("Location: " . BASE_ENDPOINT . "/");
                exit;
            } else {
                session_unset();
                session_destroy();
                setcookie("user_token", "", time() - 3600, "/");
            }
        }
    }
}
