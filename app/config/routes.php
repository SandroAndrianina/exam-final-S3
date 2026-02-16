<?php
use app\models\City;
use app\controllers\CityController;
use app\controllers\NeedController;
use app\repositories\CityRepository;
use app\repositories\NeedRepository;
use app\repositories\ArticleRepository;
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
    $NeedController = new NeedController(
        $app, 
        new NeedRepository(Flight::db()),
        new CityRepository(Flight::db()),
        new ArticleRepository(Flight::db())
    );

    $router->get('/', function() use ($app) {
        $app->render('layout.php', ['page' => 'home.php']);
    });

    // $router->get('/exchange/list-objets', [$ObjectExchangeController, 'showAllObjects']);

    $router->get('/bngrc/list-cities', [$CityController, 'showAllCities']);

    // Routes pour la gestion des besoins
    $router->get('/bngrc/form-need', [$NeedController, 'showCreateForm']);
    $router->post('/bngrc/form-need', [$NeedController, 'create']);
    $router->get('/bngrc/list-needs', [$NeedController, 'showList']);
    $router->get('/bngrc/needs/delete/@id', [$NeedController, 'delete']);

}, [SecurityHeadersMiddleware::class]);