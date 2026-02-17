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
</head>
<body>

<h2>Distribution de donation</h2>

<form action="/bngrc/form-distribution" method="post">

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

<!-- ✅ SCRIPT AJAX -->
<script>
document.getElementById('ville').addEventListener('change', function () {

    const cityId = this.value;
    const needsSelect = document.getElementById('needs');

    // Reset dropdown
    needsSelect.innerHTML = '<option value="">Chargement...</option>';

    if (cityId === "") {
        needsSelect.innerHTML = '<option value="">-- Choisir d\'abord une ville --</option>';
        return;
    }

    fetch(`/bngrc/needs/by-city/${cityId}`)
        .then(response => response.json())
        .then(data => {

            needsSelect.innerHTML = '<option value="">-- Choisir un besoin --</option>';

            data.forEach(function (need) {

                const option = document.createElement('option');
                option.value = need.id;
               option.textContent = need.article_name + 
    " (" + need.unit + ") - Restant: " + need.remaining_quantity;


                needsSelect.appendChild(option);
            });

        })
        .catch(error => {
            needsSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
});
</script>

</body>
</html>
