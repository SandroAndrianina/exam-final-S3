<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\NeedRepository;
use app\repositories\CityRepository;
use app\repositories\ArticleRepository;
use app\models\Need;

class NeedController
{
    protected Engine $app;
    protected NeedRepository $needRepository;
    protected CityRepository $cityRepository;
    protected ArticleRepository $articleRepository;

    public function __construct(
        Engine $app, 
        NeedRepository $needRepository,
        CityRepository $cityRepository,
        ArticleRepository $articleRepository
    ) {
        $this->app = $app;
        $this->needRepository = $needRepository;
        $this->cityRepository = $cityRepository;
        $this->articleRepository = $articleRepository;
    }



    public function showCreateForm()
    {
        $cities = $this->cityRepository->findAll();
        $articles = $this->articleRepository->findAll();
        
        $this->app->render('layout.php', [
            'villes' => $cities,
            'articles' => $articles,
            'errors' => [],
            'page' => 'form-need.php'
        ]);
    }



    public function create()
    {
        $errors = [];
        
        $city_id = (int) $this->app->request()->data->city_id ?? 0;
        $article_id = (int) $this->app->request()->data->article_id ?? 0;
        $quantity_requested = (float) $this->app->request()->data->quantity_requested ?? 0;
        $creation_date = $this->app->request()->data->creation_date ?? '';

        if ($city_id <= 0) {
            $errors[] = "Veuillez choisir une ville.";
        }
        
        if ($article_id <= 0) {
            $errors[] = "Veuillez choisir un article.";
        }
        
        if ($quantity_requested <= 0) {
            $errors[] = "La quantité doit être supérieure à 0.";
        }
        
        if (empty($creation_date)) {
            $errors[] = "La date de création est requise.";
        }

        if (!empty($errors)) {
            $cities = $this->cityRepository->findAll();
            $articles = $this->articleRepository->findAll();
            
            $this->app->render('layout.php', [
                'villes' => $cities,
                'articles' => $articles,
                'errors' => $errors,
                'page' => 'form-need.php'
            ]);
            return;
        }

        $need = new Need($city_id, $article_id, $quantity_requested, $creation_date);
        
        if ($this->needRepository->create($need)) {
            // Rediriger vers la liste des besoins
            $this->app->redirect('/bngrc/list-needs');
        } else {
            $errors[] = "Erreur lors de l'enregistrement du besoin.";
            $cities = $this->cityRepository->findAll();
            $articles = $this->articleRepository->findAll();
            
            $this->app->render('layout.php', [
                'villes' => $cities,
                'articles' => $articles,
                'errors' => $errors,
                'page' => 'form-need.php'
            ]);
        }
    }


   
    public function showList()
    {
        $needs = $this->needRepository->findAll();
        
        $this->app->render('layout.php', [
            'needs' => $needs,
            'page' => 'list-needs.php'
        ]);
    }

 

    public function delete(int $id)
    {
        if ($this->needRepository->delete($id)) {
            $this->app->redirect('/bngrc/list-needs');
        } else {
            $this->app->halt(500, 'Erreur lors de la suppression');
        }
    }

    
}
