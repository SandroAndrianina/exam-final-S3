<?php
namespace app\models;

class Distribution
{
    private ?int $id = null;
    private int $gift_id;
    private int $needs_id;
    private int $attributed_quantity;
    private ?string $affectation_date = null;

    public function __construct(int $gift_id, int $attributed_quantity)
    {
        $this->gift_id = $gift_id;
        $this->needs_id = $needs_id;
        $this->attributed_quantity = $attributed_quantity;
    }

    
    public function getId(): ?int { return $this->id; }
    public function getGiftId(): int { return $this->gift_id; }
    public function getNeedsId(): int { return $this->needs_id; }
    public function getAttributedQuantity(): int { return $this->attributed_quantity; }
    public function getAffectationDate(): ?string { return $this->affectation_date; }

   
    public function setGiftId(int $gift_id): void { $this->gift_id = $gift_id; }
    public function setNeedsId(int $needs_id): void { $this->needs_id = $needs_id; }
    public function setAttributedQuantity(int $attributed_quantity): void { $this->attributed_quantity = $attributed_quantity; }
    public function setAffectationDate(string $affectation_date): void { $this->affectation_date = $affectation_date; }
    public function setProductId(int $id_product): void { $this->id_product = $id_product; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }
  
    public function setId(int $id): void { $this->id = $id; }
}
