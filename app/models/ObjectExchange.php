<?php

namespace app\models;

class ObjectExchange
{
    private ?int $id = null;
    private string $name;
    private int $id_user;
    private ?string $image = null;
    
    public function __construct(string $name, int $id_user, ?string $image = null)
    {
        $this->setName($name);
        $this->setIdUser($id_user);
        $this->setImage($image);
    }
    
    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function getIdUser(): int
    {
        return $this->id_user;
    }
    
    public function getImage(): ?string
    {
        return $this->image;
    }
    
    // Setters avec validation
    public function setName(string $name): self
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide");
        }
        $this->name = $name;
        return $this;
    }
    
    public function setIdUser(int $id_user): self
    {
        if ($id_user <= 0) {
            throw new \InvalidArgumentException("ID utilisateur invalide");
        }
        $this->id_user = $id_user;
        return $this;
    }
    
    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }
    
    // Méthode utilitaire (optionnelle)
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
    
    // Pour conversion en tableau (utile pour JSON)
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'id_user' => $this->id_user,
            'image' => $this->image
        ];
    }
}