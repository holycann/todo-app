<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        Response::json($users);
    }

    public function show(int $id)
    {
        $user = $this->userService->getUserById($id);
        if ($user) {
            Response::json($user);
        } else {
            Response::json(['error' => 'User not found'], 404);
        }
    }

    public function register()
    {
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