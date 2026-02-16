<?php
namespace app\services;

use app\repositories\NeedRepository;
use app\repositories\GiftRepository;

class CityService
{
    private NeedRepository $needRepository;
    private GiftRepository $giftRepository;
    
    public function __construct(NeedRepository $needRepository, GiftRepository $giftRepository)
    {
        $this->needRepository = $needRepository;
        $this->giftRepository = $giftRepository;
    }
    
    public function getCityNeedsWithGifts(int $cityId): array
    {
        $needs = $this->needRepository->getNeedsByCityId($cityId);
        $result = [
            'in kind' => ['needs' => [], 'total_requested' => 0, 'total_received' => 0],
            'materials' => ['needs' => [], 'total_requested' => 0, 'total_received' => 0],
            'cash' => ['needs' => [], 'total_requested' => 0, 'total_received' => 0]
        ];
        
        foreach ($needs as $need) {
            $gifts = $this->giftRepository->getGiftsByNeedId($need['id']);
            $total_received = 0;
            
            foreach ($gifts as $gift) {
                $total_received += $gift['attributed_quantity'];
            }
            
            $needData = [
                'id' => $need['id'],
                'article_id' => $need['article_id'],
                'article_name' => $need['article_name'],
                'quantity_requested' => $need['quantity_requested'],
                'unit' => $need['unit'],
                'gifts' => $gifts,
                'total_received' => $total_received
            ];
            
            $type = $need['type'];
            $result[$type]['needs'][] = $needData;
            $result[$type]['total_requested'] += $need['quantity_requested'];
            $result[$type]['total_received'] += $total_received;
        }
        
        return $result;
    }
}