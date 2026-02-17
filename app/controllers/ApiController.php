<?php

namespace app\controllers;

use PDO;
use Flight;

class ApiController
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Retourne les statistiques par ville pour la carte interactive
     */
    public function getCitiesStats(): void
    {
        try {
            // Récupérer toutes les villes avec leurs statistiques
            $sql = "
                SELECT 
                    c.id,
                    c.name,
                    (SELECT COUNT(*) FROM needs WHERE city_id = c.id) as needs_count,
                    (SELECT COUNT(*) FROM purchase WHERE city_id = c.id) as purchases_count,
                    (SELECT COUNT(DISTINCT d.id) 
                     FROM distribution d 
                     JOIN needs n ON d.needs_id = n.id 
                     WHERE n.city_id = c.id) as distributions_count,
                    (SELECT SUM(n.quantity_requested * a.unit_price) 
                     FROM needs n 
                     JOIN article a ON n.article_id = a.id 
                     WHERE n.city_id = c.id) as total_needs_amount,
                    (SELECT SUM(p.total_price) 
                     FROM purchase p 
                     WHERE p.city_id = c.id) as total_purchases_amount
                FROM city c
                ORDER BY c.name
            ";
            
            $stmt = $this->pdo->query($sql);
            $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Formater les données pour JavaScript
            $result = [];
            foreach ($cities as $city) {
                $result[$city['name']] = [
                    'id' => (int)$city['id'],
                    'name' => $city['name'],
                    'needs' => (int)$city['needs_count'],
                    'purchases' => (int)$city['purchases_count'],
                    'distributions' => (int)$city['distributions_count'],
                    'total_needs' => number_format((float)($city['total_needs_amount'] ?? 0), 2, '.', ''),
                    'total_purchases' => number_format((float)($city['total_purchases_amount'] ?? 0), 2, '.', '')
                ];
            }
            
            // Retourner en JSON
            header('Content-Type: application/json');
            echo json_encode($result);
            
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode([
                'error' => 'Erreur lors de la récupération des données',
                'message' => $e->getMessage()
            ]);
        }
    }
    
    /**
     * Retourne les détails d'une ville spécifique
     */
    public function getCityDetails(int $cityId): void
    {
        try {
            // Informations de base
            $cityStmt = $this->pdo->prepare("SELECT * FROM city WHERE id = ?");
            $cityStmt->execute([$cityId]);
            $city = $cityStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$city) {
                header('Content-Type: application/json', true, 404);
                echo json_encode(['error' => 'Ville non trouvée']);
                return;
            }
            
            // Besoins
            $needsStmt = $this->pdo->prepare("
                SELECT n.*, a.name as article_name, a.unit, a.unit_price
                FROM needs n
                JOIN article a ON n.article_id = a.id
                WHERE n.city_id = ?
                ORDER BY n.request_date DESC
            ");
            $needsStmt->execute([$cityId]);
            $needs = $needsStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Achats
            $purchasesStmt = $this->pdo->prepare("
                SELECT p.*, a.name as article_name, a.unit
                FROM purchase p
                JOIN article a ON p.article_id = a.id
                WHERE p.city_id = ?
                ORDER BY p.purchase_date DESC
            ");
            $purchasesStmt->execute([$cityId]);
            $purchases = $purchasesStmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Distributions
            $distStmt = $this->pdo->prepare("
                SELECT d.*, 
                       n.description as need_description,
                       a.name as article_name,
                       g.donation_date
                FROM distribution d
                JOIN needs n ON d.needs_id = n.id
                JOIN gift g ON d.gift_id = g.id
                JOIN article a ON n.article_id = a.id
                WHERE n.city_id = ?
                ORDER BY g.donation_date DESC
            ");
            $distStmt->execute([$cityId]);
            $distributions = $distStmt->fetchAll(PDO::FETCH_ASSOC);
            
            $result = [
                'city' => $city,
                'needs' => $needs,
                'purchases' => $purchases,
                'distributions' => $distributions,
                'stats' => [
                    'needs_count' => count($needs),
                    'purchases_count' => count($purchases),
                    'distributions_count' => count($distributions)
                ]
            ];
            
            header('Content-Type: application/json');
            echo json_encode($result);
            
        } catch (\Exception $e) {
            header('Content-Type: application/json', true, 500);
            echo json_encode([
                'error' => 'Erreur lors de la récupération des détails',
                'message' => $e->getMessage()
            ]);
        }
    }
}
