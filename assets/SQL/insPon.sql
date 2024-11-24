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
INSERT INTO PERSONNE (username, mdp, prenomPersonne, nomPersonne, mail) VALUES
('moniteur1', 'mdp123', 'Alice', 'Martin', 'alice.martin@poneyclub.com'),
('moniteur2', 'mdp123', 'Pierre', 'Dupont', 'pierre.dupont@poneyclub.com'),
('moniteur3', 'mdp123', 'Sophie', 'Leroy', 'sophie.leroy@poneyclub.com'),
('moniteur4', 'mdp123', 'Ban', 'Leroy', 'Ban.leroy@poneyclub.com'),
('client1', 'mdp123', 'Julien', 'Bernard', 'julien.bernard@client.com'),
('client2', 'mdp123', 'Claire', 'Petit', 'claire.petit@client.com'),
('client3', 'mdp123', 'Lucas', 'Blanc', 'lucas.blanc@client.com'),
('client4', 'mdp123', 'Marie', 'Moreau', 'marie.moreau@client.com'),
('client5', 'mdp123', 'Paul', 'Dumont', 'paul.dumont@client.com'),
('client6', 'mdp123', 'Emma', 'Garnier', 'emma.garnier@client.com'),
('client7', 'mdp123', 'Léo', 'Lemoine', 'leo.lemoine@client.com'),
('client8', 'mdp123', 'Chloé', 'Perrot', 'chloe.perrot@client.com'),
('client9', 'mdp123', 'Hugo', 'Roussel', 'hugo.roussel@client.com'),
('client10', 'mdp123', 'Anaïs', 'Fischer', 'anais.fischer@client.com'),
('client11', 'mdp123', 'Lucas', 'Fabre', 'lucas.fabre@client.com'),
('client12', 'mdp123', 'Julie', 'Olivier', 'julie.olivier@client.com'),
('client13', 'mdp123', 'Thomas', 'Michel', 'thomas.michel@client.com'),
('client14', 'mdp123', 'Sarah', 'Renaud', 'sarah.renaud@client.com'),
('client15', 'mdp123', 'Nina', 'Jacquet', 'nina.jacquet@client.com');


-- Insertion pour la table MONITEUR
INSERT INTO MONITEUR (usernameMoniteur, salaire, isAdmin) VALUES
('moniteur1', 2500.00, 1),
('moniteur2', 2300.00, 0),
('moniteur3', 2200.00, 0),
('moniteur4', 1.00, 0);

-- Insertion pour la table OBTENTION
INSERT INTO OBTENTION ( username ,idNiveau,dateObtention) VALUES  
('moniteur1',11, '2023-12-01'),
('moniteur2',11, '2023-12-01'),
('moniteur3',11, '2023-12-01'),
('moniteur4',2, '2023-12-01'),
('client1',  8 , '2023-12-01'),
('client1',  11 , '2023-12-01'),
('client2',  8 , '2023-12-01'), 
('client3',  8 , '2023-12-01'),
('client4',  8 , '2023-12-01'),
('client5',  11 , '2023-12-01'),
('client6',  10 , '2023-12-01'),
('client7',  11 , '2023-12-01'),
('client8',  8 , '2023-12-01'),
('client9',  8 , '2023-12-01'),
('client10', 8 , '2023-12-01'),
('client11', 8 , '2023-12-01'),
('client12', 8 , '2023-12-01'),
('client13', 8 , '2023-12-01'),
('client14', 8 , '2023-12-01'),
('client15', 8 , '2023-12-01');

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

INSERT INTO PAYER (nomCotisation, periode, usernameClient) VALUES 
('Cotisation A', '2024-2025', 'client1'),
('Cotisation B', '2024-2025', 'client2'),
('Cotisation B', '2024-2025', 'client5'),
('Cotisation C', '2024-2025', 'client6'),

('Cotisation A', '2023-2024', 'client1'),
('Cotisation A', '2023-2024', 'client2'),
('Cotisation C', '2023-2024', 'client3'),
('Cotisation C', '2023-2024', 'client4'),
('Cotisation A', '2023-2024', 'client5'),
('Cotisation A', '2023-2024', 'client6'),
('Cotisation C', '2023-2024', 'client7'),
('Cotisation B', '2023-2024', 'client8'),
('Cotisation B', '2023-2024', 'client9'),
('Cotisation A', '2023-2024', 'client10'),
('Cotisation B', '2023-2024', 'client11'),

