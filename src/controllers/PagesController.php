<?php

class PagesController
{
    private UserService $userService;
    private TaskService $taskService;
    private ReminderService $reminderService;
    public function __construct()
    {
        $this->userService = new UserService();
        $this->taskService = new TaskService();
        $this->reminderService = new ReminderService();
    }
    public function Index()
    {
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_token'])) {
            header("Location: " . BASE_ENDPOINT . "/login");
            exit;
        }

        $user_id = 0;

        if (isset($_SESSION["user_id"])) {
            $user_id = $_SESSION['user_id'];
        } else if (isset($_COOKIE["user_token"])) {
            $user_id = base64_decode($_COOKIE['user_token']);
        }

        $user_id = (int) $user_id;
        $user = $this->userService->getUserById($user_id);

        if (!$user) {
            session_unset();
            session_destroy();
            setcookie("user_token", "", time() - 3600, "/");

            header("Location: " . BASE_ENDPOINT . "/login");
            exit;
        }

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
    public function LoginPage()
    {
        if (isset($_SESSION['user_id']) || isset($_COOKIE['user_token'])) {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : base64_decode($_COOKIE['user_token']);
            $user = $this->userService->getUserById((int) $user_id);

            if (!$user) {
                session_unset();
                session_destroy();
                setcookie("user_token", "", time() - 3600, "/");
            } else {
                header("Location: " . BASE_ENDPOINT . "/");
                exit;
            }
        }

        $title = "Login";
        require_once __DIR__ . '/../views/pages/auth/LoginPage.php';
    }
    public function RegisterPage()
    {
        if (isset($_SESSION['user_id'])) {
            header("Location: " . BASE_ENDPOINT . "/");
        }

        if (isset($_COOKIE['user_token'])) {
            $user_id = base64_decode($_COOKIE['user_token']);
            $user = $this->userService->getUserById($user_id);

            if ($user) {
                $_SESSION['user_id'] = $user->id;
                header("Location: " . BASE_ENDPOINT . "/");
            } else {
                setcookie("user_token", "", time() - 3600, "/");
            }
        }

        $title = "Register";
        require_once __DIR__ . '/../views/pages/auth/RegisterPage.php';
    }

    public function ArchivedPage()
    {
        $title = "Archived";
        $nav_title = "Archived";
        $slug = "Let's check your archived tasks";

        $completedTasks = $this->taskService->getFilteredTasks(['status' => 'completed']);

        require_once __DIR__ . '/../views/pages/ArchivedPage.php';
    }

    public function FilterPage()
    {
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
        $nav_title = "Filter Task";
        $slug = "Let's check your filtered tasks";

        require_once __DIR__ . '/../views/pages/FilterPage.php';
    }

    public function UpcomingPage()
    {
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
    public function DetailTask($id)
    {
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_token'])) {
            header("Location: " . BASE_ENDPOINT . "/login");
            exit;
        }

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
    
    public function AddTaskPage()
    {
        $title = "Add Task";
        $nav_title = "Add Task";
        $slug = "Let's add a new task";
        require_once __DIR__ . '/../views/pages/tasks/AddEditTask.php';
    }

    public function EditTaskPage($id)
    {
        $title = "Edit Task";
        $nav_title = "Edit Task";
        $slug = "Let's edit a task";

        $task = $this->taskService->getTask($id) ? $this->taskService->getTask($id)->toArray() : [];
        $reminder = $this->reminderService->getByTaskId($id) ? $this->reminderService->getByTaskId($id)->toArray() : [];

        require_once __DIR__ . '/../views/pages/tasks/AddEditTask.php';
    }

    public function AddReminderPage()
    {
        $title = "Add Reminder";
        $nav_title = "Add Reminder";
        $slug = "Let's add a new reminder";

        $tasks = $this->taskService->getAllTasks();

        require_once __DIR__ . '/../views/pages/reminders/AddEditReminder.php';
    }

    public function EditReminderPage($id)
    {
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

    public function DetailReminderPage($id)
    {
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

    public function ListReminderPage()
    {
        $title = "List Reminder";
        $nav_title = "List Reminder";
        $slug = "Let's check your reminders";

        $reminders = $this->reminderService->getAllReminders();

        require_once __DIR__ . '/../views/pages/reminders/ListReminder.php';
    }

    public function HistoryReminderPage()
    {
        $title = "History Reminder";
        $nav_title = "History Reminder";
        $slug = "Let's check your history reminders";

        $sendedReminder = $this->reminderService->getAllSendedReminders();

        require_once __DIR__ . '/../views/pages/reminders/HistoryReminder.php';
    }
}

?>