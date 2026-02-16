<?php
use app\models\City;
use app\controllers\CityController;
use app\repositories\CityRepository;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

    // $ObjectExchangeController = new ObjectExchangeController($app, new ObjectExchangeRepository(Flight::db()));
    $CityController = new CityController($app, new CityRepository(Flight::db()));

    $router->get('/', function() use ($app) {
        $app->render('layout.php', ['page' => 'home.php']);
    });

    // $router->get('/exchange/list-objets', [$ObjectExchangeController, 'showAllObjects']);

    $router->get('/bngrc/list-cities', [$CityController, 'showAllCities']);

    $router->post('/bngrc/distribution', [$DistributionController, '']);

}, [SecurityHeadersMiddleware::class]);