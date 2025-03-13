<?php

require_once __DIR__ . '/../interface/IUserService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService implements IUserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }


    public function registerUser(UserModel $user): int
    {
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        if ($this->userRepository->findByEmail($user->email)) {
            throw new Error('Email already registered');
        }

        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        return $this->userRepository->create($user);
    }

    public function getUserById(int $id): ?UserModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid user ID');
        }
        return $this->userRepository->findById($id);
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
        return $this->userRepository->findByEmail($email);
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}