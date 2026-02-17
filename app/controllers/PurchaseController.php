<?php

namespace app\controllers;

use app\models\Purchase;
use app\repositories\ArticleRepository;
use app\repositories\CityRepository;
use app\repositories\PurchaseRepository;
use Flight;

class PurchaseController
{
    private ArticleRepository $articleRepository;
    private CityRepository $cityRepository;
    private PurchaseRepository $purchaseRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        CityRepository $cityRepository,
        PurchaseRepository $purchaseRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->cityRepository = $cityRepository;
        $this->purchaseRepository = $purchaseRepository;
    }

    public function showCreateForm(): void
    {
        $villes = $this->cityRepository->findAll();
        $articles = $this->articleRepository->findPurchasableArticles();
        $availableCash = $this->purchaseRepository->getAvailableCashAmount();
        
        Flight::render('layout.php', [
            'page' => 'form-purchase.php',
            'villes' => $villes,
            'articles' => $articles,
            'availableCash' => $availableCash
        ]);
    }

    public function create(): void
    {
        $city_id = Flight::request()->data->city_id ?? null;
        $article_id = Flight::request()->data->article_id ?? null;
        $quantity = Flight::request()->data->quantity ?? null;
        $purchase_date = Flight::request()->data->purchase_date ?? date('Y-m-d');
        $description = Flight::request()->data->description ?? null;

        // Validation
        if (empty($city_id) || empty($article_id) || empty($quantity)) {
            Flight::redirect('/bngrc/form-purchase?error=Tous les champs sont obligatoires');
            return;
        }

        // Récupérer l'article pour avoir le prix unitaire
        $article = $this->articleRepository->findById((int)$article_id);
        if (!$article) {
            Flight::redirect('/bngrc/form-purchase?error=Article introuvable');
            return;
        }

        $unit_price = $article->getUnitPrice();
        $quantity = (float)$quantity;
        $total_amount = $unit_price * $quantity;

        // Vérifier qu'il y a assez d'argent disponible
        $availableCash = $this->purchaseRepository->getAvailableCashAmount();
        if ($total_amount > $availableCash) {
            Flight::redirect('/bngrc/form-purchase?error=Montant insuffisant. Disponible: ' . number_format($availableCash, 2) . ' Ar');
            return;
        }

        // Créer l'achat
        $purchase = new Purchase(
            (int)$city_id,
            (int)$article_id,
            $quantity,
            $unit_price,
            $total_amount,
            $purchase_date,
            null,
            $description
        );

        $success = $this->purchaseRepository->create($purchase);

        if ($success) {
            Flight::redirect('/bngrc/list-purchases?success=Achat enregistré avec succès');
        } else {
            Flight::redirect('/bngrc/form-purchase?error=Erreur lors de l\'enregistrement');
        }
    }

    public function showList(): void
    {
        $city_filter = Flight::request()->query->city_id ?? null;
        
        if ($city_filter) {
            $purchases = $this->purchaseRepository->findByCity((int)$city_filter);
        } else {
            $purchases = $this->purchaseRepository->findAll();
        }
        
        $villes = $this->cityRepository->findAll();
        $availableCash = $this->purchaseRepository->getAvailableCashAmount();
        
        Flight::render('layout.php', [
            'page' => 'list-purchases.php',
            'purchases' => $purchases,
            'villes' => $villes,
            'city_filter' => $city_filter,
            'availableCash' => $availableCash
        ]);
    }
}