('Cotisation C', '2022-2023', 'client15'),
('Cotisation A', '2022-2023', 'client1'),
('Cotisation C', '2022-2023', 'client3'),

('Cotisation C', '2021-2022', 'client6'),
('Cotisation A', '2021-2022', 'client7');

-- Insertion pour la table COURS
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(1, 5, 'Initiation Galop 1', 1, 30, 10),
(2, 6, 'Initiation Galop 2', 1, 35, 10),
(3, 7, 'Perfectionnement Galop 3', 2, 40, 1),
(4, 8, 'Stage Galop 4', 2, 45, 10),
(5, 9, 'Cours Galop 5', 2, 50, 1),
(6, 10, 'Cours Galop 6', 2, 60, 1),
(7, 11, 'Cours Galop 7', 2, 70, 1),
(8, 1, 'Cours Débutant', 1, 20, 10),
(9, 3, 'Cours Confirmé', 1, 30, 10),
(10, 4, 'Cours Avancé', 1, 35, 10),
(14, 4, 'Cours Avancé', 1, 35, 10),
(15, 4, 'Perfectionnement Galop 3', 2, 35, 10),
(16, 4, 'Perfectionnement Galop 3', 2, 35, 10);

-- Insertion pour la table PONEY
INSERT INTO PONEY (idPoney, nomPoney, poidsMax, photo, nomRace) VALUES
(1, 'Flocon', 80, 'flocon.jpg', 'Shetland'),
(2, 'Caramel', 60, 'caramel.jpg', 'Connemara'),
(3, 'Eclair', 50, 'eclair.jpg', 'Dartmoor'),
(4, 'Noisette', 65, 'noisette.jpg', 'Welsh'),
(5, 'Tonnerre', 70, 'tonnerre.jpg', 'Pottok'),
(6, 'Neige', 60, 'neige.jpg', 'Fjord'),
(7, 'Alezan', 55, 'alezan.jpg', 'New Forest'),
(8, 'Luna', 58, 'luna.jpg', 'Shetland'),
(9, 'Biscuit', 65, 'biscuit.jpg', 'Connemara'),
(10, 'Rêve', 53, 'reve.jpg', 'Dartmoor'),
(11, 'scarabcia', 90, 'scarabcia.jpg', 'Dartmoor');

-- Insertion pour la table DISPONIBILITE
INSERT INTO DISPONIBILITE (usernameMoniteur, heureDebutDispo, dateDispo, heureFinDispo) VALUES
('moniteur1', 2.0, '2023-12-01', 24.0),
('moniteur1', 9.0, '2023-12-20', 12.0),
('moniteur1', 14.0, '2023-12-20', 18.0),
('moniteur2', 10.0, '2023-12-21', 13.0),
('moniteur2', 15.0, '2023-12-21', 18.0),
('moniteur3', 9.0, '2023-12-22', 11.0),
('moniteur3', 13.0, '2023-12-22', 17.0),
('moniteur4', 2.0, '2023-12-22', 17.0),
('moniteur1', 9.0, '2023-12-23', 12.0),
('moniteur2', 10.0, '2023-12-24', 13.0),
('moniteur3', 14.0, '2023-12-25', 17.0),
('moniteur1', 15.0, '2023-12-26', 18.0),
('moniteur4',2.0,'2023-12-06', 17.0);

INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(1, 'moniteur1', '2023-12-20', 9.0),  -- Disponible entre 9h et 12h
(2, 'moniteur1', '2023-12-20', 14.0), -- Disponible entre 14h et 18h
(3, 'moniteur2', '2023-12-21', 10.0), -- Disponible entre 10h et 13h
(4, 'moniteur2', '2023-12-21', 15.0), -- Disponible entre 15h et 18h
(5, 'moniteur3', '2023-12-22', 9.0),  -- Disponible entre 9h et 11h
(6, 'moniteur3', '2023-12-22', 13.0), -- Disponible entre 13h et 17h
(7, 'moniteur1', '2023-12-23', 9.0),  -- Disponible entre 9h et 12h
(8, 'moniteur2', '2023-12-24', 10.0), -- Disponible entre 10h et 13h
(9, 'moniteur3', '2023-12-25', 14.0), -- Disponible entre 14h et 17h
(10, 'moniteur1', '2023-12-26', 15.0), -- Disponible entre 15h et 18h

