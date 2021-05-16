<?php
class UserHelper
{
    private Database $database;
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function findUserByEmail(string $email): ?object
    {
        return $this->database
                    ->table('users')
                    -> where('email', '=', $email)
                    ->first();
    }
    public function findUserByUsername(string $username): ?object
    {
        return $this->database
                    ->table('users')
                    -> where('username', '=', $username)
                    ->first();
    }
    public function findUserByToken(string $token): ?object
    {
        $tokenObject = $this->database
                            ->table('tokens')
                            -> where('token', '=', $token)
                            ->first();

        return $this->database->table('users')      
                              ->where('id', '=', $tokenObject->user_id)
                              ->first();
    }
}
?>