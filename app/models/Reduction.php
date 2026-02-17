<?php
namespace app\models;

class Reduction
{
    private int $id;
    private float $percentage;

    // public function __construct(float $percentage)
    // {
    //     $this->percentage = $percentage;
    // }

    public function __construct() {}


    // Getters
    public function getId(): int { return $this->id; }
    public function getPercentage(): float { return $this->percentage; }

    // Setter si besoin
    public function setPercentage(float $percentage): void { $this->percentage = $percentage; }
}