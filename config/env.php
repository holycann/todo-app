<?php

return [
    'app_name' => 'Todo App',
    'base_url' => 'http://' . $_SERVER['HTTP_HOST'],
    'base_endpoint' => dirname($_SERVER['SCRIPT_NAME']),
    'db' => [
        'host' => 'localhost',
        'dbname' => 'todo_app_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];

?>