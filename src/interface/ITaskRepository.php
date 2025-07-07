<?php

/**
 * Interface ITaskRepository
 * 
 * This interface defines the contract for task data access operations.
 * Any class implementing this interface must provide concrete implementations
 * for all these methods to ensure consistent task data management.
 */
interface ITaskRepository
{
    /**
     * Creates a new task in the storage system
     * 
     * @param TaskModel $data The task data to be stored
     * @return int The ID of the newly created task
     */
    public function create(TaskModel $data): int;
    
    /**
     * Retrieves a task by its ID
     * 
     * @param int $id The ID of the task to retrieve
     * @return TaskModel|null The task if found, null otherwise
     */
    public function findById(int $id): ?TaskModel;
    
    /**
     * Retrieves all tasks from the storage system
     * 
     * @return array Array of all tasks
     */
    public function findAll(): array;
    
    /**
     * Checks if a task with the same title already exists in the specified category
     * 
     * @param string $title The task title to check
     * @param string $category The category to check within
     * @return bool True if a task with the same title exists in the category, false otherwise
     */
    public function findTaskSameCategory(string $title, string $category): bool;
    
    /**
     * Retrieves tasks based on specified filters
     * 
     * @param array $filters Associative array of filters to apply
     * @return array Array of filtered tasks
     */
    public function findFilteredTask(array $filters = []): array;
    
    /**
     * Retrieves tasks due on a specific date
     * 
     * @param string $date The date to filter tasks by (format: Y-m-d)
     * @return array Array of tasks due on the specified date
     */
    public function findByDate(string $date): array;
    
    /**
     * Retrieves tasks due in a specific month
     * 
     * @param string $month The month number (1-12) to filter tasks by
     * @return array Array of tasks due in the specified month
     */
    public function findByMonth(string $month): array;
    
    /**
     * Updates an existing task
     * 
     * @param int $id The ID of the task to update
     * @param array $data The new task data
     * @return bool True if update was successful, false otherwise
     */
    public function update(int $id, array $data): bool;
    
    /**
     * Updates only the status of a task
     * 
     * @param int $id The ID of the task to update
     * @param string $status The new status value
     * @return bool True if the status update was successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool;
    
    /**
     * Deletes a task from the storage system
     * 
     * @param int $id The ID of the task to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function delete(int $id): bool;
}