<?php
namespace app\controllers;

use app\models\Sale;
use app\models\Reduction;
use app\services\GiftService;
use app\services\SaleService;
use app\repositories\SaleRepository;
use app\repositories\ReductionRepository;

class SaleController
{
    private $app;
    private SaleRepository $saleRepository;
    private GiftService $giftService;
    private SaleService $saleService;
    private ReductionRepository $reductionRepository;

    public function __construct($app, SaleRepository $saleRepo, GiftService $giftService, SaleService $saleService, ReductionRepository $reductionRepo)
    {
        $this->app = $app;
        $this->saleRepository = $saleRepo;
        $this->giftService = $giftService;
        $this->saleService = $saleService;
        $this->reductionRepository = $reductionRepo;
    }

    // Affiche le formulaire avec les articles vendables
    public function showForm()
    {
        $articles = $this->giftService->getEnableArticle();
        $this->app->render('layout.php', [
            'articles' => $articles,
            'errors' => [],
            'page' => 'form-sale.php'
        ]);
    }

    // Sauvegarde la vente après validation et calcul du prix
public function saveSale()
{
    $errors = [];

    $article_id = $_POST['article_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;

    if (!$article_id || !$quantity) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    if ($quantity <= 0) {
        $errors[] = "La quantité doit être supérieure à 0.";
    }

    if (!empty($errors)) {
        $articles = $this->giftService->getEnableArticle();
        return $this->app->render('layout.php', [
            'articles' => $articles,
            'errors' => $errors,
            'page' => 'form-sale.php'
        ]);
    }

    // 🔹 Récupérer l’article pour avoir le vrai prix unitaire
    $article = $this->giftService->getArticleById($article_id);
    $unitPrice = $article->getUnitPrice();

    // 🔹 Calcul du prix final avec réduction automatique
    $finalData = $this->saleService
        ->calculPriceWithReduction((float)$unitPrice, (float)$quantity);

    $sale = new Sale(
        (int)$article_id,
        (float)$quantity,
        (float)$finalData['price'],
        date('Y-m-d H:i:s'),
        $finalData['reduction_id']
    );

    $this->saleRepository->create($sale);

    header("Location: /");
    exit;
}

}
