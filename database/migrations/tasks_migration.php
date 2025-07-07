<?php

require_once __DIR__ . '/../migration.php';

function migrate_tasks_up(Migration $migration)
{
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        description text NOT NULL,
        due_date DATETIME NOT NULL,
        category ENUM('assignments', 'discussions', 'activities', 'examinations') NOT NULL,
        priority ENUM('low', 'medium', 'high') DEFAULT NULL,
        status ENUM('on-going', 'pending', 'completed') DEFAULT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=INNODB;
    SQL;

    $migration->up("tasks", $sql);
}

function migrate_tasks_down(Migration $migration)
{
    $migration->down("tasks");
}

?>