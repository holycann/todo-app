<?php
/**
 * Reminder Controller
 * 
 * This controller handles all HTTP requests related to reminder management,
 * including listing, creating, updating, and deleting reminders. It also manages
 * specialized reminder operations like marking reminders as read/unread and
 * sending notifications.
 * 
 * Routes to this controller are defined in src/routes/ReminderRoute.php
 */

require_once __DIR__ . '/../services/ReminderService.php';
require_once __DIR__ . '/../core/Response.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class ReminderController
{
    private ReminderService $reminderService;
    private AuthMiddleware $authMiddleware;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->reminderService = new ReminderService();
        $this->authMiddleware = new AuthMiddleware();
    }

    /**
     * Lists all reminders
     * 
     * Endpoint: GET /reminders
     * Returns a JSON array of all reminders
     * 
     * @return mixed JSON response with reminders data
     */
    public function index()
    {
        $this->authMiddleware->requireAuth();
        $reminders = $this->reminderService->getAllReminders();
        return Response::json($reminders);
    }

    /**
     * Retrieves a specific reminder by ID
     * 
     * Endpoint: GET /reminders/{id}
     * 
     * @param int $id The ID of the reminder to retrieve
     * @return mixed JSON response with reminder data or error message
     */
    public function show(int $id)
    {
        $this->authMiddleware->requireAuth();
        $reminder = $this->reminderService->getReminder($id);
        if ($reminder) {
            return Response::json($reminder);
        } else {
            return Response::json(['message' => 'Reminder not found'], 404);
        }
    }

    /**
     * Creates a new reminder
     * 
     * Endpoint: POST /reminders
     * Expects a JSON payload with reminder data in the request body
     * 
     * @return mixed JSON response with success message
     */
    public function store()
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();
        $this->reminderService->createReminder($data);
        return Response::json(['message' => 'Reminder created successfully']);
    }

    /**
     * Updates an existing reminder
     * 
     * Endpoint: PUT /reminders/{id}
     * Expects a JSON payload with reminder data in the request body
     * 
     * @param int $id The ID of the reminder to update
     * @return mixed JSON response with success message
     */
    public function update(int $id)
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();
        $this->reminderService->updateReminder($id, $data);
        return Response::json(['message' => 'Reminder updated successfully']);
    }

    /**
     * Updates the status of a reminder
     * 
     * Endpoint: PATCH /reminders/{id}/status
     * Expects a JSON payload with the 'status' field in the request body
     * 
     * @param int $id The ID of the reminder to update
     * @return mixed JSON response with success or error message
     */
    public function changeStatusReminder(int $id)
    {
        $this->authMiddleware->requireAuth();
        $data = Request::all();

        if (!isset($data['status'])) {
            return Response::json(['message' => 'Status is required'], 400);
        }

        $reminder = $this->reminderService->changeStatusReminder($id, $data['status']);
        return Response::json(['message' => 'Reminder status changed successfully']);
    }

    /**
     * Deletes a reminder
     * 
     * Endpoint: DELETE /reminders/{id}
     * 
     * @param int $id The ID of the reminder to delete
     * @return mixed JSON response with success or error message
     */
    public function destroy(int $id)
    {
        $this->authMiddleware->requireAuth();
        $success = $this->reminderService->deleteReminder($id);
        if ($success) {
            return Response::json(['message' => 'Reminder deleted successfully']);
        } else {
            return Response::json(['message' => 'Reminder not found'], 404);
        }
    }

    /**
     * Marks all unread reminders as read
     * 
     * Endpoint: POST /reminders/read-all
     * This endpoint finds all unread reminders and marks them as read.
     * 
     * @return mixed JSON response with success or information message
     */
    public function readAllReminder()
    {
        $this->authMiddleware->requireAuth();
        $unreadReminders = $this->reminderService->getAllUnreadReminders();

        if (empty($unreadReminders)) {
            return Response::json(['message' => "No unread reminders found"], 200);
        }

        foreach ($unreadReminders as $reminder) {
            $this->reminderService->updateReadReminder($reminder['id'], true);
        }

        return Response::json(['message' => "All Reminders Successfully Marked as Read"], 200);
    }

    /**
     * Marks a specific reminder as read
     * 
     * Endpoint: POST /reminders/{id}/read
     * 
     * @param int $id The ID of the reminder to mark as read
     * @return mixed JSON response with success or error message
     */
    public function readReminder(int $id)
    {
        $this->authMiddleware->requireAuth();
        $reminder = $this->reminderService->getReminder($id);

        if (!$reminder) {
            return Response::json(['error' => "Reminder not found"], 404);
        }

        $this->reminderService->updateReadReminder($id, true);

        return Response::json(['message' => "Reminder '{$reminder->title}' Successfully Marked as Read"], 200);
    }

    /**
     * Sends pending notifications for scheduled reminders
     * 
     * Endpoint: POST /reminders/send-notifications
     * This endpoint checks for all scheduled reminders and marks them as sent.
     * In a production environment, this would typically trigger actual notification
     * delivery through email, SMS, or push notifications.
     * 
     * @return mixed JSON response with success message
     */
    public function notificationSender()
    {
        $this->authMiddleware->requireAuth();
        $reminders = $this->reminderService->getAllScheduledReminder();

        if (count(array_filter($reminders)) > 0) {
            foreach ($reminders as $reminder) {
                $this->reminderService->changeStatusReminder($reminder['id'], 'sent');
            }
        }

        return Response::json(['message' => "All Notifications Successfully Sent"]);
    }
}