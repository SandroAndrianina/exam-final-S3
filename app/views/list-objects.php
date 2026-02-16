<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of objects</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>

    <main>
        <h1>Liste des objets</h1>

        <section class="user-list">
    <?php if(!empty($objectsExchange)) : ?>
       <table class="object-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>ID Utilisateur</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($objectsExchange as $object) : ?>
                    <tr>
                        <td><?= htmlspecialchars($object->getId()) ?></td>
                        <td><?= htmlspecialchars($object->getName()) ?></td>
                        <td><?= htmlspecialchars($object->getIdUser()) ?></td>
                        <td><img src="<?= htmlspecialchars($object->getImage()) ?>" alt="Image de l'objet" width="100"></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun objet trouvé.</p>
    <?php endif; ?>
</section>

    </main>
    
</body>
</html>