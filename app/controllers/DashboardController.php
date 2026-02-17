<?php

namespace app\controllers;

use app\repositories\NeedRepository;
use app\repositories\GiftRepository;
use app\repositories\PurchaseRepository;
use Flight;
use PDO;

class DashboardController
{
    private PDO $pdo;
    private NeedRepository $needRepository;
    private GiftRepository $giftRepository;
    private PurchaseRepository $purchaseRepository;

    public function __construct(
        PDO $pdo,
        NeedRepository $needRepository,
        GiftRepository $giftRepository,
        PurchaseRepository $purchaseRepository
    ) {
        $this->pdo = $pdo;
        $this->needRepository = $needRepository;
        $this->giftRepository = $giftRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function showDashboard(): void
    {
        $stats = $this->getStatistics();
        $purchasesByCity = $this->purchaseRepository->getTotalAmountByCity();
        
        Flight::render('dashboard.php', [
            'stats' => $stats,
            'purchasesByCity' => $purchasesByCity
        ], 'content');
        Flight::render('layout.php');
    }

    public function refreshData(): void
    {
        $stats = $this->getStatistics();
        $purchasesByCity = $this->purchaseRepository->getTotalAmountByCity();
        
        Flight::json([
            'stats' => $stats,
            'purchasesByCity' => $purchasesByCity
        ]);
    }

    private function getStatistics(): array
    {
        // Total des besoins (en montant)
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(n.amount * a.unit_price), 0) as total_needs_amount
            FROM needs n
            LEFT JOIN article a ON n.article_id = a.id
        ");
        $totalNeedsAmount = (float) $stmt->fetch(PDO::FETCH_ASSOC)['total_needs_amount'];

        // Besoins satisfaits (en montant) - basé sur la table distribution
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(d.amount * a.unit_price), 0) as satisfied_needs_amount
            FROM distribution d
            LEFT JOIN article a ON d.article_id = a.id
        ");
        $satisfiedNeedsAmount = (float) $stmt->fetch(PDO::FETCH_ASSOC)['satisfied_needs_amount'];

        // Total des dons reçus (en montant équivalent)
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(
                CASE 
                    WHEN a.type = 'cash' THEN g.amount
                    ELSE g.amount * a.unit_price
                END
            ), 0) as total_gifts_amount
            FROM gift g
            LEFT JOIN article a ON g.article_id = a.id
        ");
        $totalGiftsAmount = (float) $stmt->fetch(PDO::FETCH_ASSOC)['total_gifts_amount'];

        // Dons dispatchés (en montant) - basé sur la table distribution
        $stmt = $this->pdo->query("
            SELECT COALESCE(SUM(d.amount * a.unit_price), 0) as dispatched_amount
            FROM distribution d
            LEFT JOIN article a ON d.article_id = a.id
        ");
        $dispatchedAmount = (float) $stmt->fetch(PDO::FETCH_ASSOC)['dispatched_amount'];

        // Argent disponible pour achats
        $availableCash = $this->purchaseRepository->getAvailableCashAmount();

        // Total des achats effectués
        $totalPurchases = $this->purchaseRepository->getTotalAmount();

        return [
            'total_needs_amount' => $totalNeedsAmount,
            'satisfied_needs_amount' => $satisfiedNeedsAmount,
            'total_gifts_amount' => $totalGiftsAmount,
            'dispatched_amount' => $dispatchedAmount,
            'available_cash' => $availableCash,
            'total_purchases' => $totalPurchases,
            'satisfaction_rate' => $totalNeedsAmount > 0 ? ($satisfiedNeedsAmount / $totalNeedsAmount) * 100 : 0
        ];
    }
}
