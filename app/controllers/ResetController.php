<?php

namespace app\controllers;

use app\repositories\GiftRepository;
use app\repositories\NeedRepository;
use app\repositories\PurchaseRepository;
use Flight;
use PDO;

class ResetController
{
    private PDO $pdo;
    private GiftRepository $giftRepository;
    private NeedRepository $needRepository;
    private PurchaseRepository $purchaseRepository;

    public function __construct(
        PDO $pdo,
        GiftRepository $giftRepository,
        NeedRepository $needRepository,
        PurchaseRepository $purchaseRepository
    ) {
        $this->pdo = $pdo;
        $this->giftRepository = $giftRepository;
        $this->needRepository = $needRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function showResetPage(): void
    {
        // Compter les enregistrements
        $stats = [
            'gifts_count' => $this->countRecords('gift'),
            'needs_count' => $this->countRecords('needs'),
            'purchases_count' => $this->countRecords('purchase'),
            'distributions_count' => $this->countRecords('distribution')
        ];

        Flight::render('layout.php', [
            'page' => 'reset-data.php',
            'stats' => $stats
        ]);
    }

    public function resetAllData(): void
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Supprimer toutes les distributions (pas de "garder le premier")
            $this->pdo->exec("DELETE FROM distribution");

            // 2. Supprimer les achats sauf le premier
            $this->pdo->exec("
                DELETE FROM purchase 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM purchase
                    ) as temp
                )
            ");

            // 3. Supprimer les besoins sauf le premier
            $this->pdo->exec("
                DELETE FROM needs 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM needs
                    ) as temp
                )
            ");

            // 4. Supprimer les dons sauf le premier
            $this->pdo->exec("
                DELETE FROM gift 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM gift
                    ) as temp
                )
            ");

            $this->pdo->commit();

            Flight::redirect('/bngrc/reset?success=Données réinitialisées avec succès. Seule la première ligne de chaque table a été conservée.');
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            Flight::redirect('/bngrc/reset?error=Erreur lors de la réinitialisation : ' . $e->getMessage());
        }
    }



    public function resetGifts(): void
    {
        try {
            $this->pdo->beginTransaction();

            // Supprimer les distributions liées aux dons qui seront supprimés
            $this->pdo->exec("
                DELETE FROM distribution 
                WHERE gift_id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM gift
                    ) as temp
                )
            ");

            // Supprimer les dons sauf le premier
            $this->pdo->exec("
                DELETE FROM gift 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM gift
                    ) as temp
                )
            ");

            $this->pdo->commit();

            Flight::redirect('/bngrc/reset?success=Dons réinitialisés. Seul le premier don a été conservé.');
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            Flight::redirect('/bngrc/reset?error=Erreur : ' . $e->getMessage());
        }
    }

    public function resetNeeds(): void
    {
        try {
            $this->pdo->beginTransaction();

            // Supprimer les distributions liées aux besoins qui seront supprimés
            $this->pdo->exec("
                DELETE FROM distribution 
                WHERE needs_id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM needs
                    ) as temp
                )
            ");

            // Supprimer les besoins sauf le premier
            $this->pdo->exec("
                DELETE FROM needs 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM needs
                    ) as temp
                )
            ");

            $this->pdo->commit();

            Flight::redirect('/bngrc/reset?success=Besoins réinitialisés. Seul le premier besoin a été conservé.');
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            Flight::redirect('/bngrc/reset?error=Erreur : ' . $e->getMessage());
        }
    }

    public function resetPurchases(): void
    {
        try {
            // Supprimer les achats sauf le premier
            $this->pdo->exec("
                DELETE FROM purchase 
                WHERE id NOT IN (
                    SELECT id FROM (
                        SELECT MIN(id) as id FROM purchase
                    ) as temp
                )
            ");

            Flight::redirect('/bngrc/reset?success=Achats réinitialisés. Seul le premier achat a été conservé.');
        } catch (\Exception $e) {
            Flight::redirect('/bngrc/reset?error=Erreur : ' . $e->getMessage());
        }
    }

    
    private function countRecords(string $table): int
    {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM {$table}");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['count'];
    }
}
