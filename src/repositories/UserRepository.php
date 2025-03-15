<?php
/**
 * User Repository
 * 
 * This class implements the IUserRepository interface and handles all database
 * operations related to user entities, including CRUD operations.
 * 
 * The repository acts as a data access layer, isolating the application's business 
 * logic from direct database interactions. It converts database results into UserModel 
 * objects and handles database-specific implementation details.
 */

require_once __DIR__ . '/../interface/IUserRepository.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../core/DatabaseConnection.php';

class UserRepository implements IUserRepository
{
    /**
     * PDO database connection instance
     * @var PDO
     */
    private $db;

    /**
     * Constructor - initializes the database connection
     */
    public function __construct()
    {
        $this->db = DatabaseConnection::connect();
    }

    /**
     * Creates a new user in the database
     * 
     * @param UserModel $user The user model with data to insert
     * @return int The ID of the newly created user
     */
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

    /**
     * Retrieves a user by their ID
     * 
     * @param int $id The ID of the user to retrieve
     * @return UserModel|null The user if found, null otherwise
     */
    public function findById(int $id): ?UserModel
    {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? new UserModel(...$user) : null;
    }

    /**
     * Retrieves a user by their email address
     * 
     * This method is particularly useful for authentication processes
     * where users typically log in with their email.
     * 
     * @param string $email The email address to search for
     * @return UserModel|null The user if found, null otherwise
     */
    public function findByEmail(string $email): ?UserModel
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? new UserModel(...$user) : null;
    }

    /**
     * Retrieves all users from the database
     * 
     * @return array Array of UserModel objects
     */
    public function findAll(): array
    {
        $query = "SELECT * FROM users";
        $stmt = $this->db->query($query);
        return array_map(fn($user) => new UserModel(...$user), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /**
     * Updates an existing user in the database
     * 
     * @param UserModel $user The user model with updated data
     * @return bool True if update was successful, false otherwise
     */
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

    /**
     * Deletes a user from the database
     * 
     * @param int $id The ID of the user to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}