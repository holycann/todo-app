<?php
/**
 * User Service Interface
 * 
 * This interface defines the contract for user service implementations.
 * It specifies all methods that must be implemented to provide user management functionality,
 * including registration, retrieval, and authentication functionality.
 * 
 * Services implementing this interface will contain the business logic for user-related
 * operations, separating it from the data access layer (repositories).
 */

require_once __DIR__ . '/../models/UserModel.php';

interface IUserService
{
    /**
     * Registers a new user in the system
     * 
     * This method should validate user data, ensure email uniqueness,
     * hash passwords, and create the user record in the database.
     * 
     * @param UserModel $user The user model with registration data
     * @return int The ID of the newly registered user
     */
    public function registerUser(UserModel $user): int;
    
    /**
     * Retrieves a user by their ID
     * 
     * @param int $id The ID of the user to retrieve
     * @return UserModel|null The user if found, null otherwise
     */
    public function getUserById(int $id): ?UserModel;
    
    /**
     * Retrieves a user by their email address
     * 
     * This is commonly used during login to find and authenticate a user.
     * 
     * @param string $email The email address to search for
     * @return UserModel|null The user if found, null otherwise
     */
    public function getUserByEmail(string $email): ?UserModel;
    
    /**
     * Retrieves all users in the system
     * 
     * @return array Array of all users as UserModel objects
     */
    public function getAllUsers(): array;
}