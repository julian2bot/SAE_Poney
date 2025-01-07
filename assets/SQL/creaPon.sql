-- creation des tables SQL : PONEY WEB


-- Formats :
-- Date au format ISO 8601 (YYYY-MM-DD)
-- Heure au format hh:mm
-- photo ==> lien vers le dossier images/photoPoney/ mettre juste le nom de l'image donc "michelLePoney.png" pas "images/photoPoney/michelLePoney.png"

CREATE TABLE PERSONNE(
    username VARCHAR(32),
    mdp VARCHAR(100) NOT NULL,
    prenomPersonne VARCHAR(100) NOT NULL,
    nomPersonne VARCHAR(100) NOT NULL,
    mail VARCHAR(100) UNIQUE NOT NULL,
    
    PRIMARY KEY (username)
);

CREATE TABLE CLIENT(
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    dateInscription DATE NOT NULL,
    poidsClient TINYINT NOT NULL, 
    solde INT NOT NULL DEFAULT 0,
    
    PRIMARY KEY (usernameClient)
);

ALTER TABLE CLIENT
ADD CONSTRAINT usernameClient_fk FOREIGN KEY (usernameClient)
REFERENCES PERSONNE(username)
ON UPDATE CASCADE;

CREATE TABLE MONITEUR(
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> username
    salaire DECIMAL(7,2) NOT NULL DEFAULT 0,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    
    PRIMARY KEY (usernameMoniteur)
);

ALTER TABLE MONITEUR
ADD CONSTRAINT usernameMoniteur_fk FOREIGN KEY (usernameMoniteur)
REFERENCES PERSONNE(username)
ON UPDATE CASCADE;


CREATE TABLE NIVEAU(
    idNiveau TINYINT,
    nomNiveau VARCHAR(30) NOT NULL DEFAULT "Niveau",
   
    PRIMARY KEY (idNiveau)
);

CREATE TABLE OBTENTION(
    username VARCHAR(30), -- cle etrangere ==> username
    idNiveau TINYINT, -- cle etrangere ==> idNiveau
    dateObtention DATE NOT NULL,
    
    PRIMARY KEY (username, idNiveau),
    
    FOREIGN KEY (username) REFERENCES PERSONNE(username),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE DISPONIBILITE(
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    heureDebutDispo DECIMAL(4,1) CHECK (heureDebutDispo BETWEEN 1 AND 24),
    dateDispo DATE,
    heureFinDispo DECIMAL(4,1) NOT NULL CHECK (heureDebutDispo BETWEEN 1 AND 24 AND heureDebutDispo < heureFinDispo),
    
    PRIMARY KEY (usernameMoniteur, heureDebutDispo, dateDispo)
);

ALTER TABLE DISPONIBILITE
ADD CONSTRAINT usernameMoniteurDisponibilite_fk FOREIGN KEY (usernameMoniteur)
REFERENCES MONITEUR(usernameMoniteur)
ON UPDATE CASCADE;


CREATE TABLE FACTURE_SOLDE(
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    idFacture INT,
    dateFacture DATE NOT NULL,
    montant SMALLINT NOT NULL DEFAULT 1 CHECK (montant > 0),
    
    PRIMARY KEY (usernameClient, idFacture)

);

ALTER TABLE FACTURE_SOLDE
ADD CONSTRAINT usernameClientSolde_fk FOREIGN KEY (usernameClient)
REFERENCES CLIENT(usernameClient)
ON UPDATE CASCADE;

CREATE TABLE COTISATION(
    
    nomCotisation VARCHAR(100),
    periode VARCHAR(9),
    prixCotisationAnnuelle SMALLINT NOT NULL CHECK (prixCotisationAnnuelle > 0),
    
    PRIMARY KEY (nomCotisation, periode)    
);

CREATE TABLE PAYER(
    nomCotisation VARCHAR(100),-- cle etrangere ==> nomCotisation
    periode VARCHAR(9),-- cle etrangere ==> annees de cotisation
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    
    PRIMARY KEY (nomCotisation, periode, usernameClient),
    
    FOREIGN KEY (nomCotisation, periode) REFERENCES COTISATION(nomCotisation, periode)
);

ALTER TABLE PAYER
ADD CONSTRAINT usernameClientPayer_fk FOREIGN KEY (usernameClient)
REFERENCES CLIENT(usernameClient)
ON UPDATE CASCADE;

CREATE TABLE RACE(
    nomRace VARCHAR(50),
    descriptionRace VARCHAR(255) NOT NULL DEFAULT "Description",
    
    PRIMARY KEY (nomRace)
);

CREATE TABLE PONEY(
    idPoney INT,
    nomPoney VARCHAR(30) NOT NULL,
    poidsMax TINYINT NOT NULL DEFAULT 0,
    photo VARCHAR(30) NOT NULL, 
    nomRace VARCHAR(50), -- cle etrangere ==> nomRace
    
    PRIMARY KEY (idPoney),
    
    FOREIGN KEY (nomRace) REFERENCES RACE(nomRace)
);

CREATE TABLE COURS(
    idCours INT,
    idNiveau TINYINT NOT NULL,  -- cle etrangere ==> idNiveau
    nomCours VARCHAR(30) NOT NULL DEFAULT "Cours",
    duree TINYINT NOT NULL DEFAULT 1 CHECK (duree = 1 or duree = 2),
    prix SMALLINT NOT NULL DEFAULT 0,
    nbMax TINYINT NOT NULL DEFAULT 10 CHECK (nbMax = 1 or nbMax = 10),
    
    PRIMARY KEY (idCours),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE REPRESENTATION(
    idCours INT, -- cle etrangere ==> idCours
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    dateCours DATE,
    heureDebutCours DECIMAL(3,1) CHECK (heureDebutCours BETWEEN 1 AND 24),
    activite VARCHAR(30),

    PRIMARY KEY (idCours, usernameMoniteur, dateCours, heureDebutCours),
    FOREIGN KEY (idCours) REFERENCES COURS(idCours)
);

ALTER TABLE REPRESENTATION
ADD CONSTRAINT usernameMoniteurRepresentation_fk FOREIGN KEY (usernameMoniteur)
REFERENCES MONITEUR(usernameMoniteur)
ON UPDATE CASCADE;


CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    dateCours DATE, -- cle etrangere ==> dateCours,
    heureDebutCours DECIMAL(3,1), -- cle etrangere ==> heureDebutCours,
    usernameClient VARCHAR(32), -- cle etrangere ==> usernameClient,
    idPoney INT, -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney),

    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);

ALTER TABLE RESERVATION
ADD CONSTRAINT reservationRepresentation_fk FOREIGN KEY (idCours, usernameMoniteur, dateCours, heureDebutCours)
REFERENCES REPRESENTATION(idCours, usernameMoniteur, dateCours, heureDebutCours)
ON UPDATE CASCADE;

ALTER TABLE RESERVATION
ADD CONSTRAINT usernameClientReservation_fk FOREIGN KEY (usernameClient)
REFERENCES CLIENT(usernameClient)
ON UPDATE CASCADE;


--  pour debug

-- CREATE TABLE log_table (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     log_date DATETIME DEFAULT CURRENT_TIMESTAMP,
--     log_message TEXT
-- );
