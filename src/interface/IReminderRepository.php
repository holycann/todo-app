<?php
/**
 * Reminder Repository Interface
 * 
 * This interface defines the contract for reminder repository implementations.
 * It specifies all methods that must be implemented to provide data access
 * functionality for reminder entities, including CRUD operations and specialized
 * queries for reminders in the database.
 * 
 * Repositories implementing this interface will handle all database operations
 * for reminder management, isolating the database interaction from the business logic.
 */

require_once __DIR__ . '/../models/ReminderModel.php';

interface IReminderRepository
{
    /**
     * Creates a new reminder in the database
     * 
     * @param ReminderModel $data The reminder model with data to insert
     * @return int The ID of the newly created reminder
     */
    public function create(ReminderModel $data): int;
    
    /**
     * Retrieves a reminder by its ID
     * 
     * @param int $id The ID of the reminder to retrieve
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function findById(int $id): ?ReminderModel;
    
    /**
     * Retrieves a reminder by the associated task ID
     * 
     * @param int $task_id The ID of the related task
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function findByTaskId(int $task_id): ?ReminderModel;
    
    /**
     * Retrieves all reminders from the database
     * 
     * @return array Array of all reminders
     */
    public function findAll(): array;
    
    /**
     * Retrieves all unread reminders
     * 
     * @return array Array of all unread reminders
     */
    public function findAllUnread(): array;
    
    /**
     * Retrieves all reminders that have been sent
     * 
     * @return array Array of all sent reminders
     */
    public function findAllSended(): array;
    
    /**
     * Retrieves all scheduled reminders that are due
     * 
     * @return array Array of all scheduled reminders due for sending
     */
    public function findAllScheduled(): array;
    
    /**
     * Updates a reminder with the given ID
     * 
     * @param int $id The ID of the reminder to update
     * @param array $data Associative array of fields to update
     * @return bool True if the update was successful, false otherwise
     */
    public function update(int $id, array $data): bool;
    
    /**
     * Updates only the status of a reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param string $status The new status value
     * @return bool True if the update was successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool;
    
    /**
     * Marks a reminder as sent and records the sent time
     * 
     * @param int $id The ID of the reminder to mark as sent
     * @return bool True if the update was successful, false otherwise
     */
    public function updateSended(int $id): bool;
    
    /**
     * Updates the read status of a reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param bool $is_read The new read status
     * @return bool True if the update was successful, false otherwise
     */
    public function updateRead(int $id, bool $is_read): bool;
    
    /**
     * Updates the scheduled time and status of a reminder
     * 
     * @param int $task_id The ID of the related task
     * @param string $reminder_time The new scheduled time
     * @param string $status The new status
     * @return bool True if the update was successful, false otherwise
     */
    public function updateTime(int $task_id, string $reminder_time, string $status): bool;
    
    /**
     * Deletes a reminder from the database
     * 
     * @param int $id The ID of the reminder to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function delete(int $id): bool;
}