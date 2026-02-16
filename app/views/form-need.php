<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Besoin</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    
    <h2>Formulaire : Besoin</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/bngrc/form-need" method="POST">
        
        <div class="form-group">
            <label for="ville">Ville :</label>
            <select name="city_id" id="ville" required>
                <option value="">-- Choisir une ville --</option>
                <?php foreach($villes as $ville): ?>
                    <option value="<?= $ville->getId() ?>"> 
                        <?= htmlspecialchars($ville->getName()) ?> 
                    </option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="form-group">
            <label for="article">Article demandé :</label>
            <select name="article_id" id="article" required>
                <option value="">-- Choisir un besoin --</option>
                <?php foreach ($articles as $article): ?>
                    <option value="<?= $article->getId() ?>">
                        <?= htmlspecialchars($article->getName()) ?> (<?= htmlspecialchars($article->getUnit()) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        
        <div class="form-group">
            <label for="quantite">Quantité :</label>
            <input type="number" step="0.01" name="quantity_requested" id="quantite" placeholder="Ex: 500.00" required>
        </div>

        <div class="form-group">
            <label for="date">Date de création :</label>
            <input type="date" name="creation_date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit">Enregistrer le besoin</button>
        
    </form>
    
</body>
</html>