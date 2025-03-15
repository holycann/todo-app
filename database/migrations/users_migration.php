<?php

require_once __DIR__ . '/../migration.php';

function migrate_users_up(Migration $migration)
{
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=INNODB;
    SQL;

    $migration->up("users", $sql);
}

function migrate_users_down(Migration $migration)
{
    $migration->down("users");
}

?>