(1, 'moniteur1', '2023-12-01', 10.0),
(1, 'moniteur1', '2023-12-01', 11.0),
(3, 'moniteur1', '2023-12-01', 14.0),
(3, 'moniteur1', '2023-12-01', 18.0),
(3, 'moniteur1', '2023-12-01', 21.0);

INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(1, 'moniteur1', '2023-12-20', 9.0, 'client1', 1),
(2, 'moniteur1', '2023-12-20', 14.0, 'client2', 2),
(3, 'moniteur2', '2023-12-21', 10.0, 'client3', 3),
(4, 'moniteur2', '2023-12-21', 15.0, 'client4', 4),
(5, 'moniteur3', '2023-12-22', 9.0, 'client5', 5),
(6, 'moniteur3', '2023-12-22', 13.0, 'client6', 6),
(7, 'moniteur1', '2023-12-23', 9.0, 'client7', 7),
(8, 'moniteur2', '2023-12-24', 10.0, 'client8', 8),
(9, 'moniteur3', '2023-12-25', 14.0, 'client9', 9),
(10, 'moniteur1', '2023-12-26', 15.0, 'client10', 10),

(1, 'moniteur1', '2023-12-01', 10.0, 'client1', 1),
(1, 'moniteur1', '2023-12-01', 11.0, 'client1', 1),
(3, 'moniteur1', '2023-12-01', 14.0, 'client1', 1),
-- (3, 'moniteur1', '2023-12-01', 21.0, 'client1', 1), Censé passé
(3, 'moniteur1', '2023-12-01', 18.0, 'client1', 1);


----------------------------------------------------------------------------------
------------------------- Inserts qui ne fonctionnes pas -------------------------
----------------------------------------------------------------------------------

/*
-- Insertion pour la table CLIENT avec trigger
INSERT INTO CLIENT (usernameClient, dateInscription, poidsClient, solde) VALUES
('moniteur3', '2022-05-30', 55,60); --marche



-- Insertion pour la table MONITEUR avec trigger
INSERT INTO MONITEUR (usernameMoniteur, salaire, isAdmin) VALUES
('client15', 2200.00, 0); --marche
*/


/*
-- Insertion dans la table REPRESENTATION pour le trigger niveauMoniteur_avant_representer
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(14, 'moniteur4', '2023-12-06', 14.0);
*/


/*
-- Insertion dans la table REPRESENTATION pour le trigger court_deja_present_avant_representer
--(14, 'moniteur4', '2023-12-06', 14.0);
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
  (15, 'moniteur4', '2023-12-06', 14.0);
*/

/*
-- Insertion dans la table REPRESENTATION pour le trigger cours_hors_planning
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
  (15, 'moniteur4', '2023-12-06', 1.0);


-- Insertion dans la table REPRESENTATION pour le trigger cours_hors_planning
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
  (15, 'moniteur4', '2023-12-06', 16.0);



-- Insertion dans la table REPRESENTATION pour le trigger court_deja_present_1h_apres_representer
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
  (16, 'moniteur4', '2023-12-06', 15.0),
  (15, 'moniteur4', '2023-12-06', 14.0);
  */


  -- Insertion dans la table REPRESENTATION pour le trigger court_deja_present_1h_apres_representer
-- INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
--   (15, 'moniteur4', '2023-12-06', 14.0),
--   (16, 'moniteur4', '2023-12-06', 15.0);




