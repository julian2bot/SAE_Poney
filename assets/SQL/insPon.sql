-- Table NIVEAU : exemples de niveaux réels dans un club d'équitation
INSERT INTO NIVEAU (idNiveau, nomNiveau) VALUES
(1, 'Débutant'),
(2, 'Intermédiaire'),
(3, 'Confirmé'),
(4, 'Avancé'),
(5, 'Galop 1'),
(6, 'Galop 2'),
(7, 'Galop 3'),
(8, 'Galop 4'),
(9, 'Galop 5'),
(10, 'Galop 6');

-- Table RACE : exemples de races de poney
INSERT INTO RACE (nomRace, descriptionRace) VALUES
('Shetland', 'Petits poneys robustes originaires des îles Shetland.'),
('Connemara', 'Race irlandaise connue pour son agilité et endurance.'),
('Welsh', 'Race galloise, polyvalente et populaire.'),
('Pottok', 'Race des Pyrénées, adaptée aux terrains escarpés.'),
('New Forest', 'Race britannique, résistante et intelligente.'),
('Fjord', 'Race norvégienne, caractérisée par son dos robuste et crinière bicolore.'),
('Haflinger', 'Race autrichienne, docile et adaptée aux montagnes.'),
('Dartmoor', 'Poney de la région de Dartmoor en Angleterre.'),
('Exmoor', 'Race anglaise ancienne, endurante.'),
('Camargue', 'Poney de la région de Camargue en France, souvent de couleur grise.');


INSERT INTO PERSONNE (idPersonne, mdp, prenomPersonne, nomPersonne, mail) VALUES
(1, 'password123', 'Alice', 'Durand', 'alice.durand@example.com'),
(2, 'securepass', 'Bob', 'Martin', 'bob.martin@example.com'),
(3, 'mypassword', 'Claire', 'Dubois', 'claire.dubois@example.com'),
(4, 'pass789', 'David', 'Lefevre', 'david.lefevre@example.com'),
(5, 'letmein', 'Emma', 'Moreau', 'emma.moreau@example.com'),
(6, 'ponylover', 'Fabien', 'Garcia', 'fabien.garcia@example.com'),
(7, 'password321', 'Julie', 'Bernard', 'julie.bernard@example.com'),
(8, 'safepassword', 'Henri', 'Roux', 'henri.roux@example.com'),
(9, 'monpassword', 'Isabelle', 'Petit', 'isabelle.petit@example.com'),
(10, 'hello1234', 'Louis', 'Blanc', 'louis.blanc@example.com');



-- Table CLIENT : des clients fictifs
INSERT INTO CLIENT (idClient, dateInscription, poidsClient, solde) VALUES
(1, '2023-01-15', 55, 200),
(2, '2023-02-20', 60, 150),
(3, '2023-03-05', 50, 300),
(4, '2023-04-18', 70, 250),
(5, '2023-05-10', 48, 100),
(6, '2023-06-25', 63, 120),
(7, '2023-07-14', 58, 180),
(8, '2023-08-01', 52, 220),
(9, '2023-09-23', 75, 350),
(10, '2023-10-12', 68, 90);

-- Table MONITEUR : des moniteurs fictifs avec salaires
INSERT INTO MONITEUR (idMoniteur, salaire) VALUES
(1, 2000.00),
(2, 2200.00),
(3, 2500.00),
(4, 2400.00),
(5, 2100.00),
(6, 2300.00),
(7, 2600.00),
(8, 2700.00),
(9, 2800.00),
(10, 2900.00);

-- Table COURS : des cours fictifs avec durées et niveaux associés
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(1, 1, 'Initiation au poney', 1, 30, 10),
(2, 2, 'Dressage débutant', 2, 40, 1),
(3, 3, 'Obstacle', 1, 50, 1),
(4, 4, 'Galop 1', 1, 35, 10),
(5, 5, 'Galop 2', 1, 40, 1),
(6, 6, 'Balade en forêt', 2, 60, 1),
(7, 7, 'Galop 3', 1, 50, 10),
(8, 8, 'Perfectionnement obstacle', 2, 65, 1),
(9, 9, 'Galop 4', 1, 45, 10),
(10, 10, 'Galop 5', 2, 55, 1);

