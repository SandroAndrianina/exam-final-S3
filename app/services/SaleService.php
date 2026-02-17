<?php
namespace app\services;

use app\repositories\ReductionRepository;

class SaleService
{
    private ReductionRepository $reductionRepository;

    public function __construct(ReductionRepository $reductionRepository)
    {
        $this->reductionRepository = $reductionRepository;
    }

    // Calcule le prix final avec réduction
    public function calculPriceWithReduction(float $unitPrice, float $quantity): array
    {
        $reduction = $this->reductionRepository->findFirst(); // première réduction
        $percentage = $reduction ? $reduction->getPercentage() : 0;

        $priceFinal = $unitPrice * $quantity * (1 - $percentage / 100);

        return [
            'price' => $priceFinal,
            'reduction_id' => $reduction ? $reduction->getId() : null
        ];
    }
}
