<?php
namespace app\repositories;

use app\models\User;
use PDO;

class UserRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) // Injection de dépendance
    {
        $this->db = $db;
    }
    
    public function findAllUsers(): array
    {
        $sql = "SELECT id_user, name, email FROM user";
        $stmt = $this->db->query($sql);
        $users = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new User($row['name'], $row['email']);
            $user->setId($row['id_user']);
            $users[] = $user;
        }
        
        return $users;
    }
}