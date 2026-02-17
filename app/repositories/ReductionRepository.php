<?php
namespace app\repositories;

use PDO;

class ReductionRepository 
{
    private PDO $db;

    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    

    // Récupère une réduction par ID
    public function findById(int $id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM reduction WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findFirst()
{
    $stmt = $this->db->query("
        SELECT * FROM reduction 
        ORDER BY id ASC 
        LIMIT 1
    ");

    $stmt->setFetchMode(\PDO::FETCH_CLASS, \app\models\Reduction::class);

    return $stmt->fetch();
}

}