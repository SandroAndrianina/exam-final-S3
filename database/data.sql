INSERT INTO user (name, email, password) VALUES 
('Alice', 'alice@email.com', 'alice123'),
('Bob', 'bob@email.com', 'bob456'),
('Charlie', 'charlie@email.com', 'charlie789');


INSERT INTO object_exchange (name, id_user, image) VALUES 
-- Objets de Alice (id_user = 1)
('Guitare Yamaha', 1, 'guitare.jpg'),
('Ampli Fender', 1, 'ampli.jpg'),
('Livre - Apprendre le PHP', 1, 'livre_php.jpg'),
('Microphone Blue Yeti', 1, 'micro.jpg'),
('Casque Audio Sony', 1, 'casque.jpg'),
-- Objets de Bob (id_user = 2)
('Appareil Photo Nikon', 2, 'nikon.jpg'),
('Objectif 50mm', 2, 'objectif.jpg'),
('Trépied Aluminium', 2, 'trepied.jpg'),
('Sac à dos photo', 2, 'sac_photo.jpg'),
('Carte SD 128Go', 2, 'sd_card.jpg'),
-- Objets de Charlie (id_user = 3)
('Vélo de course', 3, 'velo.jpg'),
('Casque de vélo', 3, 'casque_velo.jpg'),
('Pompe à vélo', 3, 'pompe.jpg'),
('Antivol Haute Sécurité', 3, 'antivol.jpg'),
('Gants de cyclisme', 3, 'gants.jpg');


INSERT INTO exchange (id_sender, id_receiver, id_obj_sender, id_obj_receiver, status) VALUES 
(1, 2, 1, 2, 'pending'); -- Échange en attente entre Alice et Bob

-------------------
SELECT * FROM object_exchange; -> Par rapport a findAllObj()
SELECT * FROM user; -> Par rapport a findAllUsers()
SELECT * FROM exchange; -> Par rapport a findAllExchanges()