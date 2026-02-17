<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Achats</title>
    <link rel="stylesheet" href="/assets/css/form.css">
    <style>
        .filter-section {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .info-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .amount {
            font-weight: bold;
            color: #4caf50;
        }
        .btn-danger {
            background-color: #f44336;
            color: white;
            border: none;
            cursor: pointer;
        }
        .btn-danger:hover {
            background-color: #da190b;
        }
    </style>
</head>
<body>
    <h2>Liste des Achats</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="success">
            <p><?= htmlspecialchars($_GET['success']) ?></p>
        </div>
    <?php endif; ?>
    
    <div class="info-box">
        <strong>Argent disponible pour achats :</strong> <span class="amount"><?= number_format($availableCash, 2, ',', ' ') ?> Ar</span>
    </div>
    
    <div class="filter-section">
        <form method="GET" action="/bngrc/list-purchases">
            <label for="city_id">Filtrer par ville :</label>
            <select name="city_id" id="city_id" onchange="this.form.submit()">
                <option value="">-- Toutes les villes --</option>
                <?php foreach ($villes as $ville): ?>
                    <option value="<?= $ville->getId() ?>" <?= isset($city_filter) && $city_filter == $ville->getId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ville->getName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <a href="/bngrc/list-purchases" class="btn-secondary" style="margin-left: 10px;">Réinitialiser</a>
        </form>
    </div>
    
    <a href="/bngrc/form-purchase" class="btn-primary">Nouvel achat</a>
    
    <?php if (empty($purchases)): ?>
        <p style="margin-top: 20px;">Aucun achat enregistré<?= isset($city_filter) ? ' pour cette ville' : '' ?>.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Ville</th>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Montant total</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($purchases as $purchase): 
                    $total += $purchase['total_amount'];
                ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($purchase['purchase_date']))) ?></td>
                        <td><?= htmlspecialchars($purchase['city_name']) ?></td>
                        <td><?= htmlspecialchars($purchase['article_name']) ?></td>
                        <td><?= number_format($purchase['quantity'], 2, ',', ' ') ?> <?= htmlspecialchars($purchase['article_unit']) ?></td>
                        <td><?= number_format($purchase['unit_price'], 2, ',', ' ') ?> Ar</td>
                        <td class="amount"><?= number_format($purchase['total_amount'], 2, ',', ' ') ?> Ar</td>
                        <td><?= htmlspecialchars($purchase['description'] ?? '-') ?></td>
                        <td>
                            <a href="/bngrc/purchases/edit/<?= $purchase['id'] ?>" class="btn-secondary" style="padding: 5px 10px; font-size: 12px; text-decoration: none; display: inline-block; margin-right: 5px;">Modifier</a>
                            <a href="/bngrc/purchases/delete/<?= $purchase['id'] ?>" 
                               class="btn-danger" 
                               style="padding: 5px 10px; font-size: 12px; text-decoration: none; display: inline-block; background-color: #f44336;"
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet achat ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        </table>
    <?php endif; ?>
</body>
</html>
