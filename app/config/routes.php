<?php
use app\models\City;
use app\models\Gift;
use app\controllers\CityController;
use app\controllers\GiftController;
use app\repositories\CityRepository;
use app\repositories\GiftRepository;

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

    $CityController = new CityController($app, new CityRepository(Flight::db()));
    $GiftController = new GiftController($app, new GiftRepository(Flight::db()));

    $router->get('/', function() use ($app) {
        $app->render('layout.php', ['page' => 'home.php']);
    });

    $router->get('/bngrc/list-cities', [$CityController, 'showAllCities']);

    $router->get('/bngrc/list-gifts', [$GiftController, 'showAllGifts']);

}, [SecurityHeadersMiddleware::class]);