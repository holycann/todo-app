<?php

session_start();

class AuthController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login()
    {
        $data = Request::all();

        if (!isset($data['email'], $data['password'])) {
            Response::json(['error' => 'Email and Password Is Required!'], 400);
            return;
        }

        $user = $this->userService->getUserByEmail($data['email']);

        if (!$user || !password_verify($data['password'], $user->password)) {
            Response::json(['error' => 'Email Or Password Invalid'], 400);
            return;
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['fullname'] = $user->fullname;
        $_SESSION['email'] = $user->email;

        if (isset($data['remember'])) {
            setcookie("user_token", base64_encode($user->id), time() + (7 * 24 * 60 * 60), "/");
        }

        Response::json(['message' => 'Login successful']);
        exit;
    }

    public function logout()
    {
        try {
            $_SESSION = [];
            session_destroy();

            setcookie("user_token", "", time() - 3600, "/");

            Response::json(['message' => 'Logout successfully']);
            exit;

        } catch (\Throwable $th) {
            Response::json(['error' => 'Something Error: ' . $th->getMessage()]);
            exit;
        }
    }

}

?>