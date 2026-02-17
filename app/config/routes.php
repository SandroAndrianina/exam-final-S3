<?php
use app\models\City;
use app\models\Gift;
use app\models\Distribution;

use app\controllers\CityController;
use app\controllers\GiftController;
use app\controllers\NeedController;
use app\controllers\DistributionController;

use app\repositories\CityRepository;
use app\repositories\GiftRepository;
use app\repositories\NeedRepository;
use app\repositories\ArticleRepository;
use app\controllers\NeedsGiftController;
use app\services\CityService;
use app\repositories\DistributionRepository;

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

    $CityController = new CityController($app, new CityRepository(Flight::db()));
    $GiftController = new GiftController(
        $app, 
        new GiftRepository(Flight::db()),
        new ArticleRepository(Flight::db())
    );
    $NeedController = new NeedController(
        $app, 
        new NeedRepository(Flight::db()),
        new CityRepository(Flight::db()),
        new ArticleRepository(Flight::db())
    );
    
    $NeedsGiftController = new NeedsGiftController(
        $app, 
        new CityService(
            new NeedRepository(Flight::db()), 
            new GiftRepository(Flight::db())
        )
    );

    $DistributionController = new DistributionController(
    $app,
    new CityRepository(Flight::db()),
    new NeedRepository(Flight::db()),
    new GiftRepository(Flight::db()),
    new DistributionRepository(Flight::db())
);

    $router->get('/', function() use ($app) {
        $app->render('layout.php', ['page' => 'home.php']);
    });

   

    $router->get('/bngrc/list-cities', [$CityController, 'showAllCities']);

    // Routes pour la gestion des dons
    $router->get('/bngrc/form-gift', [$GiftController, 'showCreateForm']);
    $router->post('/bngrc/form-gift', [$GiftController, 'create']);
    $router->get('/bngrc/list-gifts', [$GiftController, 'showAllGifts']);
    $router->get('/bngrc/gifts/delete/@id', [$GiftController, 'delete']);

    // Routes pour la gestion des besoins
    $router->get('/bngrc/form-need', [$NeedController, 'showCreateForm']);
    $router->post('/bngrc/form-need', [$NeedController, 'create']);
    $router->get('/bngrc/list-needs', [$NeedController, 'showList']);
    $router->get('/bngrc/needs/delete/@id', [$NeedController, 'delete']);
    $router->get('/bngrc/city/@cityId/details', [$NeedsGiftController, 'showDetails']);


    // Affichage formulaire (GET)
$router->get('/bngrc/form-distribution', [$DistributionController, 'showCreateForm']);
$router->post('/bngrc/distribution/create', [$DistributionController, 'create']);

// AJAX : besoins par ville (GET)
$router->get('/bngrc/needs/by-city/@city_id', [$DistributionController, 'getNeedsByCity']);


}, [SecurityHeadersMiddleware::class]);