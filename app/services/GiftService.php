<?php
namespace app\services;

use app\repositories\GiftRepository;

class GiftService
{
    private GiftRepository $giftRepository;

    public function __construct(GiftRepository $giftRepository)
    {
        $this->giftRepository = $giftRepository;
    }

    // Appelle findEnableArticle pour récupérer uniquement les articles vendables
    public function getEnableArticle(): array
    {
        return $this->giftRepository->findEnableArticle();
    }

    public function getArticleById(int $id)
{
    // Appelle le repository pour récupérer l'article exact
    return $this->giftRepository->findById($id);
}

}