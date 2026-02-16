<?php
namespace app\repositories;

use app\models\DistributionModel;
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
            $distribution = new DistributionModel($row['gift_id'], $row['needs_id'], $row['attributed_quantity']);
            $distribution->setId($row['id']);
            $distribution->setAffectationDate($row['affectation_date']);
            $distributions[] = $distribution;
        }
        
        return $distributions;
    }
}