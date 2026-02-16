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
(1, 1000.00, '2023-10-05', 'Don anonyme - Stock riz'),
(3, 200.00, '2023-10-06', 'Association Solidarite - Hygiène');


-- Distribution pour Tana (800.000 Ariary pris sur le Don ID 1)
-- Distribution pour Antsirabe (30 tôles prises sur le Don ID 2)
INSERT INTO distribution (gift_id, needs_id, attributed_quantity, affectation_date) VALUES 
(1, 1, 800000.00, NOW()), 
(2, 2, 30.00, NOW());

