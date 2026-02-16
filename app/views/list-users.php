<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of users</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    
    <main>
        <h1>Liste des utilisateurs</h1>

        <section class="user-list">
    <?php if(!empty($users)) : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getId()) ?></td>
                        <td><?= htmlspecialchars($user->getName()) ?></td>
                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>Aucun utilisateur trouvé.</p>
    <?php endif; ?>
</section>

    </main>
  
</body>
</html>