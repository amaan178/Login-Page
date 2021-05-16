<?php
class TokenHandler
{
    public const REMEMBER_ME_EXPIRY_TIME = '30 minutes';

    protected const FORGOT_PASSWORD_EXPIRY_TIME = '10 minutes';

    private string $table = 'tokens';

    private const CREATE_QUERY = "CREATE TABLE IF NOT EXISTS tokens (id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT, user_id INT UNSIGNED, token VARCHAR(255) UNIQUE, expires_at DATETIME NOT NULL, is_remember TINYINT DEFAULT 0)";

    private Database $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function build()
    {
        $this->database->query(TokenHandler::CREATE_QUERY);
    }

    public function getValidExistingToken(int $userId, int $isRemember): ?array
    {
        $sql = "SELECT * FROM $this->table WHERE user_id = $userId AND expires_at >= NOW() AND is_remember =  $isRemember";
        $data = $this->database->fetchAll($sql);
        return $data == null ? null : $data[0];
    }
    
    public function isValid(string $token, int $isRemember): bool
    {
        $current = date('Y-m-d H:i:s');
        $sql = "SELECT * FROM $this->table WHERE token = '$token' AND expires_at >= '$current' AND is_remember = $isRemember";
        return ! empty($this->database->fetchAll($sql));
    }

    public function createRememberMeToken(int $userId) 
    {
        return $this->createToken($userId, 1);
    }

    protected function createToken(int $userId, int $isRemember): ?array
    {
        $validToken = $this->getValidExistingToken($userId, $isRemember);
        if($validToken) {
            return $validToken;
        }

        $current = date('Y-m-d H:i:s');
        $timeToBeAdded = $isRemember ? TokenHandler::REMEMBER_ME_EXPIRY_TIME : TokenHandler::FORGOT_PASSWORD_EXPIRY_TIME;
        $data = [
            'user_id' => $userId,
            'token' => Hash::generateToken($userId),
            'expires_at' => date('Y-m-d H:i:s', strtotime($current . "+" .  $timeToBeAdded)),
            'is_remember' => $isRemember
        ];

        return $this->database
                    ->table($this->table)
                    ->insert($data) ? $data : null;
    }

    public function deleteTokenByToken(string $token): bool
    {
        $sql = "DELETE FROM $this->table WHERE token = '$token'";
        return $this->database->query($sql) ? true : false;
    }

    public function createForgotPasswordToken(int $userId)
    {
        return $this->createToken($userId, 0);
    }

    public function deleteToken(int $userId, int $isRemember): bool
    {
        $sql = "DELETE FROM $this->table WHERE user_id = $userId AND is_remember = $isRemember";
        return $this->database->query($sql) ? true : false;
    }
}
?>