<?php
/**
 * User Repository Interface
 * 
 * This interface defines the contract for user repository implementations.
 * It specifies all methods that must be implemented to provide data access
 * functionality for user entities, including CRUD operations in the database.
 * 
 * Repositories implementing this interface will handle all database operations
 * for user management, isolating the database interaction from the business logic.
 */

require_once __DIR__ . '/../models/UserModel.php';

interface IUserRepository
{
    /**
     * Creates a new user in the database
     * 
     * @param UserModel $user The user model with data to insert
     * @return int The ID of the newly created user
     */
    public function create(UserModel $user): int;
    
    /**
     * Retrieves a user by their ID
     * 
     * @param int $id The ID of the user to retrieve
     * @return UserModel|null The user if found, null otherwise
     */
    public function findById(int $id): ?UserModel;
    
    /**
     * Retrieves a user by their email address
     * 
     * @param string $email The email address to search for
     * @return UserModel|null The user if found, null otherwise
     */
    public function findByEmail(string $email): ?UserModel;
    
    /**
     * Retrieves all users from the database
     * 
     * @return array Array of all users as UserModel objects
     */
    public function findAll(): array;
    
    /**
     * Updates an existing user in the database
     * 
     * @param UserModel $user The user model with updated data
     * @return bool True if update was successful, false otherwise
     */
    public function update(UserModel $user): bool;
    
    /**
     * Deletes a user from the database
     * 
     * @param int $id The ID of the user to delete
     * @return bool True if deletion was successful, false otherwise
     */
    public function delete(int $id): bool;
}