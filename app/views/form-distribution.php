<?php
if (!isset($villes)) {
    die("Erreur : \$villes n'existe pas dans form-distribution.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Distribution</title>
     <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>

<h2>Distribution de donation</h2>

<form action="/bngrc/distribution/create" method="post">

    <!-- 🔽 Ville -->
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

    <!-- 🔽 Besoin (chargé dynamiquement) -->
    <div class="form-group">
        <label for="needs">Besoin (Article de la ville) :</label>
        <select name="needs_id" id="needs" required>
            <option value="">-- Choisir d'abord une ville --</option>
        </select>
    </div>

    <!-- 🔢 Quantité -->
    <div class="form-group">
        <label for="quantite">Quantité :</label>
        <input type="number" 
               step="0.01" 
               name="quantity" 
               id="quantite" 
               placeholder="Ex: 500.00" 
               required>
    </div>

    <!-- 📅 Date -->
    <div class="form-group">
        <label for="affectation_date">Date :</label>
        <input type="date" 
               name="affectation_date" 
               id="affectation_date" 
               required>
    </div>

    <button type="submit">Enregistrer la distribution</button>

</form>

<!-- Chargement du script externe -->
<script 
    src="/assets/js/distribution.js" 
    nonce="<?= htmlspecialchars($nonce) ?>"
></script>

</body>
</html>
