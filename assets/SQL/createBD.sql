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
    poidsClient INT, 
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
    idNiveau INT,
    nomNiveau VARCHAR(30),
   
    PRIMARY KEY (idNiveau)
);

CREATE TABLE OBTENTION(
    idPersonne INT, -- cle etrangere ==> idPersonne
    idNiveau INT, -- cle etrangere ==> idNiveau
    dateObtention DATE,
    
    PRIMARY KEY (idPersonne, idNiveau),
    
    FOREIGN KEY (idPersonne) REFERENCES PERSONNE(idPersonne),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

CREATE TABLE DISPONIBILITE(
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    heureDebutDispo INT, 
    dateDispo DATE,
    finHeureDispo INT,
    
    PRIMARY KEY (idMoniteur, heureDebutDispo, dateDispo),
    
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

CREATE TABLE FACTURE_SOLDE(
    idClient INT, -- cle etrangere ==> idPersonne
    idFacture INT,
    dateFacture DATE,
    montant INT,
    
    PRIMARY KEY (idClient, idFacture),
    
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
);

CREATE TABLE COTISATION(
    idCotisation INT,
    nomCotisation VARCHAR(100),
    annees INT,
    prixCotisationAnnuelle INT,
    
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
    idRace INT,
    nomRace VARCHAR(50),
    descriptionRace VARCHAR(255),
    
    PRIMARY KEY (idRace)
);

CREATE TABLE PONEY(
    idPoney INT,
    nomPoney VARCHAR(30),
    poidsMax INT,
    photo VARCHAR(30), 
    idRace INT, -- cle etrangere ==> idRace
    
    PRIMARY KEY (idPoney),
    
    FOREIGN KEY (idRace) REFERENCES RACE(idRace)
);

CREATE TABLE TYPE_COURS(
    idType INT,
    nomType VARCHAR(30),
    nbMax INT,
    
    PRIMARY KEY (idType)
);

CREATE TABLE COURS(
    idCours INT,
    idNiveau INT,  -- cle etrangere ==> idNiveau
    idType INT, -- cle etrangere ==> idType
    nomCours VARCHAR(30),
    duree INT CHECK (duree = 1 or duree = 2),
    prix INT,
    
    PRIMARY KEY (idCours, idNiveau, idType),
    
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau),
    FOREIGN KEY (idType) REFERENCES TYPE_COURS(idType)
);

CREATE TABLE REPRESENTATION(
    idCours INT, -- cle etrangere ==> idCours
    idNiveau INT,  -- cle etrangere ==> idNiveau
    idType INT, -- cle etrangere ==> idType
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateDebutCours DATE,
    heureDebutCours INT,
    activite VARCHAR(30),

    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCours),
    FOREIGN KEY (idCours, idNiveau, idType) REFERENCES COURS(idCours, idNiveau, idType),
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    idNiveau INT,  -- cle etrangere ==> idNiveau
    idType INT, -- cle etrangere ==> idType
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateDebutCours DATE -- cle etrangere ==> dateDebutCours,
    heureDebutCours INT -- cle etrangere ==> heureDebutCours,
    idClient INT -- cle etrangere ==> idClient,
    idPoney INT -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCours, idClient, idPoney),

    FOREIGN KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCours) 
    REFERENCES REPRESENTATION(idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCours),

    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);