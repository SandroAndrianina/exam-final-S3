<?php

namespace app\models;

class Purchase
{
    private ?int $id = null;
    private int $city_id;
    private int $article_id;
    private float $quantity;
    private float $unit_price;
    private float $total_amount;
    private string $purchase_date;
    private ?int $gift_id = null;
    private ?string $description = null;

    public function __construct(
        int $city_id,
        int $article_id,
        float $quantity,
        float $unit_price,
        float $total_amount,
        string $purchase_date,
        ?int $gift_id = null,
        ?string $description = null
    ) {
        $this->city_id = $city_id;
        $this->article_id = $article_id;
        $this->quantity = $quantity;
        $this->unit_price = $unit_price;
        $this->total_amount = $total_amount;
        $this->purchase_date = $purchase_date;
        $this->gift_id = $gift_id;
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getCityId(): int
    {
        return $this->city_id;
    }

    public function setCityId(int $city_id): void
    {
        $this->city_id = $city_id;
    }

    public function getArticleId(): int
    {
        return $this->article_id;
    }

    public function setArticleId(int $article_id): void
    {
        $this->article_id = $article_id;
    }

    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }

    public function getTotalAmount(): float
    {
        return $this->total_amount;
    }

    public function setTotalAmount(float $total_amount): void
    {
        $this->total_amount = $total_amount;
    }

    public function getPurchaseDate(): string
    {
        return $this->purchase_date;
    }

    public function setPurchaseDate(string $purchase_date): void
    {
        $this->purchase_date = $purchase_date;
    }

    public function getGiftId(): ?int
    {
        return $this->gift_id;
    }

    public function setGiftId(?int $gift_id): void
    {
        $this->gift_id = $gift_id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}
