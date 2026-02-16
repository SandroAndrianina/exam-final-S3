CREATE DATABASE prepa_exam_S3_takalo;
USE prepa_exam_S3_takalo;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE,
    password VARCHAR(255)
) ENGINE=InnoDB;


CREATE TABLE object_exchange (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    id_user INT NOT NULL,
    image VARCHAR(255),
    CONSTRAINT fk_object_user FOREIGN KEY (id_user) REFERENCES user(id_user) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE exchange (
    id_exchange INT AUTO_INCREMENT PRIMARY KEY,
    id_sender INT,
    id_receiver INT,
    id_obj_sender INT,   -- L'objet proposé par l'initiateur
    id_obj_receiver INT, -- L'objet souhaité en retour
    status ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_sender) REFERENCES user(id_user),
    FOREIGN KEY (id_receiver) REFERENCES user(id_user),
    FOREIGN KEY (id_obj_sender) REFERENCES object_exchange(id),
    FOREIGN KEY (id_obj_receiver) REFERENCES object_exchange(id)
);