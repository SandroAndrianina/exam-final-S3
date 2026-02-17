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

INSERT INTO reduction (percentage) VALUES 
(5.00);   -- 5% de réduction