<?php
namespace app\repositories;

use app\models\City;
use PDO;

class CityRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    
    public function findAll(): array
    {
        $sql = "SELECT id, name FROM city";
        $stmt = $this->db->query($sql);
        $cities = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $city = new City($row['name']);
            $city->setId($row['id']);
            $cities[] = $city;
        }
        
        return $cities;
    }

        public function findById(int $id): ?City
        {
            $sql = "SELECT id, name FROM city WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$row) {
                return null;
            }
            
            $city = new City($row['name']);
            $city->setId($row['id']);
            return $city;
        }
}