<?php
namespace app\repositories;

use app\models\Distribution;
use PDO;

class DistributionRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    
    public function findAll(): array
    {
        $sql = "SELECT id, gift_id, needs_id, attributed_quantity, affectation_date FROM distribution";
        $stmt = $this->db->query($sql);
        $distributions = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $distribution = new Distribution($row['gift_id'], $row['needs_id'], $row['attributed_quantity']);
            $distribution->setId($row['id']);
            $distribution->setAffectationDate($row['affectation_date']);
            $distributions[] = $distribution;
        }
        return $distributions;
    }


    public function save(Distribution $distribution): void
    {
        if ($distribution->getId() === null) {
            $sql = "INSERT INTO distribution (gift_id, needs_id, attributed_quantity, affectation_date) VALUES (:gift_id, :needs_id, :attributed_quantity, :affectation_date)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                'gift_id' => $distribution->getGiftId(),
                'needs_id' => $distribution->getNeedsId(),
                'attributed_quantity' => $distribution->getAttributedQuantity(),
                'affectation_date' => $distribution->getAffectationDate()
            ]);
            $distribution->setId((int)$this->db->lastInsertId());
        } 
    }

    public function getNamebyId (String $name) : int {
        $sql = "SELECT * FROM distribution d JOIN gift g ON d.gift_id = g.id 
        JOIN article a ON g.article_id = a.id WHERE a.name = :name";
         $stmt->execute();
          $stmt->bindValue(':name', $name, PDO::PARAM_STR);
           $result = $stmt->fetch(PDO::FETCH_ASSOC);
             return $result['id'] ?? 0;
    }

}