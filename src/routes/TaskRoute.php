<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/TaskController.php';

$taskController = new TaskController();

Router::get('/tasks', [$taskController, 'index']);
Router::post('/tasks', [$taskController, 'store']);
Router::put('/tasks/{id}/status', [$taskController, 'changeStatusTask']);
Router::put('/tasks/{id}', [$taskController, 'update']);
Router::delete('/tasks/{id}', [$taskController, 'destroy']);
Router::get('/tasks/{id}', [$taskController, 'show']);
?>