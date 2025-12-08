<?php

namespace Models;
use App\Model;
use PDO;

class Message extends Model
{
    protected $db;

    public function __construct()
    {
        $this->table = "messages";
        $this->db = $this->getConnection();
    }

    public function saveMessage($name, $email, $message, $filePath = null)
    {
        $q = $this->db->prepare("INSERT INTO messages (name, email, message, file_path, created_at) VALUES (:name, :email, :message, :file_path, NOW())");
        $q->execute([
            'name' => htmlspecialchars($name),
            'email' => htmlspecialchars($email),
            'message' => htmlspecialchars($message),
            'file_path' => $filePath ?: null,
        ]);
    }
    public function getMessages()
    {
        $q = $this->db->query("SELECT * FROM messages ORDER BY created_at DESC");
        return $q->fetchAll(PDO::FETCH_ASSOC);
    }
}
