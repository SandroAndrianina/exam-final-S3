<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\CityRepository;

class CityController
{
    protected Engine $app;
    protected CityRepository $CityRepository;

    public function __construct(Engine $app, CityRepository $CityRepository){
        $this->app = $app;
        $this->CityRepository = $CityRepository;
    }

    public function showAllCities(){
        $cities = $this->CityRepository->findAll();
        $this->app->render('layout.php', [
            'cities' => $cities,
            'errors'  => [],
            'page' => 'list-cities.php'
        ]);
    }
   
}
