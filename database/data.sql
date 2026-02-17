INSERT INTO city (name) VALUES 
('Antananarivo'), 
('Antsirabe'), 
('Toamasina'), 
('Fianarantsoa'), 
('Mahajanga');


INSERT INTO article (name, type, unit) VALUES 
('Riz', 'in kind', 'kg'),
('Huile', 'in kind', 'litre'),
('Tôle', 'materials', 'pièce'),
('Clou', 'materials', 'kg'),
('Fonds de secours', 'cash', 'Ariary');


INSERT INTO needs (city_id, article_id, quantity_requested, creation_date) VALUES 
(1, 5, 1000000.00, '2026-02-16'), -- Tana demande 1.000.000 Ariary exemple ohatra
(2, 3, 50.00, '2026-02-16'); -- Antsirabe demande 50 pièces de tôles 


-- Insertion des dons (gift)
-- Un donateur offre 1000kg de riz / Un autre offre 200 savons
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
(1, 1000.00, '2026-02-16', 'Riz'),        -- ID 1
(3, 200.00, '2026-02-16', 'Tôles'),       -- ID 2
(5, 2000000.00, '2026-02-16', 'Espèces');


-- Distribution pour Tana (800.000 Ariary pris sur le Don ID 1)
-- Distribution pour Antsirabe (30 tôles prises sur le Don ID 2)
INSERT INTO distribution (gift_id, needs_id, attributed_quantity, affectation_date) VALUES 
(3, 1, 800000.00, NOW()), 
(2, 2, 30.00, NOW());



-- Mise à jour des prix unitaires pour chaque article
-- Prix basés sur le marché malgache (Ariary)

USE ETU4392_ETU4110_ETU4016;

-- Riz : 4500 Ar/kg (prix moyen du riz local)
UPDATE article SET unit_price = 4500.00 WHERE name = 'Riz';

-- Huile : 9000 Ar/litre (huile végétale standard)
UPDATE article SET unit_price = 9000.00 WHERE name = 'Huile';

-- Tôle : 75000 Ar/pièce (tôle ondulée standard 2m)
UPDATE article SET unit_price = 75000.00 WHERE name = 'Tôle';

-- Clou : 18000 Ar/kg (clous assortis)
UPDATE article SET unit_price = 18000.00 WHERE name = 'Clou';

-- Fonds de secours : 1 Ar (argent = argent, pas de conversion)
UPDATE article SET unit_price = 1.00 WHERE name = 'Fonds de secours';

-- Vérification des prix
SELECT * FROM article;


--------------------------------------

-- 1. Ajout des villes manquantes
INSERT INTO city (name) VALUES 
('Mananjary'),
('Farafangana'),
('Nosy Be'),
('Morondava')
ON DUPLICATE KEY UPDATE name=name;

-- Toamasina existe déjà dans les données initiales

-- 2. Ajout des articles manquants avec leurs prix unitaires
INSERT INTO article (name, type, unit, unit_price) VALUES 
('Eau', 'in kind', 'L', 1000.00),
('Bâche', 'materials', 'pièce', 15000.00),
('Bois', 'materials', 'pièce', 10000.00),
('Haricots', 'in kind', 'kg', 4000.00),
('Groupe électrogène', 'materials', 'pièce', 6750000.00)
ON DUPLICATE KEY UPDATE unit_price=VALUES(unit_price);

-- 3. Mise à jour des prix unitaires des articles existants selon les données fournies
UPDATE article SET unit_price = 3000.00 WHERE name = 'Riz';
UPDATE article SET unit_price = 25000.00 WHERE name = 'Tôle';
UPDATE article SET unit_price = 8000.00 WHERE name = 'Clou';
UPDATE article SET unit_price = 6000.00 WHERE name = 'Huile';
UPDATE article SET unit_price = 1.00 WHERE name = 'Fonds de secours';

-- 4. Insertion des dons (gift)
-- Note: Les ID de city et article seront récupérés dynamiquement

