-- Insertion pour la table NIVEAU
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
(10, 'Galop 6'),
(11, 'Galop 7');

-- Insertion pour la table RACE
INSERT INTO RACE (nomRace, descriptionRace) VALUES
('Shetland', 'Petit poney robuste originaire des îles Shetland'),
('Connemara', 'Poney irlandais polyvalent et apprécié pour son caractère doux'),
('Dartmoor', 'Race de poney britannique, idéale pour les jeunes cavaliers'),
('Welsh', 'Poney gallois élégant et dynamique'),
('Pottok', 'Poney des montagnes basques, résistant et endurant'),
('Fjord', 'Race de poney scandinave, utilisée pour des travaux légers'),
('New Forest', 'Poney britannique de grande taille, polyvalent et calme');

INSERT INTO COTISATION (nomCotisation, periode, prixCotisationAnnuelle) VALUES 
('Cotisation A', '2024-2025', 120),
('Cotisation B', '2024-2025', 150),
('Cotisation C', '2024-2025', 200),

('Cotisation A', '2023-2024', 115),
('Cotisation B', '2023-2024', 145),
('Cotisation C', '2023-2024', 195),

('Cotisation A', '2022-2023', 110),
('Cotisation B', '2022-2023', 140),
('Cotisation C', '2022-2023', 190),

('Cotisation A', '2021-2022', 105),
('Cotisation B', '2021-2022', 135),
('Cotisation C', '2021-2022', 185);

