<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vente de dons</title>
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>

<h2>Vente d'articles</h2>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/bngrc/form-sale" method="POST">

    <!-- 🔽 Article vendable -->
    <div class="form-group">
        <label for="article">Article :</label>
        <select name="article_id" id="article" required>
            <option value="">-- Choisir un article --</option>
            <?php foreach ($articles as $article): ?>
                <option value="<?= $article['id'] ?>">
                    <?= htmlspecialchars($article['name']) ?> (<?= htmlspecialchars($article['unit']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- 🔢 Quantité -->
    <div class="form-group">
        <label for="quantity">Quantité :</label>
        <input type="number" step="0.01" name="quantity" id="quantity" placeholder="Ex: 10" required>
    </div>

    <button type="submit">Vendre l'article</button>
</form>

</body>
</html>
