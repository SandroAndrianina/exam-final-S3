<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\GiftRepository;

class GiftController
{
    protected Engine $app;
    protected GiftRepository $giftRepository;

    public function __construct(Engine $app, GiftRepository $giftRepository){
        $this->app = $app;
        $this->giftRepository = $giftRepository;
    }

    public function showAllGifts(){
        $gifts = $this->giftRepository->findAll();
        $this->app->render('layout.php', [
            'gifts' => $gifts,
            'errors'  => [],
            'page' => 'list-gifts.php'
        ]);
    }
   
}