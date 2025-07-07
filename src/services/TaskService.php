<?php
/**
 * Task Service
 * 
 * This service implements the ITaskService interface and contains all the business logic
 * for task management, including creation, retrieval, update, and deletion operations.
 * It also handles task validation, filtering, and sorting, as well as reminder integration.
 * 
 * The service acts as an intermediary between controllers and repositories,
 * enforcing business rules and data integrity.
 */

declare(strict_types=1);

require_once __DIR__ . '/../interface/ITaskService.php';
require_once __DIR__ . '/../repositories/TaskRepository.php';
require_once __DIR__ . '/../services/ReminderService.php';
require_once __DIR__ . '/../interface/IReminderService.php';
require_once __DIR__ . '/../models/ReminderModel.php';
require_once __DIR__ . '/../models/TaskModel.php';

class TaskService implements ITaskService
{
    /**
     * Repository for task data access operations
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;
    
    /**
     * Service for managing reminders related to tasks
     * @var ReminderService
     */
    private ReminderService $reminderService;

    /**
     * Constructor - initializes repositories and services
     *
     * @param TaskRepository|null $taskRepository Optional task repository instance
     * @param ReminderService|null $reminderService Optional reminder service instance
     */
    public function __construct(?TaskRepository $taskRepository = null, ?ReminderService $reminderService = null)
    {
        $this->taskRepository = $taskRepository ?? new TaskRepository();
        $this->reminderService = $reminderService ?? new ReminderService();
    }

    /**
     * Creates a new task with optional reminder
     *
     * This method validates task data, creates a task in the database,
     * and sets up a reminder if a reminder time is provided.
     *
     * @param array $data Task data including title, description, due_date, category, and optional reminder_time
     * @return TaskModel The newly created task
     * @throws InvalidArgumentException If validation fails
     */
    public function createTask(array $data): TaskModel
    {
        // Extract reminder_time before validation since it's not part of the task model
        $reminder_time = $data['reminder_time'] ?? null;
        unset($data['reminder_time']);

        // Set user_id from session
        $data['user_id'] = $_SESSION['user_id'];

        // Validate task data
        $this->validateTaskData($data);

        // Create task model
        $taskData = new TaskModel(
            null,
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['due_date'],
            $data['category'],
            $data['priority'] ?? null,
            $data['status'] ?? null,
            null,
            null
        );

        // Save task to database and get the ID
        $taskId = $this->taskRepository->create($taskData);

        // Retrieve the complete task with auto-generated fields
        $task = $this->getTask($taskId);

        // Create a reminder if reminder_time was provided
        if ($reminder_time) {
            $reminderData = [
                'title' => 'Reminder For: ' . $task->title,
                'message' => 'Due Date for ' . $task->title . ' is ' . date('d F h:i A', strtotime($task->due_date)) . '. Make sure all requirements are met before the deadline.',
                'task_id' => $task->id,
                'reminder_time' => $reminder_time,
                'status' => 'scheduled',
            ];

            $this->reminderService->createReminder($reminderData);
        }

        return $task;
    }

