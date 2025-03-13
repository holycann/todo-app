<?php

class UserModel
{
    public ?int $id;
    public string $fullname;
    public string $email;
    public string $password;
    public ?string $created_at;

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