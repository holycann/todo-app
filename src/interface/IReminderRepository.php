<?php

interface IReminderRepository
{
    public function create(ReminderModel $data): int;
    public function findById(int $id): ?ReminderModel;
    public function findByTaskId(int $task_id): ?ReminderModel;
    public function findAll(): array;
    public function findAllUnread(): array;
    public function findAllSended(): array;
    public function findAllScheduled(): array;
    public function update(int $id, array $data): bool;
    public function updateStatus(int $id, string $status): bool;
    public function updateSended(int $id): bool;
    public function updateRead(int $id, bool $is_read): bool;
    public function updateTime(int $task_id, string $reminder_time, string $status): bool;
    public function delete(int $id): bool;
}