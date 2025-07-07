<?php
/**
 * Authentication Controller
 * 
 * This controller handles user authentication operations including login and logout.
 * It manages user sessions and optional "remember me" functionality through cookies.
 * 
 * Routes to this controller are defined in src/routes/AuthRoute.php
 */

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class AuthController
{
    /**
     * UserService instance for user-related operations
     * @var UserService
     */
    private UserService $userService;

    /**
     * AuthMiddleware instance for authentication checks
     * @var AuthMiddleware
     */
    private AuthMiddleware $authMiddleware;

    /**
     * Constructor - initializes the UserService and AuthMiddleware
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userService = new UserService();
        $this->authMiddleware = new AuthMiddleware();
    }

    /**
     * Handles user login
     * 
     * Endpoint: POST /auth/login
     * 
     * Validates credentials, creates a session, and optionally sets a remember-me cookie.
     * Expected request body: {"email": "user@example.com", "password": "password", "remember": true|false}
     * 
     * @return void Sends JSON response with success message or error
     */
    public function login()
    {
        $this->authMiddleware->redirectIfAuthenticated();
        
        $data = Request::all();

        // Validate required fields
        if (!isset($data['email'], $data['password'])) {
            Response::json(['error' => 'Email and Password Is Required!'], 400);
            return;
        }

        // Attempt to retrieve the user by email and verify password
        $user = $this->userService->getUserByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user->password)) {
            Response::json(['error' => 'Email Or Password Invalid'], 400);
            return;
        }

        // Create user session
        $_SESSION['user_id'] = $user->id;
        $_SESSION['fullname'] = $user->fullname;
        $_SESSION['email'] = $user->email;

        // Set remember-me cookie if requested (valid for 7 days)
        if (isset($data['remember'])) {
            setcookie("user_token", base64_encode($user->id), time() + (7 * 24 * 60 * 60), "/");
        }

        Response::json(['message' => 'Login successful']);
        exit;
    }

    /**
     * Handles user logout
     * 
     * Endpoint: POST /auth/logout
     * 
     * Destroys the current session and removes any authentication cookies.
     * 
     * @return void Sends JSON response with success message or error
     */
    public function logout()
    {
        $this->authMiddleware->requireAuth();
        
        try {
            // Clear session data
            $_SESSION = [];
            session_destroy();

            // Remove the remember-me cookie
            setcookie("user_token", "", time() - 3600, "/");

            Response::json(['message' => 'Logout successfully']);
            exit;

        } catch (\Throwable $th) {
            // Handle any unexpected errors during logout
            Response::json(['error' => 'Something Error: ' . $th->getMessage()]);
            exit;
        }
    }

}

?>