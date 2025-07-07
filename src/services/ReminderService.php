<?php
/**
 * Reminder Service
 * 
 * This service implements the IReminderService interface and contains all the business logic
 * for reminder management, including creation, retrieval, update, and deletion operations.
 * It handles sending reminders for tasks, tracking their status, and managing read/unread states.
 * 
 * The service acts as an intermediary between controllers and repositories,
 * enforcing business rules and data integrity for reminders.
 */

declare(strict_types=1);

require_once __DIR__ . '/../interface/IReminderService.php';
require_once __DIR__ . '/../repositories/ReminderRepository.php';

class ReminderService implements IReminderService
{
    /**
     * Repository for reminder data access operations
     * @var ReminderRepository
     */
    private ReminderRepository $reminderRepository;

    /**
     * Constructor - initializes the reminder repository
     */
    public function __construct()
    {
        $this->reminderRepository = new ReminderRepository();
    }

    /**
     * Creates a new reminder
     * 
     * This method validates reminder data and creates a new reminder in the database.
     * Reminders can be associated with tasks by providing a task_id.
     *
     * @param array $data Reminder data including title, message, task_id (optional), reminder_time, and status (optional)
     * @return ReminderModel The newly created reminder
     * @throws InvalidArgumentException If validation fails
     */
    public function createReminder(array $data): ReminderModel
    {
        // Validate reminder data
        $this->validateReminderData($data);

        // Create reminder model
        $reminderData = new ReminderModel(
            null,
            $data['title'],
            $data['message'],
            !empty($data['task_id']) ? $data['task_id'] : null,
            0, // is_read is initially false
            $data['reminder_time'],
            null, // sended_at starts as null
            null, // created_at will be set by repository
            null, // updated_at will be set by repository
            $data['status'] ?? 'scheduled' // Default status is scheduled
        );

        // Save to database and get the ID
        $reminderId = $this->reminderRepository->create($reminderData);
        
        // Return the complete reminder with all fields
        return $this->getReminder($reminderId);
    }

    /**
     * Retrieves a reminder by its ID
     *
     * @param int $id The ID of the reminder to retrieve
     * @return ReminderModel|null The reminder if found, null otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function getReminder(int $id): ?ReminderModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }
        return $this->reminderRepository->findById($id);
    }

    /**
     * Retrieves a reminder associated with a specific task
     *
     * @param int $task_id The ID of the task
     * @return ReminderModel|null The reminder if found, null otherwise
     * @throws InvalidArgumentException If task ID is invalid
     */
    public function getByTaskId(int $task_id): ?ReminderModel
    {
        if ($task_id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->reminderRepository->findByTaskId($task_id);
    }

    /**
     * Retrieves all reminders from the database
     *
     * @return array Array of all reminders
     */
    public function getAllReminders(): array
    {
        return $this->reminderRepository->findAll();
    }

    /**
     * Retrieves all unread reminders
     *
     * @return array Array of all unread reminders
     */
    public function getAllUnreadReminders(): array
    {
        return $this->reminderRepository->findAllUnread();
    }

    /**
     * Retrieves all sent reminders
     *
     * @return array Array of all reminders that have been sent
     */
    public function getAllSendedReminders(): array
    {
        return $this->reminderRepository->findAllSended();
    }

    /**
     * Retrieves all scheduled reminders that haven't been sent yet
     *
     * @return array Array of all reminders in scheduled status
     */
    public function getAllScheduledReminder(): array
    {
        return $this->reminderRepository->findAllScheduled();
    }

    /**
     * Retrieves all reminders for tasks due today
     *
     * @return array Array of reminders for today's tasks
     */
    public function getAllByTaskToday(): array
    {
        return $this->reminderRepository->findByTaskToday();
    }

    /**
     * Retrieves all reminders for tasks due in a specific month
     *
     * @param string $month Month number (1-12)
     * @return array Array of reminders for the specified month
     */
    public function getAllByMonth(string $month): array
    {
        return $this->reminderRepository->findByMonth($month);
    }

    /**
     * Updates an existing reminder with new data
     *
     * This method validates the updated data and updates the reminder in the database.
     * If the reminder_time is changed, the status is reset to 'scheduled'.
     *
     * @param int $id The ID of the reminder to update
     * @param array $data Updated reminder data
     * @return ReminderModel The updated reminder
     * @throws InvalidArgumentException If validation fails
     */
    public function updateReminder(int $id, array $data): ReminderModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        // Validate reminder data
        $this->validateReminderData($data, true);

        // Get the current reminder to check for changes
        $oldReminder = $this->getReminder($id);

        // If reminder time has changed, reset the status and related fields
        if (isset($data['reminder_time']) && $oldReminder->reminder_time !== $data['reminder_time']) {
            $data['status'] = 'scheduled';
            $data['sended_at'] = null;
            $data['is_read'] = 0;
        }

        // Update the reminder
        $this->reminderRepository->update($id, $data);
        
        // Return the updated reminder
        return $this->getReminder($id);
    }

    /**
     * Updates the read status of a reminder
     *
     * @param int $id The ID of the reminder to update
     * @param bool $is_read The new read status
     * @return bool True if update was successful, false otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function updateReadReminder(int $id, bool $is_read): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        return $this->reminderRepository->updateRead($id, $is_read);
    }

    /**
     * Deletes a reminder by its ID
     *
     * @param int $id The ID of the reminder to delete
     * @return bool True if deletion was successful, false otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function deleteReminder(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }
        return $this->reminderRepository->delete($id);
    }

    /**
     * Updates the status of a reminder to 'sent'
     *
     * @param int $id The ID of the reminder to update
     * @param string $status The new status
     * @return bool True if update was successful, false otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function changeStatusReminder(int $id, string $status): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        return $this->reminderRepository->updateSended($id);
    }

    /**
     * Updates the scheduled time of a reminder associated with a task
     *
     * @param int $task_id The ID of the associated task
     * @param string $reminder_time The new reminder time
     * @param string $status The new status for the reminder
     * @return bool True if update was successful, false otherwise
     * @throws InvalidArgumentException If task ID is invalid
     */
    public function changeTimeReminder(int $task_id, string $reminder_time, string $status): bool
    {
        if ($task_id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }

        return $this->reminderRepository->updateTime($task_id, $reminder_time, $status);
    }

    /**
     * Validates reminder data before creation or update
     *
     * @param array &$data Reminder data to validate (passed by reference to apply defaults)
     * @param bool $isUpdate Whether this is an update operation (affects validation rules)
     * @return void
     * @throws InvalidArgumentException If validation fails
     */
    private function validateReminderData(array &$data, bool $isUpdate = false): void
    {
        // Handle task_id: convert to integer or null
        $data['task_id'] = empty($data['task_id']) ? null : (int) $data['task_id'];

        // For new reminders, check required fields
        if (!$isUpdate) {
            $requiredFields = ['title', 'message', 'reminder_time'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new InvalidArgumentException("Missing required field: $field");
                }
            }
        }

        // Handle status (default or validate)
        if (empty($data['status'])) {
            $data['status'] = 'scheduled';
        } else if (isset($data['status']) && !empty($data['status']) && !in_array($data['status'], ['scheduled', 'sent'])) {
            throw new InvalidArgumentException('Invalid status value');
        }
    }
}