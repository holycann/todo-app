<?php

class TaskModel
{
    public ?int $id;
    public int $user_id;
    public string $title;
    public string $description;
    public string $due_date;
    public string $category;
    public ?string $priority;
    public ?string $status;
    public ?string $created_at;
    public ?string $updated_at;

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