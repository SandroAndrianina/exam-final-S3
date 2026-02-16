<?php

namespace app\repositories;

use app\models\ObjectExchange;
use PDO;

class ObjectExchangeRepository
{
    private PDO $db;
    
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    
    public function findAllObjects(): array
    {
        $sql = "SELECT id, name, id_user, image FROM object_exchange";
        $stmt = $this->db->query($sql);
        $objects = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $object = new ObjectExchange($row['name'], $row['id_user'], $row['image']);
            $object->setId($row['id']);
            $objects[] = $object;
        }
        
        return $objects;
    }
}