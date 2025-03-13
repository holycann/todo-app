<?php

require_once __DIR__ . '/../models/ReminderModel.php';
require_once __DIR__ . '/../interface/IReminderRepository.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class ReminderRepository implements IReminderRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

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

    public function findById(int $id): ?ReminderModel
    {
        $query = "SELECT * FROM reminders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reminder ? new ReminderModel(...$reminder) : null;
    }

    public function findByTaskId(int $task_id): ?ReminderModel
    {
        $query = "SELECT * FROM reminders WHERE task_id = :task_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['task_id' => $task_id]);
        $reminder = $stmt->fetch(PDO::FETCH_ASSOC);
        return $reminder ? new ReminderModel(...$reminder) : null;
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM reminders ORDER BY created_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllUnread(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'sent' AND is_read = 0 ORDER BY sended_at ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllSended(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'sent' ORDER BY sended_at ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllScheduled(): array
    {
        $query = "SELECT * FROM reminders WHERE status = 'scheduled' AND reminder_time <= NOW() ORDER BY reminder_time ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByTaskToday(): array
    {
        $query = "SELECT r.* FROM reminders r 
        JOIN tasks t ON r.task_id = t.id 
        WHERE DATE(t.due_date) = CURDATE()";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $query = "UPDATE reminders SET 
                 title = :title, message = :message, task_id = :task_id, reminder_time = :reminder_time, status = :status, is_read = :is_read, sended_at = :sended_at
                 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE reminders SET status = :status, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'status' => $status, 'updated_at' => $updatedAt->format('Y-m-d H:i:s')]);
    }

    public function updateSended(int $id): bool
    {
        $today = new DateTime();
        $query = "UPDATE reminders SET status = 'sent', sended_at = :sended_at, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'sended_at' => $today->format('Y-m-d H:i:s'), 'updated_at' => $today->format('Y-m-d H:i:s')]);
    }

    public function updateRead(int $id, bool $is_read): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE reminders SET is_read = :is_read, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'is_read' => $is_read, 'updated_at' => $updatedAt->format('Y-m-d H:i:s')]);
    }

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

    public function delete(int $id): bool
    {
        $query = "DELETE FROM reminders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}