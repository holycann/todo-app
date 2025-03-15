<?php
/**
 * Task Controller
 * 
 * This controller handles all HTTP requests related to task management,
 * including listing, creating, updating, and deleting tasks. It acts as
 * an interface between the client requests and the TaskService which
 * contains the business logic.
 * 
 * Routes to this controller are defined in src/routes/TaskRoute.php
 */

require_once __DIR__ . '/../services/TaskService.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class TaskController
{
    /**
     * TaskService instance for handling business logic
     * @var TaskService
     */
    private TaskService $taskService;

    /**
     * AuthMiddleware instance for handling authentication
     * @var AuthMiddleware
     */
    private AuthMiddleware $authMiddleware;

    /**
     * Constructor - initializes the TaskService and AuthMiddleware
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->taskService = new TaskService();
        $this->authMiddleware = new AuthMiddleware();
    }

    /**
     * Lists all tasks
     * 
     * Endpoint: GET /tasks
     * Returns a JSON array of all tasks
     * 
     * @return void
     */
    public function index(): void
    {
        $this->authMiddleware->requireAuth();
        $tasks = $this->taskService->getAllTasks();
        Response::json($tasks);
    }

    /**
     * Retrieves a specific task by ID
     * 
     * Endpoint: GET /tasks/{id}
     * 
     * @param int $id The ID of the task to retrieve
     * @return void
     */
    public function show(int $id): void
    {
        $this->authMiddleware->requireAuth();
        $task = $this->taskService->getTask($id);
        if ($task) {
            Response::json($task);
        } else {
            http_response_code(404);
            Response::json(['message' => 'Task not found']);
        }
    }

    /**
     * Creates a new task
     * 
     * Endpoint: POST /tasks
     * Expects a JSON payload with task data in the request body
     * 
     * @return void
     */
    public function store(): void
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();
        $this->taskService->createTask($data);
        http_response_code(201);
        Response::json(['message' => 'Task created successfully']);
    }
    
    /**
     * Updates an existing task
     * 
     * Endpoint: PUT /tasks/{id}
     * Expects a JSON payload with task data in the request body
     * 
     * @param int $id The ID of the task to update
     * @return void
     */
    public function update(int $id): void
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();
        $this->taskService->updateTask($id, $data);
        Response::json(['message' => 'Task updated successfully']);
    }
    
    /**
     * Updates the status of a task
     * 
     * Endpoint: PATCH /tasks/{id}/status
     * Expects a JSON payload with the 'status' field in the request body
     * 
     * @param int $id The ID of the task to update
     * @return void
     */
    public function changeStatusTask(int $id): void
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();
        
        if (!isset($data['status'])) {
            http_response_code(400);
            Response::json(['message' => 'Status is required']);
            return;
        }

        $this->taskService->changeStatusTask($id, $data['status']);
        Response::json(['message' => 'Task status updated successfully']);
    }

    /**
     * Deletes a task
     * 
     * Endpoint: DELETE /tasks/{id}
     * 
     * @param int $id The ID of the task to delete
     * @return void
     */
    public function destroy(int $id): void
    {
        $this->authMiddleware->requireAuth();
        $success = $this->taskService->deleteTask($id);
        if ($success) {
            http_response_code(204);
            Response::json(['message' => 'Task deleted successfully']);
        } else {
            http_response_code(404);
            Response::json(['message' => 'Task not found']);
        }
    }
}