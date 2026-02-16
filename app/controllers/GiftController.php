<?php

namespace app\controllers;

use flight\Engine;
use app\repositories\GiftRepository;
use app\repositories\ArticleRepository;
use app\models\Gift;

class GiftController
{
    protected Engine $app;
    protected GiftRepository $giftRepository;
    protected ArticleRepository $articleRepository;

    public function __construct(
        Engine $app, 
        GiftRepository $giftRepository,
        ArticleRepository $articleRepository
    ) {
        $this->app = $app;
        $this->giftRepository = $giftRepository;
        $this->articleRepository = $articleRepository;
    }

    

    public function showCreateForm()
    {
        $articles = $this->articleRepository->findAll();
        
        $this->app->render('layout.php', [
            'articles' => $articles,
            'errors' => [],
            'page' => 'form-gift.php'
        ]);
    }



    public function create()
    {
        $errors = [];
        
        $article_id = (int) $this->app->request()->data->article_id ?? 0;
        $total_quantity = (float) $this->app->request()->data->total_quantity ?? 0;
        $donation_date = $this->app->request()->data->donation_date ?? '';
        $description = $this->app->request()->data->description ?? null;

        if ($article_id <= 0) {
            $errors[] = "Veuillez choisir un article.";
        }
        
        if ($total_quantity <= 0) {
            $errors[] = "La quantité doit être supérieure à 0.";
        }
        
        if (empty($donation_date)) {
            $errors[] = "La date de don est requise.";
        }

        // Si erreurs, réafficher le formulaire avec les erreurs
        if (!empty($errors)) {
            $articles = $this->articleRepository->findAll();
            
            $this->app->render('layout.php', [
                'articles' => $articles,
                'errors' => $errors,
                'page' => 'form-gift.php'
            ]);
            return;
        }

        // Créer le don
        $gift = new Gift($article_id, $total_quantity, $donation_date);
        if ($description) {
            $gift->setDescription($description);
        }
        
        if ($this->giftRepository->create($gift)) {
            // Rediriger vers la liste des dons
            $this->app->redirect('/bngrc/list-gifts');
        } else {
            $errors[] = "Erreur lors de l'enregistrement du don.";
            $articles = $this->articleRepository->findAll();
            
            $this->app->render('layout.php', [
                'articles' => $articles,
                'errors' => $errors,
                'page' => 'form-gift.php'
            ]);
        }
    }

    

    public function showAllGifts()
    {
        $gifts = $this->giftRepository->findAll();
        
        $this->app->render('layout.php', [
            'gifts' => $gifts,
            'errors' => [],
            'page' => 'list-gifts.php'
        ]);
    }

    
    
    public function delete(int $id)
    {
        if ($this->giftRepository->delete($id)) {
            $this->app->redirect('/bngrc/list-gifts');
        } else {
            $this->app->halt(500, 'Erreur lors de la suppression');
        }
    }
}