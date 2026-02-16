<?php

namespace app\controllers;

use flight\Engine;
use app\services\CityService;

class NeedsGiftController
{
    protected Engine $app;
    protected CityService $cityService;

    public function __construct(Engine $app, CityService $cityService){
        $this->app = $app;
        $this->cityService = $cityService;
    }

    public function showDetails(int $cityId){
        $cityNeedsWithGifts = $this->cityService->getCityNeedsWithGifts($cityId);
        
        $this->app->render('layout.php', [
            'cityId' => $cityId,
            'needsGifts' => $cityNeedsWithGifts,
            'errors'  => [],
            'page' => 'details-needs-gift.php'
        ]);
    }
}