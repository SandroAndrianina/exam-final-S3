<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of objects by user</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
   

    <main>
        <h1>Liste des objets de l'utilisateur</h1>

        <section class="user-list">
    <?php if(!empty($produits)) : ?>
        <?php $longueur = count($produits); 
        for($i = 0; $i < $longueur; $i++) { 
            $p = $produits[$i]; ?>
            <div class="product-item">
                <h4>
                   <a href="/produits/<?php echo $p['id']; ?>">
                        <?php echo $p['name']; ?>
                    </a>
                </h4>
            </div>
        <?php } ?>
    <?php else : ?>
        <p>Aucun objet trouvé.</p>
    <?php endif; ?>
</section>

    </main>
    
</body>
</html>