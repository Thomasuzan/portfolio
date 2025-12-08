<?php

namespace Models;
use App\Model;
use PDO;

class User extends Model
{
    
    public function __construct()
    {
        $this->table = "users";
        $this->getConnection();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $q = $this->connection->prepare($sql);
        $q->execute(['email' => $email]);
        return $q->fetch(PDO::FETCH_ASSOC);
    }
}
