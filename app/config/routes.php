<?php
// use app\models\ObjectExchange;
// use app\models\User;
// use app\controllers\ObjectExchangeController;
// use app\controllers\UserController;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/**
 * @var Router $router
 * @var Engine $app
 */

$router->group('', function(Router $router) use ($app) {

    // $ObjectExchangeController = new ObjectExchangeController($app, new ObjectExchange());
    // $UserController = new UserController($app, new User());

    // $router->get('/', function() use ($app) {
    //     $app->render('layout.php', ['page' => 'home.php']);
    // });

    // $router->get('/exchange/list-objets', function() use ($app) {
    //     $app->render('layout.php', ['page' => 'list-objets.php']);
    // });

    // $router->get('/exchange/list-users', [$UserController, 'showAllUsers']);

}, [SecurityHeadersMiddleware::class]);