-- Dons pour Toamasina
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 800.00, '2026-02-16', 'Don Toamasina - Ordre 17'),
((SELECT id FROM article WHERE name = 'Eau' LIMIT 1), 1500.00, '2026-02-15', 'Don Toamasina - Ordre 4'),
((SELECT id FROM article WHERE name = 'Tôle' LIMIT 1), 120.00, '2026-02-16', 'Don Toamasina - Ordre 23'),
((SELECT id FROM article WHERE name = 'Bâche' LIMIT 1), 200.00, '2026-02-15', 'Don Toamasina - Ordre 1'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 12000000.00, '2026-02-16', 'Don Toamasina - Argent - Ordre 12'),
((SELECT id FROM article WHERE name = 'Groupe électrogène' LIMIT 1), 3.00, '2026-02-15', 'Don Toamasina - Ordre 16');

-- Dons pour Mananjary
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 500.00, '2026-02-15', 'Don Mananjary - Ordre 9'),
((SELECT id FROM article WHERE name = 'Huile' LIMIT 1), 120.00, '2026-02-16', 'Don Mananjary - Ordre 25'),
((SELECT id FROM article WHERE name = 'Tôle' LIMIT 1), 80.00, '2026-02-15', 'Don Mananjary - Ordre 6'),
((SELECT id FROM article WHERE name = 'Clou' LIMIT 1), 60.00, '2026-02-16', 'Don Mananjary - Ordre 19'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 6000000.00, '2026-02-15', 'Don Mananjary - Argent - Ordre 3');

-- Dons pour Farafangana
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 600.00, '2026-02-16', 'Don Farafangana - Ordre 21'),
((SELECT id FROM article WHERE name = 'Eau' LIMIT 1), 1000.00, '2026-02-15', 'Don Farafangana - Ordre 14'),
((SELECT id FROM article WHERE name = 'Bâche' LIMIT 1), 150.00, '2026-02-16', 'Don Farafangana - Ordre 8'),
((SELECT id FROM article WHERE name = 'Bois' LIMIT 1), 100.00, '2026-02-15', 'Don Farafangana - Ordre 26'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 8000000.00, '2026-02-16', 'Don Farafangana - Argent - Ordre 10');

-- Dons pour Nosy Be
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 300.00, '2026-02-15', 'Don Nosy Be - Ordre 5'),
((SELECT id FROM article WHERE name = 'Haricots' LIMIT 1), 200.00, '2026-02-16', 'Don Nosy Be - Ordre 18'),
((SELECT id FROM article WHERE name = 'Tôle' LIMIT 1), 40.00, '2026-02-15', 'Don Nosy Be - Ordre 2'),
((SELECT id FROM article WHERE name = 'Clou' LIMIT 1), 30.00, '2026-02-16', 'Don Nosy Be - Ordre 24'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 4000000.00, '2026-02-15', 'Don Nosy Be - Argent - Ordre 7');

-- Dons pour Morondava
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 700.00, '2026-02-16', 'Don Morondava - Ordre 11'),
((SELECT id FROM article WHERE name = 'Eau' LIMIT 1), 1200.00, '2026-02-15', 'Don Morondava - Ordre 20'),
((SELECT id FROM article WHERE name = 'Bâche' LIMIT 1), 180.00, '2026-02-16', 'Don Morondava - Ordre 15'),
((SELECT id FROM article WHERE name = 'Bois' LIMIT 1), 150.00, '2026-02-15', 'Don Morondava - Ordre 22'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 10000000.00, '2026-02-16', 'Don Morondava - Argent - Ordre 13');

-- 5. Vérification des données insérées
SELECT 'Villes ajoutées:' as Info;
SELECT * FROM city;

SELECT 'Articles mis à jour:' as Info;
SELECT id, name, type, unit, unit_price FROM article ORDER BY type, name;

SELECT 'Dons insérés:' as Info;
SELECT g.id, a.name as article, g.total_quantity, g.donation_date, g.description 
FROM gift g 
LEFT JOIN article a ON g.article_id = a.id 
ORDER BY g.donation_date ASC, g.id ASC
LIMIT 30;

