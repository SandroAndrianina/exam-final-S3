<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Distribution of donation</h2>
    <h3>Formulaire</h3>
    <form action="/bngrc/distribution" method="post">
            <label for="gift_id">Sélectionnez un don :</label>
        <select name="gift_id" id="gift_id" required>
            <?php foreach ($gifts as $gift): ?>
                <option value="<?= $gift->getId() ?>"><?= $gift->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="attributed_quantity" id="attributed_quantity" placeholder="Attributed Quantity">
        <button type="submit">Create Distribution</button>
    </form>
</body>
</html>