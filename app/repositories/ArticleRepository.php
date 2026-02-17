<?php

namespace app\repositories;

use app\models\Article;
use PDO;

class ArticleRepository
{
    private PDO $db;
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }
    
    /**
     * Récupérer tous les articles
     */
    public function findAll(): array
    {
        $sql = "SELECT id, name, type, unit, unit_price FROM article ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        $articles = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row['name'], $row['type'], $row['unit'], $row['unit_price'] ?? 0.0);
            $article->setId($row['id']);
            $articles[] = $article;
        }
        
        return $articles;
    }
    
    /**
     * Trouver un article par son ID
     */
    public function findById(int $id): ?Article
    {
        $sql = "SELECT id, name, type, unit, unit_price FROM article WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            return null;
        }
        
        $article = new Article($row['name'], $row['type'], $row['unit'], $row['unit_price'] ?? 0.0);
        $article->setId($row['id']);
        
        return $article;
    }
    
    /**
     * Récupérer les articles achetables (materials et in kind, pas cash)
     */
    public function findPurchasableArticles(): array
    {
        $sql = "SELECT id, name, type, unit, unit_price FROM article WHERE type IN ('materials', 'in kind') ORDER BY name ASC";
        $stmt = $this->db->query($sql);
        $articles = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row['name'], $row['type'], $row['unit'], $row['unit_price'] ?? 0.0);
            $article->setId($row['id']);
            $articles[] = $article;
        }
        
        return $articles;
    }
}
