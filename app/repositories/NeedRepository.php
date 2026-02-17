<?php

namespace app\repositories;

use app\models\Need;
use PDO;

class NeedRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    
   

    public function findAll(): array
    {
        $sql = "SELECT n.id, n.city_id, n.article_id, n.quantity_requested, n.creation_date,
                       c.name as city_name, a.name as article_name, a.unit
                FROM needs n
                JOIN city c ON n.city_id = c.id
                JOIN article a ON n.article_id = a.id
                ORDER BY n.creation_date DESC";
        
        $stmt = $this->db->query($sql);
        $needs = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $need = new Need(
                $row['city_id'],
                $row['article_id'],
                $row['quantity_requested'],
                $row['creation_date']
            );
            $need->setId($row['id']);
            $needs[] = [
                'need' => $need,
                'city_name' => $row['city_name'],
                'article_name' => $row['article_name'],
                'unit' => $row['unit']
            ];
        }
        
        return $needs;
    }

    public function findById(int $id): ?Need
    {
        $sql = "SELECT id, city_id, article_id, quantity_requested, creation_date 
                FROM needs WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            return null;
        }
        
        $need = new Need(
            $row['city_id'],
            $row['article_id'],
            $row['quantity_requested'],
            $row['creation_date']
        );
        $need->setId($row['id']);
        
        return $need;
    }
    
    public function create(Need $need): bool
    {
        $sql = "INSERT INTO needs (city_id, article_id, quantity_requested, creation_date) 
                VALUES (:city_id, :article_id, :quantity_requested, :creation_date)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'city_id' => $need->getCityId(),
            'article_id' => $need->getArticleId(),
            'quantity_requested' => $need->getQuantityRequested(),
            'creation_date' => $need->getCreationDate()
        ]);
    }
    
    public function update(Need $need): bool
    {
        $sql = "UPDATE needs 
                SET city_id = :city_id, 
                    article_id = :article_id, 
                    quantity_requested = :quantity_requested, 
                    creation_date = :creation_date
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'id' => $need->getId(),
            'city_id' => $need->getCityId(),
            'article_id' => $need->getArticleId(),
            'quantity_requested' => $need->getQuantityRequested(),
            'creation_date' => $need->getCreationDate()
        ]);
    }
    
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM needs WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute(['id' => $id]);
    }

    public function getNeedsByCityId(int $cityId): array
    {
        $sql = "SELECT n.id, n.city_id, n.article_id, n.quantity_requested, n.creation_date,
                    a.name as article_name, a.type, a.unit
                FROM needs n
                JOIN article a ON n.article_id = a.id
                WHERE n.city_id = :cityId
                ORDER BY a.type, a.name";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['cityId' => $cityId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findByCityWithRemainingQuantity($city_id)
{
    $sql = "
        SELECT 
            n.id,
            a.name AS article_name,
            a.unit,
            (n.quantity_requested - 
             IFNULL(SUM(d.attributed_quantity),0)) AS remaining_quantity
        FROM needs n
        JOIN article a ON n.article_id = a.id
        LEFT JOIN distribution d ON d.needs_id = n.id
        WHERE n.city_id = ?
        GROUP BY n.id
        HAVING remaining_quantity > 0
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$city_id]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getRemainingQuantity($needs_id)
{
    $sql = "
        SELECT n.quantity_requested - IFNULL(SUM(d.attributed_quantity),0) AS remaining
        FROM needs n
        LEFT JOIN distribution d ON n.id = d.needs_id
        WHERE n.id = ?
        GROUP BY n.id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$needs_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? (float)$result['remaining'] : 0;
}




}
