<?php

namespace app\models;

class Need
{
    private ?int $id = null;
    private int $city_id;
    private int $article_id;
    private float $quantity_requested;
    private string $creation_date;

    public function __construct(int $city_id, int $article_id, float $quantity_requested, string $creation_date)
    {
        $this->city_id = $city_id;
        $this->article_id = $article_id;
        $this->quantity_requested = $quantity_requested;
        $this->creation_date = $creation_date;
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

    public function getQuantityRequested(): float
    {
        return $this->quantity_requested;
    }

    public function setQuantityRequested(float $quantity_requested): void
    {
        $this->quantity_requested = $quantity_requested;
    }

    public function getCreationDate(): string
    {
        return $this->creation_date;
    }

    public function setCreationDate(string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }
}
