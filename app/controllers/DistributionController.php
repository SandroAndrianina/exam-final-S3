<?php
namespace app\controllers;


use app\models\Distribution;
use app\repositories\DistributionRepository;
use flight\Engine;



class DistributionController
{
    protected $app;
    protected $cityRepository;
    protected $needsRepository;
    protected $giftRepository;
    protected $distributionRepository;

    public function __construct($app, $cityRepository, $needsRepository, $giftRepository, $distributionRepository)
    {
        $this->app = $app;
        $this->cityRepository = $cityRepository;
        $this->needsRepository = $needsRepository;
        $this->giftRepository = $giftRepository;
        $this->distributionRepository = $distributionRepository;
    }

    
    public function showCreateForm()
    {
        $cities = $this->cityRepository->findAll();
        $nonce = $this->app->get('csp_nonce');  // ← ajoute cette ligne

        $this->app->render('layout.php', [
            'villes' => $cities,
            'errors' => [],
            'page'   => 'form-distribution.php',
            'nonce'  => $nonce  // ← passe-le ici
        ]);
    }

    
        public function getNeedsByCity($city_id)
        {
        
            $needs = $this->needsRepository->findByCityWithRemainingQuantity($city_id);

            // Retour JSON
            header('Content-Type: application/json');
            echo json_encode($needs);
            exit;
        }

        public function create()
    {
        $errors = [];

        // 1️⃣ Récupération inputs
        $city_id = $_POST['city_id'] ?? null;
        $needs_id = $_POST['needs_id'] ?? null;
        $quantity = $_POST['quantity'] ?? null;
        $date = $_POST['affectation_date'] ?? null;

        // 2️⃣ VALIDATIONS SIMPLES
        if (!$city_id || !$needs_id || !$quantity || !$date) {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if ($quantity <= 0) {
            $errors[] = "La quantité doit être supérieure à 0.";
        }

        if (!strtotime($date)) {
            $errors[] = "Date invalide.";
        }

        // 3️⃣ VALIDATIONS MÉTIER
        $need = $this->needsRepository->findById($needs_id);
        if (!$need) {
            $errors[] = "Le besoin n'existe pas.";
        } elseif ($need->getCityId() != $city_id) {
            $errors[] = "Ce besoin n'appartient pas à cette ville.";
        }

        $remainingNeed = $this->needsRepository->getRemainingQuantity($needs_id);
        if ($quantity > $remainingNeed) {
            $errors[] = "La quantité dépasse le besoin restant.";
        }

        // 4️⃣ Gifts disponibles (FIFO)
        $gifts = $this->giftRepository->findAvailableByArticleFIFO($need->getArticleId());
        $totalStock = array_sum(array_column($gifts, 'remaining_quantity'));

        if ($quantity > $totalStock) {
            $errors[] = "Stock insuffisant : la quantité demandée dépasse les dons disponibles.";
        }

        // ❌ S’il y a des erreurs → recharger formulaire
        if (!empty($errors)) {
            $cities = $this->cityRepository->findAll();
            $nonce = $this->app->get('csp_nonce');  // ← ajoute cette ligne
            $this->app->render('layout.php', [
                'villes' => $cities,
                'errors' => $errors,
                'page' => 'form-distribution.php',
                'nonce'  => $nonce  // ← passe-le ici
            ]);
            return;
        }

        // 5️⃣ Distribution automatique
        $remainingToDistribute = $quantity;
        $distributions = [];

        foreach ($gifts as $gift) {
            if ($remainingToDistribute <= 0) break;

            $available = $gift['remaining_quantity'];
            if ($available <= 0) continue;

            $taken = min($available, $remainingToDistribute);
            $distributions[] = [
                'gift_id' => $gift['id'],
                'needs_id' => $needs_id,
                'quantity' => $taken,
                'date' => $date
            ];
            $remainingToDistribute -= $taken;
        }

        // 6️⃣ Appel Repository
        $this->distributionRepository->createMultiple($distributions);

        // ✅ Redirection vers home si succès
        $this->app->redirect('/');
    }


}
