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
    
    nomCotisation VARCHAR(100),
    annees SMALLINT,
    prixCotisationAnnuelle SMALLINT CHECK (prixCotisationAnnuelle > 0),
    
    PRIMARY KEY (nomCotisation, annees)    
);

CREATE TABLE PAYER(

    nomCotisation VARCHAR(100),-- cle etrangere ==> nomCotisation
    anneesCoti SMALLINT,-- cle etrangere ==> annees de cotisation
    idClient INT, -- cle etrangere ==> idPersonne
    
    PRIMARY KEY (nomCotisation, anneesCoti, idClient),
    
    FOREIGN KEY (nomCotisation, anneesCoti) REFERENCES COTISATION(nomCotisation, annees),
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
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
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateCours DATE,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutCours BETWEEN 1 AND 24),
    activite VARCHAR(30),

    PRIMARY KEY (idCours, idMoniteur, dateCours, heureDebutCours),
    FOREIGN KEY (idCours) REFERENCES COURS(idCours),
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    idMoniteur INT, -- cle etrangere ==> idMoniteur
    dateCours DATE, -- cle etrangere ==> dateCours,
    heureDebutCours DECIMAL(2,1) CHECK (heureDebutCours BETWEEN 1 AND 24), -- cle etrangere ==> heureDebutCours,
    idClient INT, -- cle etrangere ==> idClient,
    idPoney INT, -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, idMoniteur, dateCours, heureDebutCours, idClient, idPoney),

    FOREIGN KEY (idCours, idMoniteur, dateCours, heureDebutCours) 
    REFERENCES REPRESENTATION(idCours, idMoniteur, dateCours, heureDebutCours 
    ),

    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);