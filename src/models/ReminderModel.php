<?php
/**
 * Reminder Model
 * 
 * This class represents a reminder entity in the Todo application.
 * It encapsulates all the data related to a notification or reminder
 * that can be attached to tasks or sent to users.
 */
class ReminderModel
{
    /**
     * Unique identifier for the reminder
     * @var int|null
     */
    public ?int $id;
    
    /**
     * Title of the reminder
     * @var string
     */
    public string $title;
    
    /**
     * Detailed message content of the reminder
     * @var string
     */
    public string $message;
    
    /**
     * Associated task ID (if reminder is linked to a task)
     * @var int|null
     */
    public ?int $task_id;
    
    /**
     * Current status of the reminder (e.g., 'pending', 'sent', 'cancelled')
     * @var string
     */
    public string $status;
    
    /**
     * Flag indicating whether the reminder has been read (1) or not (0)
     * @var int
     */
    public int $is_read;
    
    /**
     * Scheduled time when the reminder should be sent
     * @var string|null
     */
    public ?string $reminder_time;
    
    /**
     * Timestamp when the reminder was created
     * @var string|null
     */
    public ?string $created_at;
    
    /**
     * Timestamp when the reminder was actually sent
     * @var string|null
     */
    public ?string $sended_at;
    
    /**
     * Timestamp when the reminder was last updated
     * @var string|null
     */
    public ?string $updated_at;

    /**
     * Constructor for creating a new ReminderModel instance
     *
     * @param int|null $id Reminder ID (null for new reminders)
     * @param string $title Reminder title
     * @param string $message Detailed message content
     * @param int|null $task_id Associated task ID (if applicable)
     * @param int|null $is_read Flag indicating read status (1=read, 0=unread)
     * @param string|null $reminder_time Scheduled time for sending
     * @param string|null $sended_at Timestamp when reminder was sent
     * @param string|null $created_at Creation timestamp
     * @param string|null $updated_at Last update timestamp
     * @param string $status Current status of the reminder
     */
    public function __construct(
        ?int $id,
        string $title,
        string $message,
        ?int $task_id,
        ?int $is_read,
        ?string $reminder_time,
        ?string $sended_at,
        ?string $created_at,
        ?string $updated_at,
        string $status
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->task_id = $task_id;
        $this->is_read = $is_read;
        $this->reminder_time = $reminder_time;
        $this->sended_at = $sended_at;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->status = $status;
    }
    
    /**
     * Converts the reminder object to an associative array
     * 
     * This method is useful for JSON serialization or
     * when passing reminder data to views.
     *
     * @return array Associative array of reminder properties
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'task_id' => $this->task_id,
            'is_read' => $this->is_read,
            'reminder_time' => $this->reminder_time,
            'sended_at' => $this->sended_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
        ];
    }

}

?>