<?php
/**
 * Pages Controller
 * 
 * This controller handles the rendering of all page views in the application.
 * It serves as a front controller for the presentation layer, initializing the
 * required services, passing data to views, and managing authentication state
 * for protected pages.
 * 
 * Routes to this controller are defined in the main router configuration.
 */

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../services/TaskService.php';
require_once __DIR__ . '/../services/ReminderService.php';
require_once __DIR__ . '/../core/Request.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class PagesController
{
    /**
     * Services for data operations
     * @var UserService
     */
    private UserService $userService;
    
    /**
     * @var TaskService
     */
    private TaskService $taskService;
    
    /**
     * @var ReminderService
     */
    private ReminderService $reminderService;
    
    /**
     * @var AuthMiddleware
     */
    private AuthMiddleware $authMiddleware;
    
    /**
     * Constructor - initializes the required services
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userService = new UserService();
        $this->taskService = new TaskService();
        $this->reminderService = new ReminderService();
        $this->authMiddleware = new AuthMiddleware();
    }
    
    /**
     * Renders the homepage
     * 
     * Displays today's tasks and associated reminders. Handles authentication
     * redirect if the user is not logged in.
     * 
     * URL: /
     * 
     * @return void
     */
    public function Index()
    {
        $this->authMiddleware->requireAuth();
        
        $user_id = $_SESSION['user_id'];
        $user = $this->userService->getUserById($user_id);

        $tasksToday = $this->taskService->getTasksToday();
        if ($tasksToday) {
            $todayDate = date('j F', strtotime($tasksToday[0]['due_date']));

            $remindersData = $this->reminderService->getAllByTaskToday();
            $reminders = [];
            foreach ($remindersData as $reminder) {
                $reminders[$reminder['task_id']] = $reminder;
            }
        }

        $title = "Homepage";
        $nav_title = "Today";
        $slug = "Let's check your tasks today";
        require_once __DIR__ . '/../views/pages/HomePage.php';
    }
    
    /**
     * Renders the login page
     * 
     * If user is already logged in, redirects to homepage.
     * 
     * URL: /login
     * 
     * @return void
     */
    public function LoginPage()
    {
        $this->authMiddleware->redirectIfAuthenticated();
        
        $title = "Login";
        require_once __DIR__ . '/../views/pages/auth/LoginPage.php';
    }
    
    /**
     * Renders the registration page
     * 
     * If user is already logged in, redirects to homepage.
     * 
     * URL: /register
     * 
     * @return void
     */
    public function RegisterPage()
    {
        $this->authMiddleware->redirectIfAuthenticated();
        
        $title = "Register";
        require_once __DIR__ . '/../views/pages/auth/RegisterPage.php';
    }

    /**
     * Renders the archived tasks page
     * 
     * Displays all completed tasks.
     * 
     * URL: /archived
     * 
     * @return void
     */
    public function ArchivedPage()
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Archived";
        $nav_title = "Archived";
        $slug = "Let's check your archived tasks";

        $completedTasks = $this->taskService->getFilteredTasks(['status' => 'completed']);

        require_once __DIR__ . '/../views/pages/ArchivedPage.php';
    }

    /**
     * Renders the task filter page
     * 
     * Allows users to filter and sort tasks based on various criteria.
     * 
     * URL: /filter
     * 
     * @return void
     */
    public function FilterPage()
    {
        $this->authMiddleware->requireAuth();
        
        $data = Request::all();
        $filters = array_filter($data, fn($value) => !is_null($value) && $value !== '');

        if (empty($filters)) {
            $tasks = $this->taskService->getAllTasks();
        } else if (isset($data['sort'])) {
            $tasks = $this->taskService->getSortedTask($data['order'], $data['sort']);
        } else {
            $tasks = $this->taskService->getFilteredTasks($filters);
        }

        $title = "Filter";
        $nav_title = "Filter";
        $slug = "Let's filter your tasks";
        require_once __DIR__ . '/../views/pages/FilterPage.php';
    }

    /**
     * Renders the upcoming tasks page
     * 
     * Displays tasks grouped by due date for a specific month.
     * 
     * URL: /upcoming
     * 
     * @return void
     */
    public function UpcomingPage()
    {
        $this->authMiddleware->requireAuth();
        
        $data = Request::all();

        $title = "Upcoming";
        $nav_title = "Upcoming";
        $slug = "Let's check your upcoming tasks";

        $today = date('Y-m-d');
        $currentMonth = date('m');

        $month = $data['month'] ?? $currentMonth;


        if (!ctype_digit($month) || (int) $month < 1 || (int) $month > 12) {
            $month = $currentMonth;
        }

        $tasksByMonth = $this->taskService->getTasksByMonth($month);

        $remindersData = $this->reminderService->getAllByMonth($month);
        $reminders = [];
        foreach ($remindersData as $reminder) {
            $reminders[$reminder['task_id']] = $reminder;
        }

        $groupedTasks = [];
        foreach ($tasksByMonth as $task) {
            if ($task['status'] != 'completed') {
                $dueDate = date('Y-m-d', strtotime($task['due_date']));
                $formattedDueDate = date('d - l', strtotime($dueDate));

                if ($dueDate < $today) {
                    $formattedDueDate = 'Overdue';
                }

                $groupedTasks[$formattedDueDate][] = $task;
            }
        }

        require_once __DIR__ . '/../views/pages/UpcomingPage.php';
    }
    
    /**
     * Renders the task detail page
     * 
     * Displays detailed information about a specific task and its associated reminder.
     * 
     * URL: /tasks/{id}
     * 
     * @param int $id The ID of the task to display
     * @return void
     */
    public function DetailTask($id)
    {
        $this->authMiddleware->requireAuth();
        
        $task = $this->taskService->getTask($id) ? $this->taskService->getTask($id)->toArray() : [];

        if (!$task) {
            header("Location: " . BASE_ENDPOINT . "/");
            exit;
        }

        $reminder = $this->reminderService->getByTaskId($id) ? $this->reminderService->getByTaskId($id)->toArray() : [];

        $title = "Task Detail";
        $nav_title = "Detail";
        $slug = "Let's check your task detail";
        require_once __DIR__ . '/../views/pages/tasks/DetailTask.php';
    }
    
    /**
     * Renders the add task page
     * 
     * URL: /tasks/add
     * 
     * @return void
     */
    public function AddTaskPage()
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Add Task";
        $nav_title = "Add Task";
        $slug = "Let's add a new task";
        require_once __DIR__ . '/../views/pages/tasks/AddEditTask.php';
    }

    /**
     * Renders the edit task page
     * 
     * URL: /tasks/{id}/edit
     * 
     * @param int $id The ID of the task to edit
     * @return void
     */
    public function EditTaskPage($id)
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Edit Task";
        $nav_title = "Edit Task";
        $slug = "Let's edit a task";

        $task = $this->taskService->getTask($id) ? $this->taskService->getTask($id)->toArray() : [];
        $reminder = $this->reminderService->getByTaskId($id) ? $this->reminderService->getByTaskId($id)->toArray() : [];

        require_once __DIR__ . '/../views/pages/tasks/AddEditTask.php';
    }

    /**
     * Renders the add reminder page
     * 
     * URL: /reminders/add
     * 
     * @return void
     */
    public function AddReminderPage()
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Add Reminder";
        $nav_title = "Add Reminder";
        $slug = "Let's add a new reminder";

        $tasks = $this->taskService->getAllTasks();

        require_once __DIR__ . '/../views/pages/reminders/AddEditReminder.php';
    }

    /**
     * Renders the edit reminder page
     * 
     * URL: /reminders/{id}/edit
     * 
     * @param int $id The ID of the reminder to edit
     * @return void
     */
    public function EditReminderPage($id)
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Edit Reminder";
        $nav_title = "Edit Reminder";
        $slug = "Let's edit a reminder";

        $reminder = $this->reminderService->getReminder($id) ? $this->reminderService->getReminder($id)->toArray() : [];
        $tasks = $this->taskService->getAllTasks();

        $task_id = $reminder['task_id'];

        if ($task_id > 0) {
            $task = $this->taskService->getTask($task_id) ? $this->taskService->getTask($task_id)->toArray() : [];
        } else {
            $task = null;
        }

        require_once __DIR__ . '/../views/pages/reminders/AddEditReminder.php';
    }

    /**
     * Renders the reminder detail page
     * 
     * URL: /reminders/{id}
     * 
     * @param int $id The ID of the reminder to display
     * @return void
     */
    public function DetailReminderPage($id)
    {
        $this->authMiddleware->requireAuth();
        
        $title = "Detail Reminder";
        $nav_title = "Detail Reminder";
        $slug = "Let's check a reminder detail";

        $reminder = $this->reminderService->getReminder($id) ? $this->reminderService->getReminder($id)->toArray() : [];

        $task_id = $reminder['task_id'];

        if ($task_id > 0) {
            $task = $this->taskService->getTask($task_id) ? $this->taskService->getTask($task_id)->toArray() : [];
        } else {
            $task = null;
        }

        require_once __DIR__ . '/../views/pages/reminders/DetailReminder.php';
    }

    /**
     * Renders the list of all reminders page
     * 
     * URL: /reminders
     * 
     * @return void
     */
    public function ListReminderPage()
    {
        $this->authMiddleware->requireAuth();
        
        $title = "List Reminder";
        $nav_title = "List Reminder";
        $slug = "Let's check your reminders";

        $reminders = $this->reminderService->getAllReminders();

        require_once __DIR__ . '/../views/pages/reminders/ListReminder.php';
    }

    /**
     * Renders the reminder history page
     * 
     * Displays all sent reminders.
     * 
     * URL: /reminders/history
     * 
     * @return void
     */
    public function HistoryReminderPage()
    {
        $this->authMiddleware->requireAuth();
        
        $title = "History Reminder";
        $nav_title = "History Reminder";
        $slug = "Let's check your history reminders";

        $sendedReminder = $this->reminderService->getAllSendedReminders();

        require_once __DIR__ . '/../views/pages/reminders/HistoryReminder.php';
    }
}

?>