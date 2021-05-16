<?php
class Database
{
    protected string $host = 'localhost';
    protected string $db = 'auth';
    protected string $username = 'amaan';
    protected string $password = 'amaan';

    protected PDO $pdo;

    protected PDOStatement $stmt;

    protected string $table;
    
    protected bool $debug = true;

    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db}";
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            if($this->debug) {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch(PDOException $e) {
            die($this->debug ? $e->getMessage() : "Some Database Issue!");
        }   
    }

    public function query(string $sql)
    {
        return $this->pdo->query($sql);
    }

    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function fetchAll(string $sql)
    {
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where(string $field, string $operator, string $value)
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$field} {$operator} :value");
        $this->stmt->execute(['value' => $value]);
        return $this;
    }

    public function get()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    public function insert($data)
    {
        $keys = array_keys($data);

        $fields = "`" . implode("`, `" , $keys) . "`";
        $placeholders = ":" . implode(", :", $keys);

        $sql = "INSERT INTO {$this->table}({$fields}) VALUES({$placeholders})";
        // die($sql);
        $this->stmt = $this->pdo->prepare($sql);
        return $this->stmt->execute($data);
    }

    public function count()
    {
        return $this->stmt->rowCount();
    }

    public function exists($data): bool
    {
        $field = array_keys($data)[0];
        return $this->where($field, "=", $data[$field])->count() ? true : false;
    }

    public function first()
    {
        return $this->get()[0];
    }

    public function deleteWhere($field, $value)
    {
        $sql = "DELETE FROM {this->table} WHERE {$field} = :value";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute(['value'=>$value]);
        return $this;
    }

}