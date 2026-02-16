<?php
use app\models\ObjectExchange;
use app\models\User;
use app\controllers\ObjectExchangeController;
use app\controllers\UserController;
use app\repositories\UserRepository;
use \app\repositories\ObjectExchangeRepository;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

    $ObjectExchangeController = new ObjectExchangeController($app, new ObjectExchangeRepository(Flight::db()));
    $UserController = new UserController($app, new UserRepository(Flight::db()));

    $router->get('/', function() use ($app) {
        $app->render('layout.php', ['page' => 'home.php']);
    });


    $router->get('/exchange/list-objets', [$ObjectExchangeController, 'showAllObjects']);

    $router->get('/exchange/list-users', [$UserController, 'showAllUsers']);

}, [SecurityHeadersMiddleware::class]);