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
        $sql = "SELECT g.id, g.article_id, g.total_quantity, g.donation_date, g.description,
                       a.name as article_name, a.unit
                FROM gift g
                JOIN article a ON g.article_id = a.id
                ORDER BY g.donation_date ASC";
        
        $stmt = $this->db->query($sql);
        $gifts = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gift = new Gift($row['article_id'], (float)$row['total_quantity'], $row['donation_date']);
            $gift->setId($row['id']);
            if ($row['description']) {
                $gift->setDescription($row['description']);
            }
            $gifts[] = [
                'gift' => $gift,
                'article_name' => $row['article_name'],
                'unit' => $row['unit']
            ];
        }
        
        return $gifts;
    }
    


    public function findById(int $id): ?Gift
    {
        $sql = "SELECT id, article_id, total_quantity, donation_date, description 
                FROM gift WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            return null;
        }
        
        $gift = new Gift($row['article_id'], (float)$row['total_quantity'], $row['donation_date']);
        $gift->setId($row['id']);
        if ($row['description']) {
            $gift->setDescription($row['description']);
        }
        
        return $gift;
    }
    
    

    public function create(Gift $gift): bool
    {
        $sql = "INSERT INTO gift (article_id, total_quantity, donation_date, description) 
                VALUES (:article_id, :total_quantity, :donation_date, :description)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'article_id' => $gift->getArticleId(),
            'total_quantity' => $gift->getTotalQuantity(),
            'donation_date' => $gift->getDonationDate(),
            'description' => $gift->getDescription()
        ]);
    }
    
    

    public function update(Gift $gift): bool
    {
        $sql = "UPDATE gift 
                SET article_id = :article_id, 
                    total_quantity = :total_quantity, 
                    donation_date = :donation_date,
                    description = :description
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'id' => $gift->getId(),
            'article_id' => $gift->getArticleId(),
            'total_quantity' => $gift->getTotalQuantity(),
            'donation_date' => $gift->getDonationDate(),
            'description' => $gift->getDescription()
        ]);
    }
    

    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM gift WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
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