<?php
namespace app\models;

class User
{
    private ?int $id_user = null;
    private string $name;
    private string $email;
    
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }
    
    // Getters
    public function getId(): ?int { return $this->id_user; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    
    // Setters (si nécessaire)
    public function setName(string $name): void { $this->name = $name; }
    public function setEmail(string $email): void { $this->email = $email; }
    
    // L'ID est généralement setter par le repository après insertion
    public function setId(int $id): void { $this->id_user = $id; }
}