<?php

require_once __DIR__ . '/../migration.php';

function migrate_reminders_up(Migration $migration)
{
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS reminders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title varchar(255) NOT NULL,
        message text NOT NULL,
        task_id INT NULL,
        reminder_time DATETIME NOT NULL,
        status enum('scheduled', 'sent') NOT NULL DEFAULT 'scheduled',
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        sended_at TIMESTAMP NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP NULL,
    FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE SET NULL
    ) ENGINE=INNODB;
    SQL;

    $migration->up("reminders", $sql);
}

function migrate_reminders_down(Migration $migration)
{
    $migration->down("reminders");
}

?>