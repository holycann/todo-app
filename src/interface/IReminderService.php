<?php
/**
 * Reminder Service Interface
 * 
 * This interface defines the contract for reminder service implementations.
 * It specifies all methods that must be implemented to provide reminder management functionality,
 * including CRUD operations, filtering, and status management for reminders associated with tasks.
 */

require_once __DIR__ . '/../models/ReminderModel.php';

interface IReminderService
{
    /**
     * Creates a new reminder
     * 
     * @param array $data Reminder data including title, message, task_id (optional), and reminder_time
     * @return ReminderModel The newly created reminder
     */
    public function createReminder(array $data): ReminderModel;
    
    /**
     * Retrieves a specific reminder by ID
     * 
     * @param int $id The ID of the reminder to retrieve
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function getReminder(int $id): ?ReminderModel;
    
    /**
     * Retrieves a reminder by its associated task ID
     * 
     * @param int $task_id The ID of the task
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function getByTaskId(int $task_id): ?ReminderModel;
    
    /**
     * Retrieves all reminders
     * 
     * @return array Array of all reminders
     */
    public function getAllReminders(): array;
    
    /**
     * Retrieves all unread reminders
     * 
     * @return array Array of all unread reminders
     */
    public function getAllUnreadReminders(): array;
    
    /**
     * Retrieves all sent reminders
     * 
     * @return array Array of all reminders that have been sent
     */
    public function getAllSendedReminders(): array;
    
    /**
     * Retrieves all scheduled reminders that haven't been sent yet
     * 
     * @return array Array of all reminders in scheduled status
     */
    public function getAllScheduledReminder(): array;
    
    /**
     * Updates an existing reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param array $data Updated reminder data
     * @return ReminderModel The updated reminder
     */
    public function updateReminder(int $id, array $data): ReminderModel;
    
    /**
     * Updates the read status of a reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param bool $is_read The new read status
     * @return bool True if update was successful, false otherwise
     */
    public function updateReadReminder(int $id, bool $is_read): bool;
    
    /**
     * Deletes a reminder
     * 
     * @param int $id The ID of the reminder to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function deleteReminder(int $id): bool;
    
    /**
     * Updates the status of a reminder to 'sent'
     * 
     * @param int $id The ID of the reminder to update
     * @param string $status The new status ('scheduled' or 'sent')
     * @return bool True if update was successful, false otherwise
     */
    public function changeStatusReminder(int $id, string $status): bool;
    
    /**
     * Updates the scheduled time of a reminder associated with a task
     * 
     * @param int $task_id The ID of the associated task
     * @param string $reminder_time The new reminder time
     * @param string $status The new status for the reminder
     * @return bool True if update was successful, false otherwise
     */
    public function changeTimeReminder(int $task_id, string $reminder_time, string $status): bool;
}