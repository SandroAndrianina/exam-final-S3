<?php
namespace app\repositories;

use app\models\Sale;


use PDO;

class SaleRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    // Insère la vente avec prix final et reduction
public function create(Sale $sale): bool
{
    $stmt = $this->db->prepare("
        INSERT INTO sale (article_id, quantity, price, date, reduction_id)
        VALUES (:article_id, :quantity, :price, :date, :reduction_id)
    ");

    return $stmt->execute([
        ':article_id'   => $sale->getArticleId(),
        ':quantity'     => $sale->getQuantity(),
        ':price'        => $sale->getPrice(),
        ':date'         => date('Y-m-d H:i:s'),
        ':reduction_id' => $sale->getReductionId()
    ]);
}

}
