<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\UserRepository;

class UserController
{
    protected Engine $app;
    protected UserRepository $userRepository;

    public function __construct(Engine $app, UserRepository $userRepository){
        $this->app = $app;
        $this->userRepository = $userRepository;
    }

    public function showAllUsers(){
        $users = $this->userRepository->findAllUsers();
        $this->app->render('layout.php', [
            'users' => $users,
            'errors'  => [],
            'page' => 'list-users.php'
        ]);
    }
   
}
