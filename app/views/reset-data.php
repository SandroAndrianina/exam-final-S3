<style>
    .reset-container {
        max-width: 900px;
        margin: 20px auto;
        padding: 20px;
    }
    
    .warning-box {
        background-color: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 20px;
        margin-bottom: 30px;
        border-radius: 4px;
    }
    
    .warning-box h3 {
        color: #856404;
        margin-top: 0;
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }
    
    .stat-card h4 {
        margin: 0 0 10px 0;
        color: #333;
    }
    
    .stat-card .count {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }
    
    .reset-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }
    
    .reset-card {
        background: white;
        padding: 20px;
        border: 2px solid #ddd;
        border-radius: 8px;
        text-align: center;
    }
    
    .reset-card h3 {
        margin-top: 0;
        color: #333;
    }
    
    .reset-card p {
        color: #666;
        margin: 15px 0;
    }
    
    .btn-reset {
        background-color: #ffc107;
        color: #000;
        padding: 12px 24px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-reset:hover {
        background-color: #e0a800;
    }
    
    .btn-reset-all {
        background-color: #dc3545;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        margin-top: 30px;
    }
    
    .btn-reset-all:hover {
        background-color: #c82333;
    }
    
    .success-message {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    
    .error-message {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
</style>

<div class="reset-container">
    <h2>Réinitialisation des Données</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="success-message">
            <strong>Succès !</strong> <?= htmlspecialchars($_GET['success']) ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="error-message">
            <strong>Erreur !</strong> <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>
    
    
    <h3>État actuel de la base de données :</h3>
    <div class="stats-grid">
        <div class="stat-card">
            <h4>Dons</h4>
            <div class="count"><?= $stats['gifts_count'] ?></div>
            <small>enregistrements</small>
        </div>
        
        <div class="stat-card">
            <h4>Besoins</h4>
            <div class="count"><?= $stats['needs_count'] ?></div>
            <small>enregistrements</small>
        </div>
        
        <div class="stat-card">
            <h4>Achats</h4>
            <div class="count"><?= $stats['purchases_count'] ?></div>
            <small>enregistrements</small>
        </div>
        
        <div class="stat-card">
            <h4>Distributions</h4>
            <div class="count"><?= $stats['distributions_count'] ?></div>
            <small>enregistrements</small>
        </div>
    </div>
    
    <h3>Réinitialisation par table :</h3>
    <div class="reset-actions">
        <div class="reset-card">
            <h3>Dons</h3>
            <p>Garde le premier don, supprime tous les autres + distributions liées</p>
            <form action="/bngrc/reset/gifts" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir réinitialiser les DONS ? Cette action est IRRÉVERSIBLE !');">
                <button type="submit" class="btn-reset">Réinitialiser les Dons</button>
            </form>
        </div>
        
        <div class="reset-card">
            <h3>Besoins</h3>
            <p>Garde le premier besoin, supprime tous les autres + distributions liées</p>
            <form action="/bngrc/reset/needs" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir réinitialiser les BESOINS ? Cette action est IRRÉVERSIBLE !');">
                <button type="submit" class="btn-reset">Réinitialiser les Besoins</button>
            </form>
        </div>
        
        <div class="reset-card">
            <h3>Achats</h3>
            <p>Garde le premier achat, supprime tous les autres</p>
            <form action="/bngrc/reset/purchases" method="POST" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir réinitialiser les ACHATS ? Cette action est IRRÉVERSIBLE !');">
                <button type="submit" class="btn-reset">Réinitialiser les Achats</button>
            </form>
        </div>
    </div>
    
    <div style="text-align: center; margin-top: 50px; padding: 30px; background-color: #ffe6e6; border-radius: 8px;">
        <h3 style="color: #dc3545;">Réinitialisation Totale</h3>
        <p style="color: #721c24; font-size: 16px;">
            Cette action supprimera <strong>TOUTES</strong> les données (dons, besoins, achats, distributions)<br>
            sauf la première ligne de chaque table.
        </p>
        <form action="/bngrc/reset/all" method="POST" onsubmit="return confirm('DERNIÈRE CONFIRMATION \n\nVous êtes sur le point de SUPPRIMER TOUTES LES DONNÉES !\n\nSeule la première ligne de chaque table sera conservée.\nCette action est DÉFINITIVE et IRRÉVERSIBLE.\n\nTapez OK pour continuer.');">
            <button type="submit" class="btn-reset-all">TOUT RÉINITIALISER</button>
        </form>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="/" class="btn-secondary" style="padding: 10px 20px; text-decoration: none;">← Retour à l'accueil</a>
    </div>
</div>
