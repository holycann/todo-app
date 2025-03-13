<?php

class ReminderModel
{
    public ?int $id;
    public string $title;
    public string $message;
    public ?int $task_id;
    public string $status;
    public int $is_read;
    public ?string $reminder_time;
    public ?string $created_at;
    public ?string $sended_at;
    public ?string $updated_at;

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