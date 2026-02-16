<?php
namespace app\controllers;

use app\services\DistributionService;
use app\models\Distribution;
use Exception;

use Flight;

class DistributionController
{
    protected Engine $app;
    protected DistributionRepository $DistributionRRepository;

    public function __construct(Engine $app, DistributionRepository $DistributionRepository){
        $this->app = $app;
        $this->DistributionRepository = $DistributionRepository;
    }

    public function showAllDistributions(){
        $distributions = $this->DistributionRepository->findAll();
        $this->app->render('layout.php', [
            'distributions' => $distributions,
            'errors'  => [],
            'page' => 'list-distributions.php'
        ]);
    }

    public function createDistribution() {
        $distribution = new Distribution();
        $saveDistribution =$this->DistributionRepository->save($distribution);
        Flight::redirect('/Donation-distribution.php');
    }

    
}