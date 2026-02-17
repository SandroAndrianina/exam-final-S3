<?php
use app\repositories\CityRepository;
use flight\Engine;

$city = new CityRepository(Flight::db());
$name_city = $city->findById($cityId);
if (!$name_city) {
    echo "Ville non trouvée.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails besoins et dons - Ville <?php echo $cityId; ?></title>
    <link rel="stylesheet" href="/assets/css/details-needs-gifts.css">
</head>
<body>
    
    <main>
        <h1>Détails besoins et dons - Ville :<?php echo $name_city->getName(); ?></h1>

        <section class="details-section">
            
            <?php 
            $categories = [
                'in kind' => 'Nature',
                'materials' => 'Matériaux', 
                'cash' => 'Argent'
            ];
            
            foreach($categories as $type => $typeLabel): 
                $data = $needsGifts[$type] ?? null;
                if(empty($data['needs'])) continue;
            ?>
                
                <h2><?php echo $typeLabel; ?></h2>
                
                <table class="details-table">
                    <thead>
                        <tr>
                            <th>Besoins</th>
                            <th>Dons reçus</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php foreach($data['needs'] as $need): ?>
                            <tr>
                                <td>
                                    <strong><?php echo $need['article_name']; ?></strong><br>
                                    <small>Demandé: <?php echo $need['quantity_requested'] . ' ' . $need['unit']; ?></small>
                                </td>
                                <td>
                                    <?php if(!empty($need['gifts'])): ?>
                                        <?php foreach($need['gifts'] as $gift): ?>
                                            <div>
                                                <?php echo $gift['attributed_quantity'] . ' ' . $gift['unit']; ?>
                                                <small>(don du <?php echo $gift['donation_date']; ?>)</small>
                                            </div>
                                        <?php endforeach; ?>
                                        <strong>Total reçu: <?php echo $need['total_received'] . ' ' . $need['unit']; ?></strong>
                                    <?php else: ?>
                                        <em>Aucun don reçu</em>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <!-- Ligne de sous-total pour la catégorie -->
                        <tr class="category-total">
                            <td><strong>Total <?php echo strtolower($typeLabel); ?></strong></td>
                            <td>
                                <strong>Demandé: <?php echo $data['total_requested']; ?> | Reçu: <?php echo $data['total_received']; ?></strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            <?php endforeach; ?>
            
            <?php 
            // Vérifier si aucune donnée n'a été affichée
            $hasData = false;
            foreach($needsGifts as $type => $data) {
                if(!empty($data['needs'])) {
                    $hasData = true;
                    break;
                }
            }
            
            if(!$hasData): 
            ?>
                <p>Aucun besoin trouvé pour cette ville.</p>
            <?php endif; ?>
            
        </section>
    </main>
  
</body>
</html>