<?php
/**
 * User Controller
 * 
 * This controller handles all HTTP requests related to user management,
 * including listing users, retrieving user details, and user registration.
 * It serves as a bridge between client requests and the user service layer.
 * 
 * Routes to this controller are defined in the main router configuration.
 */

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class UserController
{
    private UserService $userService;
    private AuthMiddleware $authMiddleware;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userService = new UserService();
        $this->authMiddleware = new AuthMiddleware();
    }

    /**
     * Lists all users
     * 
     * Endpoint: GET /users
     * Returns a JSON array containing all users in the system
     * 
     * @return void
     */
    public function index()
    {
        $this->authMiddleware->requireAuth();
        $users = $this->userService->getAllUsers();
        Response::json($users);
    }

    /**
     * Retrieves a specific user by ID
     * 
     * Endpoint: GET /users/{id}
     * 
     * @param int $id The ID of the user to retrieve
     * @return void
     */
    public function show(int $id)
    {
        $this->authMiddleware->requireAuth();
        $user = $this->userService->getUserById($id);
        if ($user) {
            Response::json($user);
        } else {
            Response::json(['error' => 'User not found'], 404);
        }
    }

    /**
     * Handles user registration
     * 
     * Endpoint: POST /register
     * Expected request body: {"fullname": "User Name", "email": "user@example.com", "password": "password"}
     * 
     * Validates required fields and creates a new user account.
     * Returns a 201 Created response on success or an error message.
     * 
     * @return void
     */
    public function register()
    {
        $this->authMiddleware->redirectIfAuthenticated();
        
        $data = Request::all();

        $required = ['fullname', 'email', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                Response::json(['error' => "$field is required"], 400);
                return;
            }
        }

        try {
            $user = new UserModel(null, $data['fullname'], $data['email'], $data['password'], null);
            $userId = $this->userService->registerUser($user);
            Response::json(['message' => 'Create User Successfully'], 201);
        } catch (Exception $e) {
            Response::json(['error' => $e->getMessage()], 400);
        }
    }
}