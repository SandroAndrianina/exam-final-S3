<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of </title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.html" class="logo">E-Takalo</a>
                <!-- <ul class="menu">
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="list-users.html">Liste des utilisateurs</a></li>
                </ul> -->
            </nav>
        </div>
    </header>

    <main>
        <h1>Liste des propositions</h1>

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
        <p>Aucune proposition trouvée.</p>
    <?php endif; ?>
</section>

    </main>
    <footer>
        <p>&copy; 2025 E-Takalo</p>
    </footer>
</body>
</html>