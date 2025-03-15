<?php
/**
 * User Model
 * 
 * This class represents a user entity in the Todo application.
 * It encapsulates all the data related to a user account and provides
 * methods for manipulating this data.
 */
class UserModel
{
    /**
     * Unique identifier for the user
     * @var int|null
     */
    public ?int $id;
    
    /**
     * Full name of the user
     * @var string
     */
    public string $fullname;
    
    /**
     * Email address of the user (used for login)
     * @var string
     */
    public string $email;
    
    /**
     * Password hash for user authentication
     * @var string
     */
    public string $password;
    
    /**
     * Timestamp when the user account was created
     * @var string|null
     */
    public ?string $created_at;

    /**
     * Constructor for creating a new UserModel instance
     *
     * @param int|null $id User ID (null for new users)
     * @param string $fullname User's full name
     * @param string $email User's email address
     * @param string $password User's password (should be hashed before storage)
     * @param string|null $created_at Creation timestamp
     */
    public function __construct(
        ?int $id,
        string $fullname,
        string $email,
        string $password,
        ?string $created_at
    ) {
        $this->id = $id;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
    }
}

?>