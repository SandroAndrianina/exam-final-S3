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

        $this->app->render('layout.php', [
            'villes' => $cities,
            'errors' => [],
            'page' => 'form-distribution.php'
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
}
