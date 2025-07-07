<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/PagesController.php';

Router::get('/', [PagesController::class, 'Index']);
Router::get('/login', [PagesController::class, 'LoginPage']);
Router::get('/register', [PagesController::class, 'RegisterPage']);
Router::get('/upcoming', [PagesController::class, 'UpcomingPage']);
Router::get('/filters', [PagesController::class, 'FilterPage']);
Router::get('/archived', [PagesController::class, 'ArchivedPage']);
Router::get('/tasks/add', [PagesController::class, 'AddTaskPage']);
Router::get('/tasks/{id}/edit', [PagesController::class, 'EditTaskPage']);
Router::get('/tasks/{id}/detail', [PagesController::class, 'DetailTask']);
Router::get('/reminders/add', [PagesController::class, 'AddReminderPage']);
Router::get('/reminders/list', [PagesController::class, 'ListReminderPage']);
Router::get('/reminders/history', [PagesController::class, 'HistoryReminderPage']);
Router::get('/reminders/{id}/edit', [PagesController::class, 'EditReminderPage']);
Router::get('/reminders/{id}/detail', [PagesController::class, 'DetailReminderPage']);
?>