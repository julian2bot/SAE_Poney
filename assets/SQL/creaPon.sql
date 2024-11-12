-- creation des tables SQL : PONEY WEB


-- Formats :
-- Date au format ISO 8601 (YYYY-MM-DD)
-- Heure au format hh:mm
-- photo ==> lien vers le dossier images/photoPoney/ mettre juste le nom de l'image donc "michelLePoney.png" pas "images/photoPoney/michelLePoney.png"

CREATE TABLE PERSONNE(
    username VARCHAR(32),
    mdp VARCHAR(100),
    prenomPersonne VARCHAR(100),
    nomPersonne VARCHAR(100),
    mail VARCHAR(100) UNIQUE,
    
    PRIMARY KEY (username)
);

CREATE TABLE ADMINISTRATEUR(
    usernameAdmin VARCHAR(32), -- cle etrangere ==> username
    
    PRIMARY KEY (usernameAdmin),
    
    FOREIGN KEY (usernameAdmin) REFERENCES PERSONNE(username)
);

CREATE TABLE CLIENT(
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    dateInscription DATE,
    poidsClient TINYINT, 
    solde INT,
    
    PRIMARY KEY (usernameClient),
    
    FOREIGN KEY (usernameClient) REFERENCES PERSONNE(username)
);

CREATE TABLE MONITEUR(
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> username
    salaire DECIMAL(7,2),
    
    PRIMARY KEY (usernameMoniteur),
    
    FOREIGN KEY (usernameMoniteur) REFERENCES PERSONNE(username)
);

CREATE TABLE NIVEAU(
    idNiveau TINYINT,
    nomNiveau VARCHAR(30),
   
    PRIMARY KEY (idNiveau)
);

CREATE TABLE OBTENTION(
    username VARCHAR(30), -- cle etrangere ==> username
    idNiveau TINYINT, -- cle etrangere ==> idNiveau
    dateObtention DATE,
    
    PRIMARY KEY (username, idNiveau),
    
    FOREIGN KEY (username) REFERENCES PERSONNE(username),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE DISPONIBILITE(
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    heureDebutDispo DECIMAL(4,1) CHECK (heureDebutDispo BETWEEN 1 AND 24),
    dateDispo DATE,
    finHeureDispo DECIMAL(4,1) CHECK (heureDebutDispo BETWEEN 1 AND 24 AND heureDebutDispo < finHeureDispo),
    
    PRIMARY KEY (usernameMoniteur, heureDebutDispo, dateDispo),
    
    FOREIGN KEY (usernameMoniteur) REFERENCES MONITEUR(usernameMoniteur)
);

CREATE TABLE FACTURE_SOLDE(
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    idFacture INT,
    dateFacture DATE,
    montant SMALLINT CHECK (montant > 0),
    
    PRIMARY KEY (usernameClient, idFacture),
    
    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient)
);

CREATE TABLE COTISATION(
    
    nomCotisation VARCHAR(100),
    annees SMALLINT,
    prixCotisationAnnuelle SMALLINT CHECK (prixCotisationAnnuelle > 0),
    
    PRIMARY KEY (nomCotisation, annees)    
);

CREATE TABLE PAYER(

    nomCotisation VARCHAR(100),-- cle etrangere ==> nomCotisation
    anneesCoti SMALLINT,-- cle etrangere ==> annees de cotisation
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    
    PRIMARY KEY (nomCotisation, anneesCoti, usernameClient),
    
    FOREIGN KEY (nomCotisation, anneesCoti) REFERENCES COTISATION(nomCotisation, annees),
    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient)
);

CREATE TABLE RACE(
    nomRace VARCHAR(50),
    descriptionRace VARCHAR(255),
    
    PRIMARY KEY (nomRace)
);

CREATE TABLE PONEY(
    idPoney INT,
    nomPoney VARCHAR(30),
    poidsMax TINYINT,
    photo VARCHAR(30), 
    nomRace VARCHAR(50), -- cle etrangere ==> nomRace
    
    PRIMARY KEY (idPoney),
    
    FOREIGN KEY (nomRace) REFERENCES RACE(nomRace)
);


CREATE TABLE COURS(
    idCours INT,
    idNiveau TINYINT,  -- cle etrangere ==> idNiveau
    nomCours VARCHAR(30),
    duree INT CHECK (duree = 1 or duree = 2),
    prix SMALLINT,
    nbMax TINYINT CHECK (nbMax = 1 or nbMax = 10),
    
    PRIMARY KEY (idCours),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE REPRESENTATION(
    idCours INT, -- cle etrangere ==> idCours
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    dateCours DATE,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutCours BETWEEN 1 AND 24),
    activite VARCHAR(30),

    PRIMARY KEY (idCours, usernameMoniteur, dateCours, heureDebutCours),
    FOREIGN KEY (idCours) REFERENCES COURS(idCours),
    FOREIGN KEY (usernameMoniteur) REFERENCES MONITEUR(usernameMoniteur)
);

CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    dateCours DATE, -- cle etrangere ==> dateCours,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutCours BETWEEN 1 AND 24), -- cle etrangere ==> heureDebutCours,
    usernameClient VARCHAR(32), -- cle etrangere ==> usernameClient,
    idPoney INT, -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney),

    FOREIGN KEY (idCours, usernameMoniteur, dateCours, heureDebutCours) 
    REFERENCES REPRESENTATION(idCours, usernameMoniteur, dateCours, heureDebutCours 
    ),

    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);