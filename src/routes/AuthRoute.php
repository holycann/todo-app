<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/AuthController.php';

Router::post('/login', [AuthController::class, 'login']);
Router::post('/logout', [AuthController::class, 'logout']);

?>