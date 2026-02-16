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
(1, 5, 1000000.00, '2026-02-16'), -- Tana (ID 1) demande 1M Ariary (ID 5)
(2, 3, 50.00, '2026-02-16');      -- Antsirabe (ID 2) demande 50 tôles (ID 3)



INSERT INTO gift (article_id, total_quantity, donation_date, description) VALUES 
(5, 2000000.00, '2026-02-15', 'Donation de la Banque'), -- Don ID 1 (Argent pour l'article 5)
(3, 200.00, '2026-02-15', 'Stock Quincaillerie');       -- Don ID 2 (Tôles pour l'article 3)



-- On donne 800.000 Ariary à Tana (Besoins ID 1) en piochant dans le Don d'argent (Gift ID 1)
-- On donne 30. tôles à Antsirabe (Besoins ID 2) en piochant dans le Don de tôles (Gift ID 2)
INSERT INTO distribution (gift_id, needs_id, attributed_quantity, affectation_date) VALUES 
(1, 1, 800000.00, NOW()), 
(2, 2, 30.00, NOW());


