<?php

declare(strict_types=1);

require_once __DIR__ . '/../interface/ITaskService.php';
require_once __DIR__ . '/../repositories/TaskRepository.php';
require_once __DIR__ . '/../services/ReminderService.php';

class TaskService implements ITaskService
{
    private TaskRepository $taskRepository;
    private ReminderService $reminderService;

    public function __construct()
    {
        $this->taskRepository = new TaskRepository();
        $this->reminderService = new ReminderService();
    }

    public function createTask(array $data): TaskModel
    {
        $reminder_time = $data['reminder_time'] ?? null;

        unset($data['reminder_time']);

        $data['user_id'] = $_SESSION['user_id'];

        $this->validateTaskData($data);

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

        $taskId = $this->taskRepository->create($taskData);

        $task = $this->getTask($taskId);

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

    public function getTask(int $id): ?TaskModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->taskRepository->findById($id);
    }

    public function getAllTasks(): array
    {
        return $this->taskRepository->findAll();
    }

    public function updateTask(int $id, array $data): TaskModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }

        $reminder_time = $data['reminder_time'] ?? null;

        unset($data['reminder_time']);

        $data['user_id'] = $_SESSION['user_id'];

        $this->validateTaskData($data, true);
        $this->taskRepository->update($id, $data);
        $task = $this->getTask($id);

        if ($reminder_time) {
            $oldReminder = $this->reminderService->getByTaskId($id) ? $this->reminderService->getByTaskId($id)->toArray() : [];

            if ($oldReminder) {
                if ($oldReminder['reminder_time'] != $reminder_time) {
                    $status = 'scheduled';
                    $this->reminderService->changeTimeReminder($id, $reminder_time, $status);
                }
            }
        }

        return $task;
    }

    public function deleteTask(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->taskRepository->delete($id);
    }

    public function getTasksToday(): array
    {
        $date = new DateTime();
        $formattedDate = $date->format('Y-m-d');
        return $this->taskRepository->findByDate($formattedDate);
    }

    public function getTasksByDate(string $date): array
    {
        return $this->taskRepository->findByDate($date);
    }

    public function getTasksByMonth(string $month): array
    {
        return $this->taskRepository->findByMonth($month);
    }

    public function getFilteredTasks(array $filters): array
    {
        $validStatuses = ['on-going', 'pending', 'completed'];
        $validPriorities = ['low', 'medium', 'high'];

        if (!empty($filters['status']) && !in_array($filters['status'], $validStatuses)) {
            throw new InvalidArgumentException('Invalid task status');
        }

        if (!empty($filters['priority']) && !in_array($filters['priority'], $validPriorities)) {
            throw new InvalidArgumentException('Invalid task priority');
        }

        if (!empty($filters['category']) && empty(trim($filters['category']))) {
            throw new InvalidArgumentException('Category cannot be empty');
        }

        return $this->taskRepository->findFilteredTask($filters);
    }

    public function getSortedTask(string $order, string $type): array
    {
        $validTypes = ['category', 'priority', 'status'];
        $validOrders = ['asc', 'desc'];

        $orderBy = in_array($type, $validTypes) ? $type : 'id';

        $orderDir = in_array(strtolower($order), $validOrders) ? strtoupper($order) : 'ASC';

        return $this->taskRepository->findSortedTask($orderBy, $orderDir);
    }


    public function changeStatusTask(int $id, string $status): bool
    {
        return $this->taskRepository->updateStatus($id, $status);
    }

    private function validateTaskData(array &$data, bool $isUpdate = false): void
    {
        if (!$isUpdate) {
            $requiredFields = ['title', 'description', 'due_date', 'category'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new InvalidArgumentException("Missing required field: $field");
                }
            }

            $isTaskExists = $this->taskRepository->findTaskSameCategory($data['title'], $data['category']);

            if ($isTaskExists) {
                throw new InvalidArgumentException('Task title already exists in the same category');
            }
        }

        if (isset($data['category']) && !in_array($data['category'], ['assignments', 'discussions', 'activities', 'examinations'])) {
            throw new InvalidArgumentException('Invalid category value');
        }

        if (empty($data['priority'])) {
            $data['priority'] = null;
        } else if (isset($data['priority']) && !empty($data['priority']) && !in_array($data['priority'], ['low', 'medium', 'high'])) {
            throw new InvalidArgumentException('Invalid priority value');
        }


        if (empty($data['status'])) {
            $data['status'] = null;
        } else if (isset($data['status']) && !empty($data['status']) && !in_array($data['status'], ['on-going', 'pending', 'completed'])) {
            throw new InvalidArgumentException('Invalid status value');
        }
    }
}