-- Mise à jour du schéma pour les nouvelles fonctionnalités

USE ETU4392_ETU4110_ETU4016;

-- Ajouter le prix unitaire aux articles (DÉJÀ FAIT - commenté pour éviter l'erreur)
-- ALTER TABLE article 
-- ADD COLUMN unit_price DECIMAL(15,2) DEFAULT 0 COMMENT 'Prix unitaire de l''article';

-- Créer la table des achats
CREATE TABLE IF NOT EXISTS purchase (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_id INT NOT NULL,
    article_id INT NOT NULL,
    quantity DECIMAL(15,2) NOT NULL,
    unit_price DECIMAL(15,2) NOT NULL,
    total_amount DECIMAL(15,2) NOT NULL,
    purchase_date DATE NOT NULL,
    gift_id INT NULL COMMENT 'Don en argent utilisé pour l''achat',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_purchase_city FOREIGN KEY (city_id) REFERENCES city(id),
    CONSTRAINT fk_purchase_article FOREIGN KEY (article_id) REFERENCES article(id),
    CONSTRAINT fk_purchase_gift FOREIGN KEY (gift_id) REFERENCES gift(id)
) ENGINE=InnoDB COMMENT='Table des achats effectués avec les dons en argent';

-- Index pour optimiser les recherches
CREATE INDEX idx_purchase_city ON purchase(city_id);
CREATE INDEX idx_purchase_date ON purchase(purchase_date);
CREATE INDEX idx_article_type ON article(type);