-- Table PONEY : des poneys fictifs avec poids maximum et photos
INSERT INTO PONEY (idPoney, nomPoney, poidsMax, photo, nomRace) VALUES
(1, 'Eclair', 45, 'eclair.jpg', 'Shetland'),
(2, 'Lumière', 50, 'lumiere.jpg', 'Connemara'),
(3, 'Storm', 55, 'storm.jpg', 'Welsh'),
(4, 'Brise', 60, 'brise.jpg', 'Pottok'),
(5, 'Roxy', 48, 'roxy.jpg', 'New Forest'),
(6, 'Tornado', 63, 'tornado.jpg', 'Fjord'),
(7, 'Luna', 52, 'luna.jpg', 'Haflinger'),
(8, 'Bella', 56, 'bella.jpg', 'Dartmoor'),
(9, 'Choco', 47, 'choco.jpg', 'Exmoor'),
(10, 'Neige', 65, 'neige.jpg', 'Camargue');

-- Table DISPONIBILITE : disponibilité des moniteurs
INSERT INTO DISPONIBILITE (idMoniteur, heureDebutDispo, dateDispo, finHeureDispo) VALUES
(1, 9.0, '2023-12-01', 12.0),
(2, 10.0, '2023-12-01', 13.0),
(3, 14.0, '2023-12-02', 16.0),
(4, 15.0, '2023-12-02', 17.0),
(5, 8.0, '2023-12-03', 10.0),
(6, 13.0, '2023-12-03', 15.0),
(7, 9.0, '2023-12-04', 11.0),
(8, 11.0, '2023-12-04', 13.0),
(9, 10.0, '2023-12-05', 12.0),
(10, 12.0, '2023-12-05', 14.0);

-- Table COTISATION : cotisations fictives pour les clients
INSERT INTO COTISATION (nomCotisation, annees, prixCotisationAnnuelle) VALUES
('Cotisation annuelle', 2023, 500),
('Cotisation annuelle', 2022, 480),
('Cotisation familiale', 2023, 900),
('Cotisation mensuelle', 2023, 50),
('Cotisation junior', 2023, 300),
('Cotisation senior', 2023, 400),
('Cotisation premium', 2023, 1000),
('Cotisation annuelle', 2021, 470),
('Cotisation annuelle', 2020, 450),
('Cotisation familiale', 2022, 880);

-- Table PAYER : associations entre clients et cotisations
INSERT INTO PAYER (nomCotisation, anneesCoti, idClient) VALUES
('Cotisation annuelle', 2023, 1),
('Cotisation familiale', 2023, 2),
('Cotisation mensuelle', 2023, 3),
('Cotisation junior', 2023, 4),
('Cotisation senior', 2023, 5),
('Cotisation premium', 2023, 6),
('Cotisation annuelle', 2022, 7),
('Cotisation annuelle', 2021, 8),
('Cotisation annuelle', 2020, 9),
('Cotisation familiale', 2022, 10);

-- Table FACTURE_SOLDE : factures fictives des clients
INSERT INTO FACTURE_SOLDE (idClient, idFacture, dateFacture, montant) VALUES
(1, 1001, '2023-11-01', 200),
(2, 1002, '2023-10-15', 150),
(3, 1003, '2023-09-10', 300),
(4, 1004, '2023-08-20', 250),
(5, 1005, '2023-07-25', 100),
(6, 1006, '2023-06-30', 120),
(7, 1007, '2023-05-05', 180),
(8, 1008, '2023-04-12', 220),
(9, 1009, '2023-03-08', 350),
(10, 1010, '2023-02-14', 90);

-- Table OBTENTION : obtentions de niveau par des clients fictifs
INSERT INTO OBTENTION (idPersonne, idNiveau, dateObtention) VALUES
(1, 3, '2023-04-10'),
(2, 4, '2023-05-15'),
(3, 5, '2023-06-20'),
(4, 6, '2023-07-25'),
(5, 7, '2023-08-30'),
(6, 8, '2023-09-05'),
(7, 2, '2023-10-10'),
(8, 3, '2023-11-01'),
(9, 1, '2023-12-15'),
(10, 9, '2023-12-20');









