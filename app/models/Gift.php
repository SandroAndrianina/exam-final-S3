<?php
namespace app\models;

class Gift
{
    private ?int $id_gift = null;
    private int $article_id;
    private float $total_quantity;
    private string $donation_date;
    private ?string $description = null;
    private float $unit_price; // ➜ nouveau champ pour le prix unitaire

    public function __construct(int $article_id, float $total_quantity, string $donation_date, float $unit_price)
    {
        $this->article_id = $article_id;
        $this->total_quantity = $total_quantity;
        $this->donation_date = $donation_date;
        $this->unit_price = $unit_price; // initialisation du prix
    }

    // Getters
    public function getId(): ?int { return $this->id_gift; }
    public function getArticleId(): int { return $this->article_id; }
    public function getTotalQuantity(): float { return $this->total_quantity; }
    public function getDonationDate(): string { return $this->donation_date; }
    public function getDescription(): ?string { return $this->description; }
    public function getUnitPrice(): float { return $this->unit_price; } // ➜ nouveau getter

    // Setters
    public function setId(int $id): void { $this->id_gift = $id; }
    public function setArticleId(int $article_id): void { $this->article_id = $article_id; }
    public function setTotalQuantity(float $total_quantity): void { $this->total_quantity = $total_quantity; }
    public function setDonationDate(string $donation_date): void { $this->donation_date = $donation_date; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setUnitPrice(float $unit_price): void { $this->unit_price = $unit_price; } // ➜ nouveau setter
}
