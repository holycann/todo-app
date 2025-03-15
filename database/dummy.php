<?php

require __DIR__ . '/../config/env.php';
require __DIR__ . '/../src/core/DatabaseConnection.php';

try {
    // Database connection
    $pdo = DatabaseConnection::connect();

    // Cek apakah sudah ada 10 user, jika belum tambahkan
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetchColumn();

    if ($userCount < 10) {
        for ($i = $userCount + 1; $i <= 10; $i++) {
            $fullname = 'User ' . $i;
            $email = 'user' . $i . '@example.com';
            $password = password_hash('password', PASSWORD_BCRYPT);

            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$fullname, $email, $password]);
        }
        echo "Users inserted successfully!\n";
    } else {
        echo "Users already exist.\n";
    }

    // Ambil user_id yang ada untuk memastikan referensi valid
    $userIds = $pdo->query("SELECT id FROM users")->fetchAll(PDO::FETCH_COLUMN);

    // Pastikan ada user yang tersedia
    if (empty($userIds)) {
        die("No users found in the database.\n");
    }

    // Hapus semua task dan reminder sebelum insert ulang agar unik
    $pdo->exec("DELETE FROM reminders");
    $pdo->exec("DELETE FROM tasks");

    // Buat 100 task unik
    $tasks = [];
    for ($i = 1; $i <= 100; $i++) {
        $tasks[] = [
            'title' => 'Task ' . $i,
            'user_id' => $userIds[array_rand($userIds)],
            'description' => 'Description for Task ' . $i,
            'due_date' => date('Y-m-d H:i:s', strtotime('+' . rand(1, 30) . ' days')),
            'category' => ['assignments', 'discussions', 'activities', 'examinations'][rand(0, 3)],
            'priority' => ['low', 'medium', 'high'][rand(0, 2)],
            'status' => ['on-going', 'pending', 'completed'][rand(0, 2)],
        ];
    }

    foreach ($tasks as $task) {
        $stmt = $pdo->prepare("INSERT INTO tasks (title, user_id, description, due_date, category, priority, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$task['title'], $task['user_id'], $task['description'], $task['due_date'], $task['category'], $task['priority'], $task['status']]);
    }
    echo "100 unique tasks inserted successfully!\n";

    // Ambil task_id yang baru dibuat
    $taskIds = $pdo->query("SELECT id FROM tasks")->fetchAll(PDO::FETCH_COLUMN);

    // Buat 100 reminder unik
    $reminders = [];
    for ($i = 1; $i <= 100; $i++) {
        $reminders[] = [
            'task_id' => $taskIds[array_rand($taskIds)],
            'title' => 'Reminder ' . $i,
            'message' => 'Message for Reminder ' . $i,
            'status' => ['scheduled', 'sent'][rand(0, 1)],
            'is_read' => rand(0, 1),
            'sended_at' => date('Y-m-d H:i:s', strtotime('+' . rand(1, 30) . ' days')),
            'reminder_time' => date('Y-m-d H:i:s', strtotime('+' . rand(1, 30) . ' days'))
        ];
    }

    foreach ($reminders as $reminder) {
        $stmt = $pdo->prepare("INSERT INTO reminders (task_id, title, message, status, is_read, sended_at, reminder_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$reminder['task_id'], $reminder['title'], $reminder['message'], $reminder['status'], $reminder['is_read'], $reminder['sended_at'], $reminder['reminder_time']]);
    }
    echo "100 unique reminders inserted successfully!\n";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

?>