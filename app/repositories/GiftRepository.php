<?php
namespace app\repositories;

use app\models\Gift;
use PDO;

class GiftRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    
    public function findAll(): array
    {
        $sql = "SELECT id, article_id, total_quantity, donation_date, description FROM gift";
        $stmt = $this->db->query($sql);
        $gifts = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gift = new Gift($row['article_id'], (float)$row['total_quantity'], $row['donation_date']);
            $gift->setId($row['id']);
            if ($row['description']) {
                $gift->setDescription($row['description']);
            }
            $gifts[] = $gift;
        }
        
        return $gifts;
    }
}