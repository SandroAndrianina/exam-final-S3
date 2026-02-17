<h2>Modifier l'Achat</h2>

<?php if (isset($_GET['error'])): ?>
    <div class="errors">
        <p><?= htmlspecialchars($_GET['error']) ?></p>
    </div>
<?php endif; ?>

<div class="info-box" style="background-color: #e3f2fd; border-left: 4px solid #2196F3; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
    <strong style="color: #1976d2;">Argent disponible pour achats :</strong> 
    <span style="font-weight: bold; color: #4caf50; margin-left: 10px;"><?= number_format($availableCash, 2, ',', ' ') ?> Ar</span>
</div>

<form action="/bngrc/purchases/edit/<?= $purchase['id'] ?>" method="POST" id="purchaseForm">
    
    <div class="form-group">
        <label for="city">Ville destinataire :</label>
        <select name="city_id" id="city" required>
            <option value="">-- Choisir une ville --</option>
            <?php foreach ($villes as $ville): ?>
                <option value="<?= $ville->getId() ?>" <?= $purchase['city_id'] == $ville->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($ville->getName()) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="article">Article à acheter :</label>
        <select name="article_id" id="article" required onchange="updatePrice()">
            <option value="">-- Choisir un article --</option>
            <?php foreach ($articles as $article): ?>
                <option value="<?= $article->getId() ?>" 
                        data-price="<?= $article->getUnitPrice() ?>"
                        data-unit="<?= htmlspecialchars($article->getUnit()) ?>"
                        <?= $purchase['article_id'] == $article->getId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($article->getName()) ?> 
                    (<?= number_format($article->getUnitPrice(), 2, ',', ' ') ?> Ar/<?= htmlspecialchars($article->getUnit()) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="quantity">Quantité :</label>
        <input type="number" step="0.01" name="quantity" id="quantity" value="<?= $purchase['quantity'] ?>" placeholder="Ex: 100" required oninput="updateTotal()">
        <span id="unit-display"><?= htmlspecialchars($purchase['article_unit']) ?></span>
    </div>
    
    <div class="form-group">
        <label>Prix unitaire :</label>
        <span id="unit-price-display" style="font-weight: bold; color: #4caf50; margin-left: 10px;"><?= number_format($purchase['unit_price'], 2, ',', ' ') ?> Ar</span>
    </div>
    
    <div class="form-group">
        <label>Montant total :</label>
        <span id="total-amount-display" style="font-weight: bold; color: #4caf50; margin-left: 10px;"><?= number_format($purchase['total_amount'], 2, ',', ' ') ?> Ar</span>
    </div>

    <div class="form-group">
        <label for="purchase_date">Date d'achat :</label>
        <input type="date" name="purchase_date" id="purchase_date" value="<?= $purchase['purchase_date'] ?>" required>
    </div>

    <div class="form-group">
        <label for="description">Description (optionnelle) :</label>
        <textarea name="description" id="description" rows="4" placeholder="Informations supplémentaires sur l'achat..."><?= htmlspecialchars($purchase['description'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn-primary">Modifier l'achat</button>
    <a href="/bngrc/list-purchases" class="btn-secondary">Annuler</a>
</form>

<script>
    // Initialiser le prix au chargement
    updatePrice();
    
    function updatePrice() {
        const select = document.getElementById('article');
        const selectedOption = select.options[select.selectedIndex];
        const price = selectedOption.dataset.price || 0;
        const unit = selectedOption.dataset.unit || '';
        
        document.getElementById('unit-price-display').textContent = 
            new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(price) + ' Ar';
        document.getElementById('unit-display').textContent = unit;
        
        updateTotal();
    }
    
    function updateTotal() {
        const select = document.getElementById('article');
        const selectedOption = select.options[select.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price || 0);
        const quantity = parseFloat(document.getElementById('quantity').value || 0);
        const total = price * quantity;
        
        document.getElementById('total-amount-display').textContent = 
            new Intl.NumberFormat('fr-FR', { minimumFractionDigits: 2 }).format(total) + ' Ar';
    }
</script>
