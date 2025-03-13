<?php

interface IUserRepository
{
    public function create(UserModel $user): int;
    public function findById(int $id): ?UserModel;
    public function findByEmail(string $email): ?UserModel;
    public function findAll(): array;
    public function update(UserModel $user): bool;
    public function delete(int $id): bool;
}