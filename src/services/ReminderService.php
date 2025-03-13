<?php

declare(strict_types=1);

require_once __DIR__ . '/../interface/IReminderService.php';
require_once __DIR__ . '/../repositories/ReminderRepository.php';

class ReminderService implements IReminderService
{
    private ReminderRepository $reminderRepository;

    public function __construct()
    {
        $this->reminderRepository = new ReminderRepository();
    }

    public function createReminder(array $data): ReminderModel
    {
        $this->validateReminderData($data);

        $reminderData = new ReminderModel(
            null,
            $data['title'],
            $data['message'],
            !empty($data['task_id']) ? $data['task_id'] : null,
            0,
            $data['reminder_time'],
            null,
            null,
            null,
            $data['status'] ?? 'scheduled'
        );

        $reminderId = $this->reminderRepository->create($reminderData);
        return $this->getReminder($reminderId);
    }

    public function getReminder(int $id): ?ReminderModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }
        return $this->reminderRepository->findById($id);
    }

    public function getByTaskId(int $task_id): ?ReminderModel
    {
        if ($task_id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }
        return $this->reminderRepository->findByTaskId($task_id);
    }

    public function getAllReminders(): array
    {
        return $this->reminderRepository->findAll();
    }

    public function getAllUnreadReminders(): array
    {
        return $this->reminderRepository->findAllUnread();
    }

    public function getAllSendedReminders(): array
    {
        return $this->reminderRepository->findAllSended();
    }

    public function getAllScheduledReminder(): array
    {
        return $this->reminderRepository->findAllScheduled();
    }

    public function getAllByTaskToday(): array
    {
        return $this->reminderRepository->findByTaskToday();
    }

    public function getAllByMonth(string $month): array
    {
        return $this->reminderRepository->findByMonth($month);
    }

    public function updateReminder(int $id, array $data): ReminderModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        $this->validateReminderData($data, true);

        $oldReminder = $this->getReminder($id);

        if (isset($data['reminder_time']) && $oldReminder->reminder_time !== $data['reminder_time']) {
            $data['status'] = 'scheduled';
            $data['sended_at'] = null;
            $data['is_read'] = 0;
        }

        $this->reminderRepository->update($id, $data);
        return $this->getReminder($id);
    }

    public function updateReadReminder(int $id, bool $is_read): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        return $this->reminderRepository->updateRead($id, $is_read);
    }

    public function deleteReminder(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }
        return $this->reminderRepository->delete($id);
    }

    public function changeStatusReminder(int $id, string $status): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid reminder ID');
        }

        return $this->reminderRepository->updateSended($id);
    }

    public function changeTimeReminder(int $task_id, string $reminder_time, string $status): bool
    {
        if ($task_id <= 0) {
            throw new InvalidArgumentException('Invalid task ID');
        }

        return $this->reminderRepository->updateTime($task_id, $reminder_time, $status);
    }

    private function validateReminderData(array &$data, bool $isUpdate = false): void
    {
        $data['task_id'] = empty($data['task_id']) ? null : (int) $data['task_id'];

        if (!$isUpdate) {
            $requiredFields = ['title', 'message', 'reminder_time'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new InvalidArgumentException("Missing required field: $field");
                }
            }
        }

        if (empty($data['status'])) {
            $data['status'] = 'scheduled';
        } else if (isset($data['status']) && !empty($data['status']) && !in_array($data['status'], ['scheduled', 'sent'])) {
            throw new InvalidArgumentException('Invalid status value');
        }
    }
}