-- Insertion pour la table PERSONNE (incluant moniteurs et clients)
-- Mdp : mdp123
INSERT INTO PERSONNE (username, mdp, prenomPersonne, nomPersonne, mail) VALUES
('moniteur1', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Alice', 'Martin', 'alice.martin@poneyclub.com'),
('moniteur2', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Pierre', 'Dupont', 'pierre.dupont@poneyclub.com'),
('moniteur3', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Sophie', 'Leroy', 'sophie.leroy@poneyclub.com'),
('client1', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Julien', 'Bernard', 'julien.bernard@client.com'),
('client2', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Claire', 'Petit', 'claire.petit@client.com'),
('client3', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Lucas', 'Blanc', 'lucas.blanc@client.com'),
('client4', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Marie', 'Moreau', 'marie.moreau@client.com'),
('client5', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Paul', 'Dumont', 'paul.dumont@client.com'),
('client6', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Emma', 'Garnier', 'emma.garnier@client.com'),
('client7', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Léo', 'Lemoine', 'leo.lemoine@client.com'),
('client8', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Chloé', 'Perrot', 'chloe.perrot@client.com'),
('client9', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Hugo', 'Roussel', 'hugo.roussel@client.com'),
('client10', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Anaïs', 'Fischer', 'anais.fischer@client.com'),
('client11', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Lucas', 'Fabre', 'lucas.fabre@client.com'),
('client12', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Julie', 'Olivier', 'julie.olivier@client.com'),
('client13', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Thomas', 'Michel', 'thomas.michel@client.com'),
('client14', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Sarah', 'Renaud', 'sarah.renaud@client.com'),
('client15', 'ae3fc6fbe0c483e288ed135d174a3b5a2d4d733a', 'Nina', 'Jacquet', 'nina.jacquet@client.com');

-- Insertion pour la table MONITEUR
INSERT INTO MONITEUR (usernameMoniteur, salaire, isAdmin) VALUES
('moniteur1', 2500.00, 1),
('moniteur2', 2300.00, 0),
('moniteur3', 2200.00, 0);

-- Insertion pour la table CLIENT
INSERT INTO CLIENT (usernameClient, dateInscription, poidsClient, solde) VALUES
('client1', '2022-01-15', 60, 200),
('client2', '2021-11-20', 50, 150),
('client3', '2023-03-10', 45, 100),
('client4', '2022-04-25', 55, 300),
('client5', '2022-09-01', 65, 250),
('client6', '2023-06-30', 52, 100),
('client7', '2021-12-12', 58, 80),
('client8', '2023-05-05', 47, 50),
('client9', '2022-07-14', 63, 150),
('client10', '2023-08-21', 49, 0),
('client11', '2023-09-10', 54, 100),
('client12', '2022-10-15', 59, 90),
('client13', '2021-09-09', 60, 75),
('client14', '2023-03-30', 62, 120),
('client15', '2022-02-25', 55, 60);

INSERT INTO OBTENTION (username, idNiveau, dateObtention) VALUES
('client1', 1, '2025-01-01'),
('client2', 2, '2025-01-02'),
('client3', 3, '2025-01-03'),
('client4', 1, '2025-01-04'),
('client5', 2, '2025-01-05'),
('client6', 3, '2025-01-06'),
('client7', 1, '2025-01-07'),
('client8', 2, '2025-01-08'),
('client9', 3, '2025-01-09'),
('client10', 1, '2025-01-10'),
('client11', 2, '2025-01-11'),
('client12', 3, '2025-01-12'),
('client13', 1, '2025-01-13'),
('client14', 2, '2025-01-14'),
('client15', 3, '2025-01-15'),
('moniteur1', 2, '2025-01-17'),
('moniteur3', 3, '2025-01-18');

INSERT INTO PAYER (nomCotisation, periode, usernameClient) VALUES 
('Cotisation A', '2024-2025', 'client1'),
('Cotisation B', '2024-2025', 'client2'),
('Cotisation B', '2024-2025', 'client5'),
('Cotisation C', '2024-2025', 'client6'),

('Cotisation B', '2023-2024', 'client8'),
('Cotisation A', '2023-2024', 'client10'),
('Cotisation B', '2023-2024', 'client11'),

('Cotisation C', '2022-2023', 'client15'),
('Cotisation A', '2022-2023', 'client1'),
('Cotisation C', '2022-2023', 'client3'),

('Cotisation C', '2021-2022', 'client6'),
('Cotisation A', '2021-2022', 'client7');


-- Insertion pour la table COURS
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(1, 1, 'Cours perso niveau 1, 1h', 1, 30, 1),
(2, 2, 'Cours perso niveau 2, 1h', 1, 30, 1),
(3, 3, 'Cours perso niveau 3, 1h', 1, 30, 1),
(4, 4, 'Cours perso niveau 4, 1h', 1, 30, 1),
(5, 5, 'Cours perso niveau 5, 1h', 1, 30, 1),
(6, 6, 'Cours perso niveau 6, 1h', 1, 30, 1),
(7, 7, 'Cours perso niveau 7, 1h', 1, 30, 1),
(8, 8, 'Cours perso niveau 8, 1h', 1, 30, 1),
(9, 9, 'Cours perso niveau 9, 1h', 1, 30, 1),
(10, 10, 'Cours perso niveau 10, 1h', 1, 30, 1),
(11, 11, 'Cours perso niveau 11, 1h', 1, 30, 1),

(12, 1, 'Cours perso niveau 1, 2h', 2, 60, 1),
(13, 2, 'Cours perso niveau 2, 2h', 2, 60, 1),
(14, 3, 'Cours perso niveau 3, 2h', 2, 60, 1),
(15, 4, 'Cours perso niveau 4, 2h', 2, 60, 1),
(16, 5, 'Cours perso niveau 5, 2h', 2, 60, 1),
(17, 6, 'Cours perso niveau 6, 2h', 2, 60, 1),
(18, 7, 'Cours perso niveau 7, 2h', 2, 60, 1),
(19, 8, 'Cours perso niveau 8, 2h', 2, 60, 1),
(20, 9, 'Cours perso niveau 9, 2h', 2, 60, 1),
(21, 10, 'Cours perso niveau 10, 2h', 2, 60, 1),
(22, 11, 'Cours perso niveau 11, 2h', 2, 60, 1),

(23, 5, 'Initiation Galop 1', 1, 30, 10), -- 1
(24, 6, 'Initiation Galop 2', 1, 35, 10), -- 2
(25, 7, 'Perfectionnement Galop 3', 2, 40, 1), -- 3
(26, 8, 'Stage Galop 4', 2, 45, 10), -- 4
(27, 9, 'Cours Galop 5', 2, 50, 1), -- 5
(28, 10, 'Cours Galop 6', 2, 60, 1), -- 6
(29, 11, 'Cours Galop 7', 2, 70, 1), -- 7
(30, 1, 'Cours Débutant', 1, 20, 10), -- 8
(31, 3, 'Cours Confirmé', 1, 30, 10), -- 9
(32, 4, 'Cours Avancé', 1, 35, 10); -- 10

-- Insertion pour la table PONEY
INSERT INTO PONEY (idPoney, nomPoney, poidsMax, photo, nomRace) VALUES
(1, 'Flocon', 55, 'flocon.jpg', 'Shetland'),
(2, 'Caramel', 60, 'caramel.jpg', 'Connemara'),
(3, 'Eclair', 50, 'eclair.jpg', 'Dartmoor'),
(4, 'Noisette', 65, 'noisette.jpg', 'Welsh'),
(5, 'Tonnerre', 70, 'tonnerre.jpg', 'Pottok'),
(6, 'Neige', 60, 'neige.jpg', 'Fjord'),
(7, 'Alezan', 55, 'alezan.jpg', 'New Forest'),
(8, 'Luna', 58, 'luna.jpg', 'Shetland'),
(9, 'Biscuit', 65, 'biscuit.jpg', 'Connemara'),
(10, 'Rêve', 53, 'reve.jpg', 'Dartmoor');

-- Insertion pour la table DISPONIBILITE
INSERT INTO DISPONIBILITE (usernameMoniteur, heureDebutDispo, dateDispo, heureFinDispo) VALUES
('moniteur1', 9.0, '2023-11-20', 12.0),
('moniteur1', 14.0, '2023-11-20', 18.0),
('moniteur2', 10.0, '2023-11-21', 13.0),
('moniteur2', 15.0, '2023-11-21', 18.0),
('moniteur3', 9.0, '2023-11-22', 11.0),
('moniteur3', 13.0, '2023-11-22', 17.0),
('moniteur1', 9.0, '2023-11-23', 12.0),
('moniteur2', 10.0, '2023-11-24', 13.0),
('moniteur3', 14.0, '2023-11-25', 17.0),
('moniteur1', 15.0, '2023-11-26', 18.0);

-- Insertion dans la table REPRESENTATION
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(23, 'moniteur1', '2023-12-01', 10.0),
(23, 'moniteur1', '2023-12-01', 11.0),
(25, 'moniteur1', '2023-12-01', 14.0),
(25, 'moniteur1', '2023-12-01', 18.0),
(25, 'moniteur1', '2023-12-01', 21.0),

(24, 'moniteur1', '2023-12-02', 11.0),
(25, 'moniteur2', '2023-12-03', 9.5),
(26, 'moniteur2', '2023-12-04', 10.5),
(27, 'moniteur3', '2023-12-05', 11.0),
(28, 'moniteur3', '2023-12-06', 14.0),
(29, 'moniteur1', '2023-12-07', 15.0),
(30, 'moniteur2', '2023-12-08', 16.0),
(31, 'moniteur3', '2023-12-09', 17.0),
(32, 'moniteur1', '2023-12-10', 18.0);

-- Insertion dans la table RESERVATION
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(23, 'moniteur1', '2023-12-01', 10.0, 'client1', 1),
(23, 'moniteur1', '2023-12-01', 11.0, 'client1', 1),
(25, 'moniteur1', '2023-12-01', 14.0, 'client1', 1),
(25, 'moniteur1', '2023-12-01', 18.0, 'client1', 1),
-- (3, 'moniteur1', '2023-12-01', 21.0, 'client1', 1), Censé passé

(24, 'moniteur1', '2023-12-02', 11.0, 'client2', 2),
(25, 'moniteur2', '2023-12-03', 9.5, 'client3', 3),
(26, 'moniteur2', '2023-12-04', 10.5, 'client4', 4),
(27, 'moniteur3', '2023-12-05', 11.0, 'client5', 5),
(28, 'moniteur3', '2023-12-06', 14.0, 'client6', 6),
(29, 'moniteur1', '2023-12-07', 15.0, 'client7', 7),
(30, 'moniteur2', '2023-12-08', 16.0, 'client8', 8),
(31, 'moniteur3', '2023-12-09', 17.0, 'client9', 9),
(32, 'moniteur1', '2023-12-10', 18.0, 'client10', 10);

-- idPoneyF idCours usernameMoniteur dateCoursF heureDebutCoursF dureeCours
-- select poneyDispo(1,3, 'moniteur1', '2023-12-01', 8.0, 2); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 10.0, 1); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 12.0, 1); 
-- select poneyDispo(1,3, 'moniteur1', '2023-12-01', 13.0, 2); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 17.0, 1); -- Censé ne pas passé 
-- select poneyDispo(1,3, 'moniteur1', '2023-12-01', 17.0, 2); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 20.0, 1); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 22.0, 1); 
-- select poneyDispo(1,1, 'moniteur1', '2023-12-01', 23.0, 1); 


INSERT INTO DEMANDECOURS (usernameClient, idCours, idPoney, dateCours, heureDebutCours, demande) VALUES
("client1", 2, 1, "2024-12-01", 17,"faire du poney nan?"),
("client2", 2, 1, "2024-12-01", 20.5,"faire du poney nan?");

