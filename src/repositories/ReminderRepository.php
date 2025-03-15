<?php
/**
 * Reminder Repository
 * 
 * This repository implements the IReminderRepository interface and handles
 * all database operations related to reminder management, including creating,
 * retrieving, updating, and deleting reminders from the database.
 * 
 * It encapsulates all SQL queries and data access logic for the reminder entity,
 * providing a clean interface for the ReminderService to interact with the database.
 */

require_once __DIR__ . '/../models/ReminderModel.php';
require_once __DIR__ . '/../interface/IReminderRepository.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class ReminderRepository implements IReminderRepository
{
    /**
     * Database connection instance
     * @var PDO
     */
    private $db;

    /**
     * Constructor - initializes the database connection
     */
    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    /**
     * Creates a new reminder in the database
     * 
     * @param ReminderModel $data The reminder model with data to insert
     * @return int The ID of the newly created reminder
     */
    public function create(ReminderModel $data): int
    {
        $query = "INSERT INTO reminders (title, message, task_id, reminder_time, status) 
                 VALUES (:title, :message, :task_id, :reminder_time, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(
            [
                'title' => $data->title,
                'message' => $data->message,
                'task_id' => $data->task_id,
                'reminder_time' => $data->reminder_time,
                'status' => $data->status
            ]
        );
        return $this->db->lastInsertId();
    }

    /**
     * Retrieves a reminder by its ID
     * 
     * @param int $id The ID of the reminder to retrieve
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function findById(int $id): ?ReminderModel
    {
        $query = "SELECT * FROM reminders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reminder ? new ReminderModel(...$reminder) : null;
    }

    /**
     * Retrieves a reminder by the associated task ID
     * 
     * @param int $task_id The ID of the related task
     * @return ReminderModel|null The reminder if found, null otherwise
     */
    public function findByTaskId(int $task_id): ?ReminderModel
    {
        $query = "SELECT * FROM reminders WHERE task_id = :task_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['task_id' => $task_id]);
        $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reminder ? new ReminderModel(...$reminder) : null;
    }

    /**
     * Retrieves all reminders from the database
     * 
     * @return array Array of all reminders ordered by creation date (newest first)
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM reminders ORDER BY created_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all unread reminders that have been sent
     * 
     * @return array Array of all unread reminders ordered by sent date (oldest first)
     */
    public function findAllUnread(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'sent' AND is_read = 0 ORDER BY sended_at ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all sent reminders
     * 
     * @return array Array of all sent reminders ordered by sent date (oldest first)
     */
    public function findAllSended(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'sent' ORDER BY sended_at ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves all scheduled reminders that are due now or overdue
     * 
     * @return array Array of scheduled reminders ordered by reminder time (oldest first)
     */
    public function findAllScheduled(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'scheduled' AND reminder_time <= NOW() ORDER BY reminder_time ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves reminders for tasks due today
     * 
     * @return array Array of reminders associated with tasks due today
     */
    public function findByTaskToday(): array
    {
        $query = "SELECT r.* FROM reminders r 
        JOIN tasks t ON r.task_id = t.id 
        WHERE DATE(t.due_date) = CURDATE()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves reminders scheduled for a specific month in the current year
     * 
     * @param string $month The month number (1-12)
     * @return array Array of reminders scheduled for the specified month
     */
    public function findByMonth(string $month): array
    {
        $year = date('Y');
        $query = "SELECT * FROM reminders WHERE YEAR(reminder_time) = :year AND MONTH(reminder_time) = :month ORDER BY reminder_time ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'year' => $year,
            'month' => (int) $month
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updates a reminder with the given ID and data
     * 
     * @param int $id The ID of the reminder to update
     * @param array $data Associative array of fields to update
     * @return bool True if the update was successful, false otherwise
     */
    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $query = "UPDATE reminders SET 
                 title = :title, message = :message, task_id = :task_id, reminder_time = :reminder_time, status = :status, is_read = :is_read, sended_at = :sended_at
                 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Updates only the status of a reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param string $status The new status value
     * @return bool True if the update was successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE reminders SET status = :status, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'status' => $status, 'updated_at' => $updatedAt->format('Y-m-d H:i:s')]);
    }

    /**
     * Marks a reminder as sent and records the time it was sent
     * 
     * @param int $id The ID of the reminder to mark as sent
     * @return bool True if the update was successful, false otherwise
     */
    public function updateSended(int $id): bool
    {
        $today = new DateTime();
        $query = "UPDATE reminders SET status = 'sent', sended_at = :sended_at, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'sended_at' => $today->format('Y-m-d H:i:s'), 'updated_at' => $today->format('Y-m-d H:i:s')]);
    }

    /**
     * Updates the read status of a reminder
     * 
     * @param int $id The ID of the reminder to update
     * @param bool $is_read The new read status
     * @return bool True if the update was successful, false otherwise
     */
    public function updateRead(int $id, bool $is_read): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE reminders SET is_read = :is_read, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'is_read' => $is_read, 'updated_at' => $updatedAt->format('Y-m-d H:i:s')]);
    }

    /**
     * Updates the scheduled time and status of a reminder associated with a task
     * 
     * @param int $task_id The ID of the related task
     * @param string $reminder_time The new time for the reminder
     * @param string $status The new status for the reminder
     * @return bool True if the update was successful, false otherwise
     */
    public function updateTime(int $task_id, string $reminder_time, string $status): bool
    {
        $now = new DateTime();

        $query = "UPDATE reminders SET reminder_time = :reminder_time, status = :status,  is_read = :is_read, updated_at = :updated_at WHERE task_id = :task_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'task_id' => $task_id,
            'reminder_time' => $reminder_time,
            'status' => $status,
            'is_read' => 0,
            'updated_at' => $now->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Deletes a reminder with the given ID
     * 
     * @param int $id The ID of the reminder to delete
     * @return bool True if the deletion was successful, false otherwise
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM reminders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}