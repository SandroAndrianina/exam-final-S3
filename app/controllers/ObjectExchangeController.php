<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\ObjectExchangeRepository;

class ObjectExchangeController
{
    protected Engine $app;
    protected ObjectExchangeRepository $objectExchangeRepository;

    public function __construct(Engine $app, ObjectExchangeRepository $objectExchangeRepository){
        $this->app = $app;
        $this->objectExchangeRepository = $objectExchangeRepository;
    }

    public function showAllObjects(){
        $objectsExchange = $this->objectExchangeRepository->findAllObjects();

        $this->app->render('layout.php', [
            'objectsExchange' => $objectsExchange,
            'errors'  => [],
            'page' => 'list-objects.php'
        ]);
    }
   
}
