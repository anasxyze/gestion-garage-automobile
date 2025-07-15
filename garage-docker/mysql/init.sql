CREATE DATABASE IF NOT EXISTS garage;
USE garage;

CREATE TABLE voitures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque VARCHAR(50) NOT NULL,
    modele VARCHAR(50) NOT NULL,
    annee INT NOT NULL,
    couleur VARCHAR(30),
    prix DECIMAL(10,2) NOT NULL,
    kilometrage INT,
    disponibilite BOOLEAN DEFAULT 1
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    prix DECIMAL(7,2) NOT NULL,
    duree TIME NOT NULL
);

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE,
    telephone VARCHAR(20) NOT NULL
);

CREATE TABLE rdv (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    voiture_id INT NOT NULL,
    service_id INT NOT NULL,
    date_heure DATETIME NOT NULL,
    notes TEXT,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (voiture_id) REFERENCES voitures(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Données initiales
INSERT INTO voitures (marque, modele, annee, couleur, prix, kilometrage) VALUES
('Renault', 'Clio', 2020, 'Bleu', 15000.00, 25000),
('Peugeot', '208', 2019, 'Rouge', 16500.00, 18000),
('Citroën', 'C3', 2021, 'Blanc', 17500.00, 12000);

INSERT INTO services (nom, description, prix, duree) VALUES
('Vidange', 'Changement huile et filtre à huile', 89.99, '01:00:00'),
('Pneumatiques', 'Changement des pneus', 299.99, '01:30:00'),
('Freinage', 'Remplacement plaquettes et disques', 399.99, '02:00:00');

INSERT INTO clients (nom, prenom, email, telephone) VALUES
('Dupont', 'Jean', 'jean.dupont@email.com', '0612345678'),
('Martin', 'Sophie', 'sophie.martin@email.com', '0698765432');

INSERT INTO rdv (client_id, voiture_id, service_id, date_heure) VALUES
(1, 1, 1, '2023-12-15 10:00:00'),
(2, 2, 3, '2023-12-16 14:30:00');