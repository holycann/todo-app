<?php

require_once __DIR__ . '/../services/TaskService.php';

class TaskController
{
    private $taskService;

    public function __construct()
    {
        $this->taskService = new TaskService();
    }

    public function index()
    {
        $tasks = $this->taskService->getAllTasks();
        Response::json($tasks);
    }

    public function show(int $id)
    {
        $task = $this->taskService->getTask($id);
        if ($task) {
            Response::json($task);
        } else {
            http_response_code(404);
            Response::json(['message' => 'Task not found']);
        }
    }

    public function store()
    {
        $data = Request::all();
        $this->taskService->createTask($data);
        http_response_code(201);
        Response::json(['message' => 'Task created successfully']);
    }
    
    public function update(int $id)
    {
        $data = Request::all();
        $this->taskService->updateTask($id, $data);
        Response::json(['message' => 'Task updated successfully']);
    }
    
    public function changeStatusTask(int $id)
    {
        $data = Request::all();
        
        if (!isset($data['status'])) {
            http_response_code(400);
            Response::json(['message' => 'Status is required']);
            return;
        }

        $this->taskService->changeStatusTask($id, $data['status']);
        Response::json(['message' => 'Task status updated successfully']);
    }

    public function destroy(int $id)
    {
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