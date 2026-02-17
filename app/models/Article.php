<?php

namespace app\models;


class Article
{
    private ?int $id = null;
    private string $name;
    private string $type;
    private string $unit;
    private float $unit_price = 0.0;

    public function __construct(string $name, string $type, string $unit, float $unit_price = 0.0)
    {
        $this->name = $name;
        $this->type = $type;
        $this->unit = $unit;
        $this->unit_price = $unit_price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): void
    {
        $this->unit = $unit;
    }

    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    public function setUnitPrice(float $unit_price): void
    {
        $this->unit_price = $unit_price;
    }
}