-- Statistiques
SELECT 'Statistiques:' as Info;
SELECT 
    (SELECT COUNT(*) FROM city) as total_villes,
    (SELECT COUNT(*) FROM article) as total_articles,
    (SELECT COUNT(*) FROM gift) as total_dons;



-------------------------


-- Dons du 16 février 2026
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 5000000.00, '2026-02-16', 'Don en argent - 5M Ar'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 3000000.00, '2026-02-16', 'Don en argent - 3M Ar'),
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 400.00, '2026-02-16', 'Don de Riz - 400 kg'),
((SELECT id FROM article WHERE name = 'Eau' LIMIT 1), 600.00, '2026-02-16', 'Don d\'Eau - 600 L');

-- Dons du 17 février 2026
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 4000000.00, '2026-02-17', 'Don en argent - 4M Ar'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 1500000.00, '2026-02-17', 'Don en argent - 1.5M Ar'),
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 6000000.00, '2026-02-17', 'Don en argent - 6M Ar'),
((SELECT id FROM article WHERE name = 'Tôle' LIMIT 1), 50.00, '2026-02-17', 'Don de Tôle - 50 pièces'),
((SELECT id FROM article WHERE name = 'Bâche' LIMIT 1), 70.00, '2026-02-17', 'Don de Bâche - 70 pièces'),
((SELECT id FROM article WHERE name = 'Haricots' LIMIT 1), 100.00, '2026-02-17', 'Don de Haricots - 100 kg'),
((SELECT id FROM article WHERE name = 'Haricots' LIMIT 1), 88.00, '2026-02-17', 'Don de Haricots - 88 kg');

-- Dons du 18 février 2026
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES
((SELECT id FROM article WHERE name = 'Riz' LIMIT 1), 2000.00, '2026-02-18', 'Don de Riz - 2000 kg'),
((SELECT id FROM article WHERE name = 'Tôle' LIMIT 1), 300.00, '2026-02-18', 'Don de Tôle - 300 pièces'),
((SELECT id FROM article WHERE name = 'Eau' LIMIT 1), 5000.00, '2026-02-18', 'Don d\'Eau - 5000 L');

-- Dons du 19 février 2026
INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES
((SELECT id FROM article WHERE name = 'Fonds de secours' LIMIT 1), 20000000.00, '2026-02-19', 'Don en argent - 20M Ar'),
((SELECT id FROM article WHERE name = 'Bâche' LIMIT 1), 500.00, '2026-02-19', 'Don de Bâche - 500 pièces');

-- Vérification des insertions
SELECT 'Dons insérés avec succès' as Resultat;

SELECT 
    g.id,
    a.name as Article,
    g.total_quantity as Quantite,
    g.donation_date as Date,
    g.description as Description
FROM gift g
JOIN article a ON g.article_id = a.id
WHERE g.donation_date >= '2026-02-16'
ORDER BY g.donation_date, g.id;

-- Statistiques
SELECT 
    'Total des nouveaux dons' as Info,
    COUNT(*) as Nombre_dons,
    SUM(CASE WHEN a.name = 'Fonds de secours' THEN g.total_quantity ELSE 0 END) as Total_Argent_Ar,
    SUM(CASE WHEN a.name = 'Riz' THEN g.total_quantity ELSE 0 END) as Total_Riz_kg,
    SUM(CASE WHEN a.name = 'Eau' THEN g.total_quantity ELSE 0 END) as Total_Eau_L,
    SUM(CASE WHEN a.name = 'Tôle' THEN g.total_quantity ELSE 0 END) as Total_Tole,
    SUM(CASE WHEN a.name = 'Bâche' THEN g.total_quantity ELSE 0 END) as Total_Bache,
    SUM(CASE WHEN a.name = 'Haricots' THEN g.total_quantity ELSE 0 END) as Total_Haricots_kg
FROM gift g
JOIN article a ON g.article_id = a.id
WHERE g.donation_date >= '2026-02-16';
