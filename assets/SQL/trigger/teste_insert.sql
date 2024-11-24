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