<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/UserController.php';

$userController = new UserController();

Router::get('/users', [$userController, 'index']);
Router::post('/users', [$userController, 'register']);
Router::get('/users/{id}', function ($id) use ($userController) {
    if ($id) {
        return $userController->show((int) $id);
    } else {
        return Response::json(['error' => 'User ID is required'], 400);
    }
});


?>