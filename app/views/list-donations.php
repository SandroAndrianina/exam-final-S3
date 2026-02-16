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
        <h1>List of donations</h1>

        <section class="donations-list">
    <?php if(!empty($cities)) : ?>
        <?php $longueur = count($cities); 
        for($i = 0; $i < $longueur; $i++) { 
            $p = $cities[$i]; ?>
            <div class="product-item">
                <h4>
                        <?php echo $p['name']; ?>
                </h4>
            </div>
        <?php } ?>
    <?php else : ?>
        <p>No city found.</p>
    <?php endif; ?>
</section>

    </main>
  
</body>
</html>