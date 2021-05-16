<?php
class Auth
{
    protected Database $database;
    protected UserHelper $userHelper;
    protected string $table = 'users';
    protected TokenHandler $tokenHandler;
    protected $sessionKey = 'user';

    public function __construct(Database $database,UserHelper $userHelper, TokenHandler $tokenHandler)
    {
        $this->database = $database;   
        $this->userHelper = $userHelper;
        $this->tokenHandler = $tokenHandler;
    }

    public function build()
    {
        return $this->database->query("CREATE TABLE IF NOT EXISTS {$this->table} (id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, username VARCHAR(255) UNIQUE , email VARCHAR(255) NOT NULL UNIQUE, password VARCHAR(255) NOT NULL )");
    }

    public function create($data)
    {
        if($data['password']){
            $data['password'] = Hash::make($data['password']);
        }
        return $this->database  
                    ->table($this->table)
                    ->insert($data);
    }

    public function user(): ?object
    {
        if(!$this->check()) {
            return null;
        }
        $user = $this->database->table($this->table)
                     ->where('id', '=', $_SESSION[$this->sessionKey])
                     ->first();
        return $user;
    }

    public function signin($username , $password): bool
    {
        $userQuery = $this->database
                          ->table($this->table)
                          ->where('username', '=', $username);  
        if($userQuery->count()){
            $user = $userQuery->first();
                        
            if(Hash::verify($password,$user->password)){
                //Set the session
                $this->setAuthSession($user->id);
                return true;
            }
        }
        return false;
    }
    public function signout()
    {
        if($this->check()){
            $this->unsetAuthSession();
        }
    }
    
    public function check(): bool
    {
        if(isset($_COOKIE['token']) && $this->tokenHandler->isValid($_COOKIE['token'],1)){
            $userId = $this->userHelper
                           ->findUserByToken($_COOKIE['token'])
                           ->id;
            $this->setAuthSession($userId); 
        }
        return isset($_SESSION[$this->sessionKey]);
    }

    public function updatePassword(int $userId, string $newPassword): bool
    {
        $password = Hash::make($newPassword);
        $sql = "UPDATE users SET password = '$password' WHERE id = $userId";
        return $this->database->query($sql) ? true : false;
    }

    protected function setAuthSession(int $id){
        $_SESSION[$this->sessionKey] = $id;
    }

    protected function unsetAuthSession(){
        unset($_SESSION[$this->sessionKey]);
    }
}