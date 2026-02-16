<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Don</title>
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
    <h2>Formulaire : Don</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <form action="/bngrc/form-gift" method="POST">
        
        <div class="form-group">
            <label for="article">Article à donner :</label>
            <select name="article_id" id="article" required>
                <option value="">-- Choisir un article --</option>
                <?php foreach ($articles as $article): ?>
                    <option value="<?= $article->getId() ?>">
                        <?= htmlspecialchars($article->getName()) ?> (<?= htmlspecialchars($article->getUnit()) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="quantite">Quantité totale :</label>
            <input type="number" step="0.01" name="total_quantity" id="quantite" placeholder="Ex: 500.00" required>
        </div>

        <div class="form-group">
            <label for="date">Date de don :</label>
            <input type="date" name="donation_date" id="date" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description (optionnelle) :</label>
            <textarea name="description" id="description" rows="4" placeholder="Informations supplémentaires sur le don..."></textarea>
        </div>

        <button type="submit">Enregistrer le don</button>
        
    </form>
</body>
</html>