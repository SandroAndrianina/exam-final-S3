<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of gifts</title>
    <link rel="stylesheet" href="/assets/css/table.css">
</head>
<body>
    
    <h2>Liste des Dons</h2>
    
    <div>
        <a href="/bngrc/form-gift" class="btn btn-primary">+ Ajouter un don</a>
    </div>
    
    <?php if (empty($gifts)): ?>
        <p>Aucun don enregistré pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Date de don</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gifts as $giftData): ?>
                    <?php 
                        $gift = $giftData['gift'];
                        $article_name = $giftData['article_name'];
                        $unit = $giftData['unit'];
                    ?>
                    <tr>
                        <td><?= $gift->getId() ?></td>
                        <td><?= htmlspecialchars($article_name) ?></td>
                        <td><?= number_format($gift->getTotalQuantity(), 2) ?> <?= htmlspecialchars($unit) ?></td>
                        <td><?= date('d/m/Y', strtotime($gift->getDonationDate())) ?></td>
                        <td><?= htmlspecialchars($gift->getDescription() ?: 'Aucune description') ?></td>
                        <td>
                            <a href="/bngrc/gifts/delete/<?= $gift->getId() ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce don ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

    </main>
  
</body>
</html>