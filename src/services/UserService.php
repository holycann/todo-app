<?php
/**
 * User Service
 * 
 * This service implements the IUserService interface and contains all the business logic
 * for user management, including registration, authentication, and user retrieval operations.
 * 
 * The service acts as an intermediary between controllers and repositories,
 * enforcing business rules and data integrity for user-related operations.
 */

require_once __DIR__ . '/../interface/IUserService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserService implements IUserService
{
    /**
     * Repository for user data access operations
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * Constructor - initializes the user repository
     */
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Registers a new user in the system
     * 
     * This method validates user data, hashes the password for security,
     * and creates a new user record in the database.
     *
     * @param UserModel $user The user model containing registration data
     * @return int The ID of the newly registered user
     * @throws InvalidArgumentException If email format is invalid
     * @throws Error If the email is already registered
     */
    public function registerUser(UserModel $user): int
    {
        // Validate email format
        if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }

        // Check if email is already registered
        if ($this->userRepository->findByEmail($user->email)) {
            throw new Error('Email already registered');
        }

        // Hash the password for security
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        
        // Create the user in the database and return the ID
        return $this->userRepository->create($user);
    }

    /**
     * Retrieves a user by their ID
     *
     * @param int $id The ID of the user to retrieve
     * @return UserModel|null The user if found, null otherwise
     * @throws InvalidArgumentException If ID is invalid
     */
    public function getUserById(int $id): ?UserModel
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid user ID');
        }
        return $this->userRepository->findById($id);
    }

    /**
     * Retrieves a user by their email address
     * 
     * This method is commonly used during authentication to verify credentials.
     *
     * @param string $email The email address to search for
     * @return UserModel|null The user if found, null otherwise
     * @throws InvalidArgumentException If email format is invalid
     */
    public function getUserByEmail(string $email): ?UserModel
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email format');
        }
        return $this->userRepository->findByEmail($email);
    }

    /**
     * Retrieves all users from the database
     *
     * @return array Array of all users
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}