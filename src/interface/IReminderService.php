<?php

interface IReminderService
{
    public function createReminder(array $data): ReminderModel;
    public function getReminder(int $id): ?ReminderModel;
    public function getByTaskId(int $task_id): ?ReminderModel;
    public function getAllReminders(): array;
    public function getAllUnreadReminders(): array;
    public function getAllSendedReminders(): array;
    public function getAllScheduledReminder(): array;
    public function updateReminder(int $id, array $data): ReminderModel;
    public function updateReadReminder(int $id, bool $is_read): bool;
    public function deleteReminder(int $id): bool;
    public function changeStatusReminder(int $id, string $status): bool;
    public function changeTimeReminder(int $task_id, string $reminder_time, string $status): bool;
}