<?php
/**
 * Task Service Interface
 * 
 * This interface defines the contract for task service implementations.
 * It specifies all methods that must be implemented to provide task management functionality,
 * including CRUD operations, filtering, and status management.
 */

require_once __DIR__ . '/../models/TaskModel.php';

interface ITaskService
{
    /**
     * Creates a new task
     * 
     * @param array $data Task data including title, description, due_date, and category
     * @return TaskModel The newly created task
     */
    public function createTask(array $data): TaskModel;
    
    /**
     * Retrieves a specific task by ID
     * 
     * @param int $id The ID of the task to retrieve
     * @return TaskModel|null The task if found, null otherwise
     */
    public function getTask(int $id): ?TaskModel;
    
    /**
     * Retrieves all tasks
     * 
     * @return array Array of all tasks
     */
    public function getAllTasks(): array;
    
    /**
     * Retrieves tasks due today
     * 
     * @return array Array of tasks due today
     */
    public function getTasksToday(): array;
    
    /**
     * Retrieves tasks due on a specific date
     * 
     * @param string $date Date in Y-m-d format
     * @return array Array of tasks due on the specified date
     */
    public function getTasksByDate(string $date): array;
    
    /**
     * Retrieves tasks due in a specific month
     * 
     * @param string $month Month number (1-12)
     * @return array Array of tasks due in the specified month
     */
    public function getTasksByMonth(string $month): array;
    
    /**
     * Retrieves tasks filtered by various criteria
     * 
     * @param array $filters Associative array of filter criteria (status, priority, category)
     * @return array Array of filtered tasks
     */
    public function getFilteredTasks(array $filters): array;
    
    /**
     * Updates an existing task
     * 
     * @param int $id The ID of the task to update
     * @param array $data Updated task data
     * @return TaskModel The updated task
     */
    public function updateTask(int $id, array $data): TaskModel;
    
    /**
     * Deletes a task
     * 
     * @param int $id The ID of the task to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function deleteTask(int $id): bool;
    
    /**
     * Updates the status of a task
     * 
     * @param int $id The ID of the task to update
     * @param string $status The new status ('on-going', 'pending', or 'completed')
     * @return bool True if update was successful, false otherwise
     */
    public function changeStatusTask(int $id, string $status): bool;
}