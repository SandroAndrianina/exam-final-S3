<?php
namespace app\models;

class City
{
    private ?int $id_city = null;
    private string $name;
    
    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    // Getters
    public function getId(): ?int { return $this->id_user; }
    public function getName(): string { return $this->name; }
    
    // Setters (si nécessaire)
    public function setName(string $name): void { $this->name = $name; }
    
    // L'ID est généralement setter par le repository après insertion
    public function setId(int $id): void { $this->id_user = $id; }
}