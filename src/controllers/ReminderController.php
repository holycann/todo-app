<?php

require_once __DIR__ . '/../services/ReminderService.php';

class ReminderController
{
    private $reminderService;

    public function __construct()
    {
        $this->reminderService = new ReminderService();
    }

    public function index()
    {
        $reminders = $this->reminderService->getAllReminders();
        return Response::json($reminders);
    }

    public function show(int $id)
    {
        $reminder = $this->reminderService->getReminder($id);
        if ($reminder) {
            return Response::json($reminder);
        } else {
            return Response::json(['message' => 'Reminder not found'], 404);
        }
    }

    public function store()
    {
        $data = Request::all();
        $this->reminderService->createReminder($data);
        return Response::json(['message' => 'Reminder created successfully']);
    }

    public function update(int $id)
    {
        $data = Request::all();
        $this->reminderService->updateReminder($id, $data);
        return Response::json(['message' => 'Reminder updated successfully']);
    }

    public function changeStatusReminder(int $id)
    {
        $data = Request::all();

        if (!isset($data['status'])) {
            return Response::json(['message' => 'Status is required'], 400);
        }

        $reminder = $this->reminderService->changeStatusReminder($id, $data['status']);
        return Response::json(['message' => 'Reminder status changed successfully']);
    }

    public function destroy(int $id)
    {
        $success = $this->reminderService->deleteReminder($id);
        if ($success) {
            return Response::json(['message' => 'Reminder deleted successfully']);
        } else {
            return Response::json(['message' => 'Reminder not found'], 404);
        }
    }

    public function readAllReminder()
    {
        $unreadReminders = $this->reminderService->getAllUnreadReminders();

        if (empty($unreadReminders)) {
            return Response::json(['message' => "No unread reminders found"], 200);
        }

        foreach ($unreadReminders as $reminder) {
            $this->reminderService->updateReadReminder($reminder['id'], true);
        }

        return Response::json(['message' => "All Reminders Successfully Marked as Read"], 200);
    }

    public function readReminder(int $id)
    {
        $reminder = $this->reminderService->getReminder($id);

        if (!$reminder) {
            return Response::json(['error' => "Reminder not found"], 404);
        }

        $this->reminderService->updateReadReminder($id, true);

        return Response::json(['message' => "Reminder '{$reminder->title}' Successfully Marked as Read"], 200);
    }


    public function notificationSender()
    {
        $reminders = $this->reminderService->getAllScheduledReminder();

        if (count(array_filter($reminders)) > 0) {
            foreach ($reminders as $reminder) {
                $this->reminderService->changeStatusReminder($reminder['id'], 'sent');
            }
        }

        return Response::json(['message' => "All Notifications Successfully Sent"]);
    }
}