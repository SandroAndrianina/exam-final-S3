<?php

namespace app\repositories;

use app\models\Purchase;
use PDO;

class PurchaseRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $stmt = $this->pdo->query("
            SELECT p.*, c.name as city_name, a.name as article_name, a.unit as article_unit
            FROM purchase p
            LEFT JOIN city c ON p.city_id = c.id
            LEFT JOIN article a ON p.article_id = a.id
            ORDER BY p.purchase_date DESC, p.created_at DESC
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByCity(int $city_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name as city_name, a.name as article_name, a.unit as article_unit
            FROM purchase p
            LEFT JOIN city c ON p.city_id = c.id
            LEFT JOIN article a ON p.article_id = a.id
            WHERE p.city_id = :city_id
            ORDER BY p.purchase_date DESC, p.created_at DESC
        ");
        $stmt->execute(['city_id' => $city_id]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, c.name as city_name, a.name as article_name, a.unit as article_unit
            FROM purchase p
            LEFT JOIN city c ON p.city_id = c.id
            LEFT JOIN article a ON p.article_id = a.id
            WHERE p.id = :id
        ");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ?: null;
    }

    public function create(Purchase $purchase): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO purchase (city_id, article_id, quantity, unit_price, total_amount, purchase_date, gift_id, description)
            VALUES (:city_id, :article_id, :quantity, :unit_price, :total_amount, :purchase_date, :gift_id, :description)
        ");
        
        return $stmt->execute([
            'city_id' => $purchase->getCityId(),
            'article_id' => $purchase->getArticleId(),
            'quantity' => $purchase->getQuantity(),
            'unit_price' => $purchase->getUnitPrice(),
            'total_amount' => $purchase->getTotalAmount(),
            'purchase_date' => $purchase->getPurchaseDate(),
            'gift_id' => $purchase->getGiftId(),
            'description' => $purchase->getDescription()
        ]);
    }

    public function getTotalAmountByCity(): array
    {
        $stmt = $this->pdo->query("
            SELECT c.id, c.name, COALESCE(SUM(p.total_amount), 0) as total_amount, COUNT(p.id) as purchase_count
            FROM city c
            LEFT JOIN purchase p ON c.id = p.city_id
            GROUP BY c.id, c.name
            ORDER BY c.name
        ");
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalAmount(): float
    {
        $stmt = $this->pdo->query("SELECT COALESCE(SUM(total_amount), 0) as total FROM purchase");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (float) $result['total'];
    }

    public function getAvailableCashAmount(): float
    {
        // Total des dons en argent
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(g.total_quantity), 0) as total_cash
            FROM gift g
            LEFT JOIN article a ON g.article_id = a.id
            WHERE a.type = 'cash'
        ");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalCash = (float) $result['total_cash'];
        
        // Total des achats déjà effectués
        $totalSpent = $this->getTotalAmount();
        
        return $totalCash - $totalSpent;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM purchase WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE purchase 
            SET city_id = :city_id,
                article_id = :article_id,
                quantity = :quantity,
                unit_price = :unit_price,
                total_amount = :total_amount,
                purchase_date = :purchase_date,
                description = :description
            WHERE id = :id
        ");
        
        return $stmt->execute([
            'id' => $id,
            'city_id' => $data['city_id'],
            'article_id' => $data['article_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $data['unit_price'],
            'total_amount' => $data['total_amount'],
            'purchase_date' => $data['purchase_date'],
            'description' => $data['description']
        ]);
    }
}
