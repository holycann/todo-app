<?php
/**
 * Task Model
 * 
 * This class represents a task entity in the Todo application.
 * It encapsulates all the data related to a task and provides
 * methods for manipulating this data.
 */
class TaskModel
{
    /**
     * Unique identifier for the task
     * @var int|null
     */
    public ?int $id;
    
    /**
     * User ID who owns this task
     * @var int
     */
    public int $user_id;
    
    /**
     * Title/name of the task
     * @var string
     */
    public string $title;
    
    /**
     * Detailed description of the task
     * @var string
     */
    public string $description;
    
    /**
     * Due date for task completion (in Y-m-d format)
     * @var string
     */
    public string $due_date;
    
    /**
     * Category/tag for grouping related tasks
     * @var string
     */
    public string $category;
    
    /**
     * Priority level (e.g., 'high', 'medium', 'low')
     * @var string|null
     */
    public ?string $priority;
    
    /**
     * Current status (e.g., 'pending', 'in progress', 'completed')
     * @var string|null
     */
    public ?string $status;
    
    /**
     * Timestamp when the task was created
     * @var string|null
     */
    public ?string $created_at;
    
    /**
     * Timestamp when the task was last updated
     * @var string|null
     */
    public ?string $updated_at;

    /**
     * Constructor for creating a new TaskModel instance
     *
     * @param int|null $id Task ID (null for new tasks)
     * @param int $user_id User ID who owns this task
     * @param string $title Task title
     * @param string $description Detailed description
     * @param string $due_date Due date in Y-m-d format
     * @param string $category Task category
     * @param string|null $priority Task priority level
     * @param string|null $status Current task status
     * @param string|null $created_at Creation timestamp
     * @param string|null $updated_at Last update timestamp
     */
    public function __construct(
        ?int $id,
        int $user_id,
        string $title,
        string $description,
        string $due_date,
        string $category,
        ?string $priority,
        ?string $status,
        ?string $created_at,
        ?string $updated_at
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->description = $description;
        $this->due_date = $due_date;
        $this->category = $category;
        $this->priority = $priority;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    /**
     * Converts the task object to an associative array
     * 
     * This method is useful for JSON serialization or
     * when passing task data to views.
     *
     * @return array Associative array of task properties
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'category' => $this->category,
            'priority' => $this->priority,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

}

?>