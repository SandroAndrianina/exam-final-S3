<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link rel="stylesheet" href="/assets/css/form.css">
    <style>
        .dashboard-container {
            padding: 20px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .stat-card.success {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
        }
        .stat-card.info {
            background: linear-gradient(135deg, #2196F3 0%, #1976d2 100%);
        }
        .stat-card.warning {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        }
        .stat-card.primary {
            background: linear-gradient(135deg, #9c27b0 0%, #7b1fa2 100%);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .stat-card .value {
            font-size: 28px;
            font-weight: bold;
            margin: 10px 0;
        }
        .stat-card .subtitle {
            font-size: 12px;
            opacity: 0.8;
        }
        .refresh-section {
            text-align: right;
            margin-bottom: 20px;
        }
        .btn-refresh {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-refresh:hover {
            background-color: #45a049;
        }
        .purchases-by-city {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #667eea;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .amount {
            font-weight: bold;
            color: #4caf50;
        }
        .loading {
            display: none;
            text-align: center;
            padding: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Tableau de Bord - Récapitulatif</h2>
        
        <div class="refresh-section">
            <button class="btn-refresh" onclick="refreshData()">🔄 Actualiser les données</button>
            <div class="loading" id="loading">Chargement...</div>
        </div>
        
        <div class="stats-grid" id="stats-grid">
            <div class="stat-card info">
                <h3>Total des Besoins</h3>
                <div class="value" id="total-needs"><?= number_format($stats['total_needs_amount'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Montant total des besoins exprimés</div>
            </div>
            
            <div class="stat-card success">
                <h3>Besoins Satisfaits</h3>
                <div class="value" id="satisfied-needs"><?= number_format($stats['satisfied_needs_amount'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Taux: <?= number_format($stats['satisfaction_rate'], 1) ?>%</div>
            </div>
            
            <div class="stat-card primary">
                <h3>Total des Dons Reçus</h3>
                <div class="value" id="total-gifts"><?= number_format($stats['total_gifts_amount'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Valeur totale des dons</div>
            </div>
            
            <div class="stat-card warning">
                <h3>Dons Dispatchés</h3>
                <div class="value" id="dispatched-gifts"><?= number_format($stats['dispatched_amount'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Montant distribué aux villes</div>
            </div>
            
            <div class="stat-card info">
                <h3>Total des Achats</h3>
                <div class="value" id="total-purchases"><?= number_format($stats['total_purchases'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Montant total des achats effectués</div>
            </div>
            
            <div class="stat-card success">
                <h3>Argent Disponible</h3>
                <div class="value" id="available-cash"><?= number_format($stats['available_cash'], 2, ',', ' ') ?> Ar</div>
                <div class="subtitle">Disponible pour achats</div>
            </div>
        </div>
        
        <div class="purchases-by-city">
            <h3>Achats par Ville</h3>
            <table id="purchases-table">
                <thead>
                    <tr>
                        <th>Ville</th>
                        <th>Nombre d'achats</th>
                        <th>Montant total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($purchasesByCity)): ?>
                        <tr>
                            <td colspan="3">Aucun achat enregistré</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($purchasesByCity as $cityPurchase): ?>
                            <tr>
                                <td><?= htmlspecialchars($cityPurchase['name']) ?></td>
                                <td><?= $cityPurchase['purchase_count'] ?></td>
                                <td class="amount"><?= number_format($cityPurchase['total_amount'], 2, ',', ' ') ?> Ar</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <script>
        function refreshData() {
            const loading = document.getElementById('loading');
            loading.style.display = 'block';
            
            fetch('/bngrc/dashboard/refresh')
                .then(response => response.json())
                .then(data => {
                    // Update stats
                    document.getElementById('total-needs').textContent = 
                        formatNumber(data.stats.total_needs_amount) + ' Ar';
                    document.getElementById('satisfied-needs').textContent = 
                        formatNumber(data.stats.satisfied_needs_amount) + ' Ar';
                    document.getElementById('total-gifts').textContent = 
                        formatNumber(data.stats.total_gifts_amount) + ' Ar';
                    document.getElementById('dispatched-gifts').textContent = 
                        formatNumber(data.stats.dispatched_amount) + ' Ar';
                    document.getElementById('total-purchases').textContent = 
                        formatNumber(data.stats.total_purchases) + ' Ar';
                    document.getElementById('available-cash').textContent = 
                        formatNumber(data.stats.available_cash) + ' Ar';
                    
                    // Update satisfaction rate
                    const satisfiedCard = document.getElementById('satisfied-needs').parentElement;
                    satisfiedCard.querySelector('.subtitle').textContent = 
                        'Taux: ' + data.stats.satisfaction_rate.toFixed(1) + '%';
                    
                    // Update purchases table
                    const tbody = document.querySelector('#purchases-table tbody');
                    tbody.innerHTML = '';
                    
                    if (data.purchasesByCity.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3">Aucun achat enregistré</td></tr>';
                    } else {
                        data.purchasesByCity.forEach(city => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${escapeHtml(city.name)}</td>
                                <td>${city.purchase_count}</td>
                                <td class="amount">${formatNumber(city.total_amount)} Ar</td>
                            `;
                            tbody.appendChild(row);
                        });
                    }
                    
                    loading.style.display = 'none';
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    loading.style.display = 'none';
                    alert('Erreur lors du rafraîchissement des données');
                });
        }
        
        function formatNumber(num) {
            return new Intl.NumberFormat('fr-FR', { 
                minimumFractionDigits: 2,
                maximumFractionDigits: 2 
            }).format(num);
        }
        
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
