<?php

interface ITaskRepository
{
    public function create(TaskModel $data): int;
    public function findById(int $id): ?TaskModel;
    public function findAll(): array;
    public function findTaskSameCategory(string $title, string $category): bool;
    public function findFilteredTask(array $filters = []): array;
    public function findByDate(string $date): array;
    public function findByMonth(string $month): array;
    public function update(int $id, array $data): bool;
    public function updateStatus(int $id, string $status): bool;
    public function delete(int $id): bool;
}