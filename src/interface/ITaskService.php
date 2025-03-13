<?php

interface ITaskService
{
    public function createTask(array $data): TaskModel;
    public function getTask(int $id): ?TaskModel;
    public function getAllTasks(): array;
    public function getTasksToday(): array;
    public function getTasksByDate(string $date): array;
    public function getTasksByMonth(string $month): array;
    public function getFilteredTasks(array $filters): array;
    public function updateTask(int $id, array $data): TaskModel;
    public function deleteTask(int $id): bool;
    public function changeStatusTask(int $id, string $status): bool;
}