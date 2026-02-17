CREATE DATABASE IF NOT EXISTS ETU4392_ETU4110_ETU4016;
USE ETU4392_ETU4110_ETU4016;


CREATE TABLE city (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
) ENGINE=InnoDB;


CREATE TABLE article (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('in kind', 'materials', 'cash') NOT NULL,
    unit VARCHAR(20) NOT NULL -- kg, pièce, litre ou Ariary
) ENGINE=InnoDB;


CREATE TABLE needs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_id INT,
    article_id INT,
    quantity_requested DECIMAL(15,2) NOT NULL,
    creation_date DATE NOT NULL,
    CONSTRAINT fk_needs_city FOREIGN KEY (city_id) REFERENCES city(id),
    CONSTRAINT fk_needs_article FOREIGN KEY (article_id) REFERENCES article(id)
) ENGINE=InnoDB;


CREATE TABLE gift (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    total_quantity DECIMAL(15,2) NOT NULL,
    donation_date DATE NOT NULL,
    description TEXT,
    CONSTRAINT fk_gift_article FOREIGN KEY (article_id) REFERENCES article(id)
) ENGINE=InnoDB;


CREATE TABLE distribution (
    id INT AUTO_INCREMENT PRIMARY KEY,
    gift_id INT,
    needs_id INT,
    attributed_quantity DECIMAL(15,2) NOT NULL,
    affectation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_distrib_gift FOREIGN KEY (gift_id) REFERENCES gift(id),
    CONSTRAINT fk_distrib_needs FOREIGN KEY (needs_id) REFERENCES needs(id)
) ENGINE=InnoDB;




ALTER TABLE article 
ADD COLUMN unit_price DECIMAL(15,2) DEFAULT 0 COMMENT 'Prix unitaire de l''article';

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

