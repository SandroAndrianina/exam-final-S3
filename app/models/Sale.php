<?php
namespace app\models;

class Sale
{
    private int $id;
    private int $article_id;
    private float $quantity;
    private float $price;
    private string $date;
    private ?int $reduction_id;

    public function __construct(int $article_id, float $quantity, float $price, string $date, ?int $reduction_id = null)
    {
        $this->article_id = $article_id;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->date = $date;
        $this->reduction_id = $reduction_id;
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getArticleId(): int { return $this->article_id; }
    public function getQuantity(): float { return $this->quantity; }
    public function getPrice(): float { return $this->price; }
    public function getDate(): string { return $this->date; }
    public function getReductionId(): ?int { return $this->reduction_id; }

    // Setters si besoin
    public function setQuantity(float $quantity): void { $this->quantity = $quantity; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function setReductionId(?int $reduction_id): void { $this->reduction_id = $reduction_id; }
}