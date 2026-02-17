<?php
use app\models\City;
use app\models\Gift;
use app\controllers\CityController;
use app\controllers\GiftController;
use app\repositories\CityRepository;
use app\repositories\GiftRepository;
use app\controllers\NeedController;
use app\repositories\NeedRepository;
use app\repositories\ArticleRepository;
use app\controllers\NeedsGiftController;
use app\controllers\PurchaseController;
use app\controllers\DashboardController;
use app\repositories\PurchaseRepository;
use app\services\CityService;

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
    
    $PurchaseController = new PurchaseController(
        new ArticleRepository(Flight::db()),
        new CityRepository(Flight::db()),
        new PurchaseRepository(Flight::db())
    );
    
    $DashboardController = new DashboardController(
        Flight::db(),
        new NeedRepository(Flight::db()),
        new GiftRepository(Flight::db()),
        new PurchaseRepository(Flight::db())
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
    
    // Routes pour la gestion des achats
    $router->get('/bngrc/form-purchase', [$PurchaseController, 'showCreateForm']);
    $router->post('/bngrc/form-purchase', [$PurchaseController, 'create']);
    $router->get('/bngrc/list-purchases', [$PurchaseController, 'showList']);
    $router->get('/bngrc/purchases/edit/@id', [$PurchaseController, 'showEditForm']);
    $router->post('/bngrc/purchases/edit/@id', [$PurchaseController, 'update']);
    $router->get('/bngrc/purchases/delete/@id', [$PurchaseController, 'delete']);
    
    // Routes pour le tableau de bord
    $router->get('/bngrc/dashboard', [$DashboardController, 'showDashboard']);
    $router->get('/bngrc/dashboard/refresh', [$DashboardController, 'refreshData']);
    
    $router->get('/bngrc/city/@cityId/details', [$NeedsGiftController, 'showDetails']);


}, [SecurityHeadersMiddleware::class]);