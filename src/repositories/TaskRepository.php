<?php

require_once __DIR__ . '/../models/TaskModel.php';
require_once __DIR__ . '/../interface/ITaskRepository.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class TaskRepository implements ITaskRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    public function create(TaskModel $data): int
    {
        $query = "INSERT INTO tasks (user_id, title, description, due_date, category, priority, status) 
                 VALUES (:user_id, :title, :description, :due_date, :category, :priority, :status)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'user_id' => $data->user_id,
            'title' => $data->title,
            'description' => $data->description,
            'due_date' => $data->due_date,
            'category' => $data->category,
            'priority' => $data->priority,
            'status' => $data->status
        ]);
        return $this->db->lastInsertId();
    }

    public function findById(int $id): ?TaskModel
    {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        return $task ? new TaskModel(...$task) : null;
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM tasks";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        $data['updated_at'] = new DateTime();
        $data['updated_at'] = $data['updated_at']->format('Y-m-d H:i:s');
        $query = "UPDATE tasks SET 
                 user_id = :user_id, title = :title, description = :description, due_date = :due_date, 
                 category = :category, priority = :priority, status = :status, updated_at = :updated_at
                 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    public function updateStatus(int $id, string $status): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE tasks SET status = :status, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id, 'status' => $status, 'updated_at' => $updatedAt->format('Y-m-d H:i:s')]);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    public function findByTitle(string $title): array
    {
        $query = "SELECT * FROM tasks WHERE title = :title";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['title' => $title]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findTaskSameCategory(string $title, string $category): bool
    {
        $query = "SELECT * FROM tasks WHERE title = :title AND category = :category";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['title' => $title, 'category' => $category]);
        return $stmt->rowCount() > 0;
    }

    public function findSortedTask(string $orderBy, string $orderDir): array
    {
        $query = "SELECT * FROM tasks ORDER BY $orderBy $orderDir";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function findFilteredTask(array $filters = []): array
    {
        $query = "SELECT * FROM tasks WHERE 1=1";
        $params = [];

        if (!empty($filters['status'])) {
            $query .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['priority'])) {
            $query .= " AND priority = :priority";
            $params['priority'] = $filters['priority'];
        }

        if (!empty($filters['category'])) {
            $query .= " AND category = :category";
            $params['category'] = $filters['category'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByDate(string $date): array
    {
        $query = "SELECT * FROM tasks WHERE DATE(due_date) = :due_date AND (status != 'completed' OR status IS NULL) ORDER BY due_date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['due_date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByMonth(string $month): array
    {
        $year = date('Y');
        $query = "SELECT * FROM tasks WHERE YEAR(due_date) = :year AND MONTH(due_date) = :month ORDER BY due_date ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'year' => $year,
            'month' => (int) $month
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}