<?php

class Migration
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function up(string $tabel, string $sql): void
    {
        try {
            $this->pdo->exec($sql);
            echo "✅ Table `$tabel` successfully created!\n";
        } catch (PDOException $e) {
            echo "❌ Failed to create table `$tabel`: " . $e->getMessage() . "\n";
        }
    }

    public function down(string $tabel): void
    {
        try {
            $this->pdo->exec("DROP TABLE IF EXISTS $tabel");
            echo "✅ Table `$tabel` successfully dropped!\n";
        } catch (PDOException $e) {
            echo "❌ Failed to drop table `$tabel`: " . $e->getMessage() . "\n";
        }
    }
}

?>