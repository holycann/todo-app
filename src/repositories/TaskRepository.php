<?php
/**
 * Task Repository
 * 
 * This class implements the ITaskRepository interface and handles all database
 * operations related to tasks in the Todo application. It encapsulates the 
 * data access logic and provides methods for CRUD operations and specialized
 * queries on the tasks table.
 */

require_once __DIR__ . '/../models/TaskModel.php';
require_once __DIR__ . '/../interface/ITaskRepository.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class TaskRepository implements ITaskRepository
{
    /**
     * Database connection instance
     * @var PDO
     */
    private $db;

    /**
     * Constructor - initializes database connection
     */
    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    /**
     * Creates a new task record in the database
     *
     * @param TaskModel $data The task data to insert
     * @return int The ID of the newly created task
     */
    public function create(TaskModel $data): int
    {
        // Prepare SQL query with named parameters for security (prevents SQL injection)
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
        
        // Return the ID of the newly inserted task
        return $this->db->lastInsertId();
    }

    /**
     * Retrieves a task by its ID
     *
     * @param int $id The task ID to find
     * @return TaskModel|null The found task or null if not found
     */
    public function findById(int $id): ?TaskModel
    {
        $query = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Create and return a TaskModel instance if found, otherwise return null
        return $task ? new TaskModel(...$task) : null;
    }

    /**
     * Retrieves all tasks from the database
     *
     * @return array Array of task records as associative arrays
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM tasks";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Updates a task with the given ID
     *
     * @param int $id The ID of the task to update
     * @param array $data Associative array of fields to update
     * @return bool True if the update was successful, false otherwise
     */
    public function update(int $id, array $data): bool
    {
        // Add ID to data array and set updated_at timestamp
        $data['id'] = $id;
        $data['updated_at'] = new DateTime();
        $data['updated_at'] = $data['updated_at']->format('Y-m-d H:i:s');
        
        // Build update query with all fields
        $query = "UPDATE tasks SET 
                 user_id = :user_id, title = :title, description = :description, due_date = :due_date, 
                 category = :category, priority = :priority, status = :status, updated_at = :updated_at
                 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Updates only the status of a task
     *
     * @param int $id The ID of the task to update
     * @param string $status The new status value
     * @return bool True if the update was successful, false otherwise
     */
    public function updateStatus(int $id, string $status): bool
    {
        $updatedAt = new DateTime();
        $query = "UPDATE tasks SET status = :status, updated_at = :updated_at WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id, 
            'status' => $status, 
            'updated_at' => $updatedAt->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Deletes a task with the given ID
     *
     * @param int $id The ID of the task to delete
     * @return bool True if the deletion was successful, false otherwise
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Finds tasks by their title
     *
     * @param string $title The title to search for
     * @return array Array of matching tasks as associative arrays
     */
    public function findByTitle(string $title): array
    {
        $query = "SELECT * FROM tasks WHERE title = :title";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['title' => $title]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Checks if a task with the same title and category exists
     *
     * This is useful for preventing duplicate tasks in the same category.
     *
     * @param string $title The title to check
     * @param string $category The category to check
     * @return bool True if a matching task exists, false otherwise
     */
    public function findTaskSameCategory(string $title, string $category): bool
    {
        $query = "SELECT * FROM tasks WHERE title = :title AND category = :category";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['title' => $title, 'category' => $category]);
        return $stmt->rowCount() > 0;
    }

    /**
     * Retrieves tasks sorted by the specified column and direction
     *
     * @param string $orderBy Column name to sort by
     * @param string $orderDir Sort direction ('ASC' or 'DESC')
     * @return array Array of sorted tasks as associative arrays
     */
    public function findSortedTask(string $orderBy, string $orderDir): array
    {
        // Note: This query is vulnerable to SQL injection if $orderBy and $orderDir 
        // are not properly validated before being passed to this method
        $query = "SELECT * FROM tasks ORDER BY $orderBy $orderDir";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retrieves tasks filtered by the specified criteria
     *
     * @param array $filters Associative array of filter criteria
     * @return array Array of filtered tasks as associative arrays
     */
    public function findFilteredTask(array $filters = []): array
    {
        // Start with base query and build conditionally based on filters
        $query = "SELECT * FROM tasks WHERE 1=1";
        $params = [];

        // Add status filter if provided
        if (!empty($filters['status'])) {
            $query .= " AND status = :status";
            $params['status'] = $filters['status'];
        }

        // Add priority filter if provided
        if (!empty($filters['priority'])) {
            $query .= " AND priority = :priority";
            $params['priority'] = $filters['priority'];
        }

        // Add category filter if provided
        if (!empty($filters['category'])) {
            $query .= " AND category = :category";
            $params['category'] = $filters['category'];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Finds tasks due on a specific date
     *
     * Only returns non-completed tasks.
     *
     * @param string $date The due date in 'Y-m-d' format
     * @return array Array of matching tasks as associative arrays
     */
    public function findByDate(string $date): array
    {
        $query = "SELECT * FROM tasks WHERE DATE(due_date) = :due_date AND (status != 'completed' OR status IS NULL) ORDER BY due_date ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['due_date' => $date]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Finds tasks due in a specific month of the current year
     *
     * @param string $month The month number (1-12)
     * @return array Array of matching tasks as associative arrays
     */
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