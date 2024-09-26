-- creation des tables SQL : PONEY WEB


-- Formats :
-- Date au format ISO 8601 (YYYY-MM-DD)
-- Heure au format hh:mm
-- photo ==> lien vers le dossier images/photoPoney/ mettre juste le nom de l'image donc "michelLePoney.png" pas "images/photoPoney/michelLePoney.png"

CREATE TABLE PERSONNE(
    idPersonne INT,
    mdp VARCHAR(100),
    prenomPersonne VARCHAR(100),
    nomPersonne VARCHAR(100),
    mail VARCHAR(100),
    
    PRIMARY KEY (idPersonne)
);

CREATE TABLE CLIENT(
    idClient INT, -- cle etrangere ==> idPersonne
    dateInscription DATE,
    poidsClient TINYINT, 
    solde INT,
    
    PRIMARY KEY (idClient),
    
    FOREIGN KEY (idClient) REFERENCES PERSONNE(idPersonne)
);

CREATE TABLE MONITEUR(
    idMoniteur INT, -- cle etrangere ==> idPersonne
    salaire DECIMAL(5,2),
    
    PRIMARY KEY (idMoniteur),
    
    FOREIGN KEY (idMoniteur) REFERENCES PERSONNE(idPersonne)
);

CREATE TABLE NIVEAU(
    idNiveau TINYINT,
    nomNiveau VARCHAR(30),
   
    PRIMARY KEY (idNiveau)
);

CREATE TABLE OBTENTION(
    idPersonne INT, -- cle etrangere ==> idPersonne
    idNiveau TINYINT, -- cle etrangere ==> idNiveau
    dateObtention DATE,
    
    PRIMARY KEY (idPersonne, idNiveau),
    
    FOREIGN KEY (idPersonne) REFERENCES PERSONNE(idPersonne),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE DISPONIBILITE(
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    heureDebutDispo DECIMAL(2,1) CHECK (heureDebutDispo BETWEEN 1 AND 24),
    dateDispo DATE,
    finHeureDispo DECIMAL(2,1) CHECK (heureDebutDispo BETWEEN 1 AND 24 AND heureDebutDispo < finHeureDispo),
    
    PRIMARY KEY (idMoniteur, heureDebutDispo, dateDispo),
    
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

CREATE TABLE FACTURE_SOLDE(
    idClient INT, -- cle etrangere ==> idPersonne
    idFacture INT,
    dateFacture DATE,
    montant SMALLINT CHECK (montant > 0),
    
    PRIMARY KEY (idClient, idFacture),
    
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
);

CREATE TABLE COTISATION(
    idCotisation INT,
    nomCotisation VARCHAR(100),
    annees SMALLINT,
    prixCotisationAnnuelle SMALLINT CHECK (montant > 0),
    
    PRIMARY KEY (idCotisation)    
);

CREATE TABLE PAYER(
    idCotisation INT, -- cle etrangere ==> idCotisation
    idClient INT, -- cle etrangere ==> idPersonne
    
    PRIMARY KEY (idCotisation, idClient),
    
    FOREIGN KEY (idCotisation) REFERENCES COTISATION(idCotisation),
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
);

CREATE TABLE RACE(
    idRace SMALLINT,
    nomRace VARCHAR(50),
    descriptionRace VARCHAR(255),
    
    PRIMARY KEY (idRace)
);

CREATE TABLE PONEY(
    idPoney INT,
    nomPoney VARCHAR(30),
    poidsMax TINYINT,
    photo VARCHAR(30), 
    idRace SMALLINT, -- cle etrangere ==> idRace
    
    PRIMARY KEY (idPoney),
    
    FOREIGN KEY (idRace) REFERENCES RACE(idRace)
);

CREATE TABLE TYPE_COURS(
    idType TINYINT,
    nomType VARCHAR(30),
    nbMax TINYINT,
    
    PRIMARY KEY (idType)
);

CREATE TABLE COURS(
    idCours INT,
    idNiveau TINYINT,  -- cle etrangere ==> idNiveau
    idType TINYINT, -- cle etrangere ==> idType
    nomCours VARCHAR(30),
    duree INT CHECK (duree = 1 or duree = 2),
    prix SMALLINT,
    
    PRIMARY KEY (idCours, idNiveau, idType),
    
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau),
    FOREIGN KEY (idType) REFERENCES TYPE_COURS(idType)
);

CREATE TABLE REPRESENTATION(
    idCours INT, -- cle etrangere ==> idCours
    idNiveau TINYINT,  -- cle etrangere ==> idNiveau
    idType TINYINT, -- cle etrangere ==> idType
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateCours DATE,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutDispo BETWEEN 1 AND 24),
    activite VARCHAR(30),

    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateCours, heureDebutCours),
    FOREIGN KEY (idCours, idNiveau, idType) REFERENCES COURS(idCours, idNiveau, idType),
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    idNiveau TINYINT,  -- cle etrangere ==> idNiveau
    idType TINYINT, -- cle etrangere ==> idType
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateCours DATE, -- cle etrangere ==> dateCours,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutDispo BETWEEN 1 AND 24), -- cle etrangere ==> heureDebutCours,
    idClient INT, -- cle etrangere ==> idClient,
    idPoney INT, -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateCours, heureDebutCours, idClient, idPoney),

    FOREIGN KEY (idCours, idNiveau, idType, idMoniteur, dateCours, heureDebutCours) 
    REFERENCES REPRESENTATION(idCours, idNiveau, idType, idMoniteur, dateCours, heureDebutCours),

    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);