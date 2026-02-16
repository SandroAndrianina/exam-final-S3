<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Besoins</title>
    <link rel="stylesheet" href="/assets/styles.css">

</head>
<body>
    
    <h2>Liste des Besoins</h2>
    
    <div>
        <a href="/bngrc/form-need" class="btn btn-primary">+ Ajouter un besoin</a>
    </div>
    
    <?php if (empty($needs)): ?>
        <p>Aucun besoin enregistré pour le moment.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ville</th>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Date de création</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($needs as $needData): ?>
                    <?php 
                        $need = $needData['need'];
                        $city_name = $needData['city_name'];
                        $article_name = $needData['article_name'];
                        $unit = $needData['unit'];
                    ?>
                    <tr>
                        <td><?= $need->getId() ?></td>
                        <td><?= htmlspecialchars($city_name) ?></td>
                        <td><?= htmlspecialchars($article_name) ?></td>
                        <td><?= number_format($need->getQuantityRequested(), 2) ?> <?= htmlspecialchars($unit) ?></td>
                        <td><?= date('d/m/Y', strtotime($need->getCreationDate())) ?></td>
                        <td>
                            <a href="/bngrc/needs/delete/<?= $need->getId() ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin ?')">
                                Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
</body>
</html>
