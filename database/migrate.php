<?php

require_once __DIR__ . '/../src/core/DatabaseConnection.php';
require_once __DIR__ . '/migration.php';

$pdo = DatabaseConnection::connect();
$migrate = new Migration($pdo);

$migrations = [
    'users_migration.php' => ['migrate_users_up', 'migrate_users_down'],
    'tasks_migration.php' => ['migrate_tasks_up', 'migrate_tasks_down'],
    'reminders_migration.php' => ['migrate_reminders_up', 'migrate_reminders_down']
];

$action = $argv[1] ?? 'up';

try {
    if ($action === 'up') {
        foreach ($migrations as $file => [$upFunction, $downFunction]) {
            require_once __DIR__ . "/migrations/$file";
            $upFunction($migrate);
        }
    } elseif ($action === 'down') {
        foreach (array_reverse($migrations) as $file => [$upFunction, $downFunction]) {
            require_once __DIR__ . "/migrations/$file";
            $downFunction($migrate);
        }
    }

    echo "✅ All migration successfully executed!\n";
} catch (PDOException $e) {
    die("❌ Failed to execute migration: " . $e->getMessage());
}

?>