/*
-- Insertion dans la table RESERVATION pour le trigger niveauMoniteur_avant_representer
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(14, 'moniteur4', '2023-12-06', 14.0, 'client10', 10);

/*
-- Insertion dans la table RESERVATION pour le trigger poidx max
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(11, 'moniteur1', '2023-10-10', 18.0, 'client9', 10)



-- Insertion pour la table COURS pour le trigger reste_place
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(11, 4, 'Cours Avancé', 1, 35, 1);

-- Insertion dans la table RESERVATION  pour le trigger reste_place
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(11, 'moniteur1', '2023-10-10', 18.0);

-- Insertion dans la table RESERVATION  pour le trigger reste_place
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(11, 'moniteur1', '2023-10-10', 18.0, 'client1', 1),
(11, 'moniteur1', '2023-10-10', 18.0, 'client2', 2),
(11, 'moniteur1', '2023-10-10', 18.0, 'client3', 3),
(11, 'moniteur1', '2023-10-10', 18.0, 'client4', 4),
(11, 'moniteur1', '2023-10-10', 18.0, 'client5', 5),
(11, 'moniteur1', '2023-10-10', 18.0, 'client6', 6),
(11, 'moniteur1', '2023-10-10', 18.0, 'client7', 7),
(11, 'moniteur1', '2023-10-10', 18.0, 'client8', 8),
(11, 'moniteur1', '2023-10-10', 18.0, 'client9', 9),
(11, 'moniteur1', '2023-10-10', 18.0, 'client10', 10),
(11, 'moniteur1', '2023-10-10', 18.0, 'client11', 10);


-- Insertion pour la table COURS pour le trigger niveauClient_avant_reserve
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(11, 11, 'Cours Avancé', 1, 35, 1);

-- Insertion dans la table RESERVATION  pour le trigger niveauClient_avant_reserve
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(11, 'moniteur1', '2023-10-10', 18.0);

-- Insertion dans la table RESERVATION  pour le trigger niveauClient_avant_reserve
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(11, 'moniteur1', '2023-10-10', 18.0, 'client1', 1),
(11, 'moniteur1', '2023-10-10', 18.0, 'client2', 2),
(11, 'moniteur1', '2023-10-10', 18.0, 'client3', 3),
(11, 'moniteur1', '2023-10-10', 18.0, 'client4', 4),
(11, 'moniteur1', '2023-10-10', 18.0, 'client5', 5),
(11, 'moniteur1', '2023-10-10', 18.0, 'client6', 6),
(11, 'moniteur1', '2023-10-10', 18.0, 'client7', 7),
(11, 'moniteur1', '2023-10-10', 18.0, 'client8', 8),
(11, 'moniteur1', '2023-10-10', 18.0, 'client9', 9),
(11, 'moniteur1', '2023-10-10', 18.0, 'client10', 10),
(11, 'moniteur1', '2023-10-10', 18.0, 'client11', 10);


-- Insertion pour la table COURS pour le trigger cotisation_payer_avant_reserve
INSERT INTO COURS (idCours, idNiveau, nomCours, duree, prix, nbMax) VALUES
(12, 4, 'Cours Avancé', 1, 35, 1);

-- Insertion dans la table RESERVATION  pour le trigger cotisation_payer_avant_reserve
INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(12, 'moniteur1', '2022-10-10', 18.0);


-- Insertion dans la table RESERVATION  pour le trigger cotisation_payer_avant_reserve
INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(12, 'moniteur1', '2022-10-10', 18.0, 'client4', 1);


-- Insertion pour la table PAYER
INSERT INTO PAYER (nomCotisation, periode, usernameClient) VALUES 
('Cotisation A', '2024-2025', 'client2');

*/

-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
-- (1, 'moniteur1', '2023-12-20', 9.0, 'client1', 1),
-- (2, 'moniteur1', '2023-12-20', 14.0, 'client2', 1),
-- (3, 'moniteur2', '2023-12-20', 10.0, 'client3', 1),
-- (4, 'moniteur2', '2023-12-20', 15.0, 'client4', 1),
-- (5, 'moniteur3', '2023-12-20', 9.0, 'client5', 1),
-- (6, 'moniteur3', '2023-12-20', 13.0, 'client6', 1),
-- (7, 'moniteur1', '2023-12-20', 9.0, 'client7', 1),
-- (8, 'moniteur2', '2023-12-20', 10.0, 'client8', 1),
-- (9, 'moniteur3', '2023-12-20', 14.0, 'client9', 1),
-- (10, 'moniteur1', '2023-12-20', 15.0, 'client10', 1);


