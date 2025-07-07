<?php

require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../controllers/ReminderController.php';

$reminderController = new ReminderController();

Router::get('/reminders', [$reminderController, 'index']);
Router::post('/reminders', [$reminderController, 'store']);
Router::put('/reminders/read', [$reminderController, 'readAllReminder']);
Router::put('/reminders/read/{id}', [$reminderController, 'readReminder']);
Router::get('/reminders/sender', [$reminderController, 'notificationSender']);
Router::put('/reminders/{id}/status', [$reminderController, 'changeStatusReminder']);
Router::put('/reminders/{id}', [$reminderController, 'update']);
Router::delete('/reminders/{id}', [$reminderController, 'destroy']);
Router::get('/reminders/{id}', [$reminderController, 'show']);
?>