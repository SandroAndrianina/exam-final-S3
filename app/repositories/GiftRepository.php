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

    public function findAvailableByArticleFIFO($article_id)
    {
        $sql = "
            SELECT g.id,
                g.total_quantity - IFNULL(SUM(d.attributed_quantity),0) AS remaining_quantity
            FROM gift g
            LEFT JOIN distribution d ON g.id = d.gift_id
            WHERE g.article_id = ?
            GROUP BY g.id
            HAVING remaining_quantity > 0
            ORDER BY g.donation_date ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$article_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}