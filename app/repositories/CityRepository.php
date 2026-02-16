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
}