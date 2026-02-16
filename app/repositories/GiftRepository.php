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

    public function getGiftsByNeedId(int $needId): array
    {
        $sql = "SELECT g.id, g.article_id, g.total_quantity, g.donation_date, g.description,
                   d.attributed_quantity, d.affectation_date,
                   a.name as article_name, a.unit
            FROM distribution d
            JOIN gift g ON d.gift_id = g.id
            JOIN article a ON g.article_id = a.id
            WHERE d.needs_id = :needId
            ORDER BY d.affectation_date DESC";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['needId' => $needId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}