    /**
     * Retrieves a task by its ID
     *
     * @param int $id The ID of the task to retrieve
     * @return TaskModel|null The task if found, null otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function getTask(int $id): ?TaskModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->taskRepository->findById($id);
    }

    /**
     * Retrieves all tasks from the database
     *
     * @return array Array of all tasks
     */
    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    /**
     * Updates an existing task with new data
     *
     * This method validates the updated data, updates the task in the database,
     * and updates the associated reminder if the reminder time has changed.
     *
     * @param int $id The ID of the task to update
     * @param array $data Updated task data
     * @return TaskModel The updated task
     * @throws InvalidArgumentException If validation fails
     */
    public function updateTask(int $id, array $data): TaskModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }

        // Extract reminder_time before validation
        $reminder_time = $data['reminder_time'] ?? null;
        unset($data['reminder_time']);

        // Set user_id from session
        $data['user_id'] = $_SESSION['user_id'];

        // Validate task data (with isUpdate flag to apply appropriate validation rules)
        $this->validateTaskData($data, true);
        
        // Update the task
        $this->taskRepository->update($id, $data);
        
        // Get the updated task
        $task = $this->getTask($id);

        // Handle reminder update if reminder_time is provided
        if ($reminder_time) {
            $oldReminder = $this->reminderService->getByTaskId($id) ? $this->reminderService->getByTaskId($id)->toArray() : [];

            if ($oldReminder) {
                // Update reminder time if it has changed
                if ($oldReminder['reminder_time'] != $reminder_time) {
                    $status = 'scheduled';
                    $this->reminderService->changeTimeReminder($id, $reminder_time, $status);
                }
            }
        }

        return $task;
    }

    /**
     * Deletes a task by its ID
     *
     * @param int $id The ID of the task to delete
     * @return bool True if deletion was successful, false otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function deleteTask(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->taskRepository->delete($id);
    }

    /**
     * Retrieves tasks due today
     *
     * @return array Array of tasks due today
     */
    public function getTasksToday(): array
    {
        $date = new DateTime();
        $formattedDate = $date->format('Y-m-d');
        return $this->taskRepository->findByDate($formattedDate);
    }

    /**
     * Retrieves tasks due on a specific date
     *
     * @param string $date Date in Y-m-d format
     * @return array Array of tasks due on the specified date
     */
    public function getTasksByDate(string $date): array
    {
        return $this->taskRepository->findByDate($date);
    }

    /**
     * Retrieves tasks due in a specific month
     *
     * @param string $month Month number (1-12)
     * @return array Array of tasks due in the specified month of the current year
     */
    public function getTasksByMonth(string $month): array
    {
        return $this->taskRepository->findByMonth($month);
    }

    /**
     * Retrieves tasks filtered by various criteria
     *
     * @param array $filters Associative array of filter criteria (status, priority, category)
     * @return array Array of filtered tasks
     * @throws InvalidArgumentException If filter values are invalid
     */
    public function getFilteredTasks(array $filters): array
    {
        // Define valid values for validation
        $validStatuses = ['on-going', 'pending', 'completed'];
        $validPriorities = ['low', 'medium', 'high'];

        // Validate status if provided
        if (!empty($filters['status']) && !in_array($filters['status'], $validStatuses)) {
            throw new InvalidArgumentException('Invalid task status');
        }

        // Validate priority if provided
        if (!empty($filters['priority']) && !in_array($filters['priority'], $validPriorities)) {
            throw new InvalidArgumentException('Invalid task priority');
        }

        // Validate category if provided
        if (!empty($filters['category']) && empty(trim($filters['category']))) {
            throw new InvalidArgumentException('Category cannot be empty');
        }

        return $this->taskRepository->findFilteredTask($filters);
    }

    /**
     * Retrieves tasks sorted by a specific column and direction
     *
     * @param string $order Sort direction ('asc' or 'desc')
     * @param string $type Column to sort by ('category', 'priority', or 'status')
     * @return array Array of sorted tasks
     */
    public function getSortedTask(string $order, string $type): array
    {
        // Define valid values for validation
        $validTypes = ['category', 'priority', 'status'];
        $validOrders = ['asc', 'desc'];

        // Fallback to 'id' if type is invalid
        $orderBy = in_array($type, $validTypes) ? $type : 'id';

        // Fallback to 'ASC' if order is invalid
        $orderDir = in_array(strtolower($order), $validOrders) ? strtoupper($order) : 'ASC';

        return $this->taskRepository->findSortedTask($orderBy, $orderDir);
    }

    /**
     * Updates the status of a task
     *
     * @param int $id The ID of the task to update
     * @param string $status The new status ('on-going', 'pending', or 'completed')
     * @return bool True if update was successful, false otherwise
     */
    public function changeStatusTask(int $id, string $status): bool
    {
        return $this->taskRepository->updateStatus($id, $status);
    }

    /**
     * Validates task data before creation or update
     *
     * @param array &$data Task data to validate (passed by reference to apply defaults)
     * @param bool $isUpdate Whether this is an update operation (affects validation rules)
     * @return void
     * @throws InvalidArgumentException If validation fails
     */
    private function validateTaskData(array &$data, bool $isUpdate = false): void
    {
        // For new tasks, check required fields
        if (!$isUpdate) {
            $requiredFields = ['title', 'description', 'due_date', 'category'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new InvalidArgumentException("Missing required field: $field");
                }
            }

            // Check for duplicate task in the same category
            $isTaskExists = $this->taskRepository->findTaskSameCategory($data['title'], $data['category']);
            if ($isTaskExists) {
                throw new InvalidArgumentException('Task title already exists in the same category');
            }
        }

        // Validate category
        if (isset($data['category']) && !in_array($data['category'], ['assignments', 'discussions', 'activities', 'examinations'])) {
            throw new InvalidArgumentException('Invalid category value');
        }

        // Handle priority (can be null or one of the valid values)
        if (empty($data['priority'])) {
            $data['priority'] = null;
        } else if (isset($data['priority']) && !empty($data['priority']) && !in_array($data['priority'], ['low', 'medium', 'high'])) {
            throw new InvalidArgumentException('Invalid priority value');
        }

        // Handle status (can be null or one of the valid values)
        if (empty($data['status'])) {
            $data['status'] = null;
        } else if (isset($data['status']) && !empty($data['status']) && !in_array($data['status'], ['on-going', 'pending', 'completed'])) {
            throw new InvalidArgumentException('Invalid status value');
        }
    }
}