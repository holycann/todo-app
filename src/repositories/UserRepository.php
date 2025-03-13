<?php

require_once __DIR__ . '/../interface/IUserRepository.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class UserRepository implements IUserRepository
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    public function create(UserModel $user): int
    {
        $query = "INSERT INTO users (fullname, email, password) 
                 VALUES (:fullname, :email, :password)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'fullname' => $user->fullname,
            'email' => $user->email,
            'password' => $user->password
        ]);
        return $this->db->lastInsertId();
    }

    public function findById(int $id): ?UserModel
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? new UserModel(...$user) : null;
    }

    public function findByEmail(string $email): ?UserModel
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? new UserModel(...$user) : null;
    }

    public function findAll(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);
        return array_map(fn($user) => new UserModel(...$user), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function update(UserModel $user): bool
    {
        $query = "UPDATE users SET 
                 fullname = :fullname, email = :email, password = :password
                 WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $user->id,
            'fullname' => $user->fullname,
            'email' => $user->email,
            'password' => password_hash($user->password, PASSWORD_BCRYPT)
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}