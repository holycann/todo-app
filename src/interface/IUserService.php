<?php

interface IUserService
{
    public function registerUser(UserModel $user): int;
    public function getUserById(int $id): ?UserModel;
    public function getUserByEmail(string $email): ?UserModel;
    public function getAllUsers(): array;
}