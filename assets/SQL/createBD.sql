-- creation des tables SQL : PONEY WEB
create table PERSONNE(
    idPersonne int,
    mdp varchar(100),
    prenomPersonne varchar(100),
    nomPersonne varchar(100),
    mail varchar(100),
    
    PRIMARY KEY (idPersonne)
);

create table CLIENT(
    idClient int, -- cle etrangere ==> idPersonne
    dateInscription date,
    poidsClient int, 
    solde int,
    
    PRIMARY KEY (idClient),
    
    FOREIGN KEY (idClient) REFERENCES PERSONNE(idPersonne)
);

create table MONITEUR(
    idMoniteur int, -- cle etrangere ==> idPersonne
    salaire float,
    
    PRIMARY KEY (idMoniteur),
    
    FOREIGN KEY (idMoniteur) REFERENCES PERSONNE(idPersonne)
);

create table NIVEAU(
    idNiveau int,
    nomNiveau varchar(30),
   
    PRIMARY KEY (idNiveau)
);

create table OBTENTION(
    idPersonne int, -- cle etrangere ==> idPersonne
    idNiveau int, -- cle etrangere ==> idNiveau
    dateObtention date,
    
    PRIMARY KEY (idPersonne, idNiveau),
    
    FOREIGN KEY (idPersonne) REFERENCES PERSONNE(idPersonne),
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau)
);

create table DISPONIBILITE(
    idMoniteur int, -- cle etrangere ==> idMoniteur
    heureDebutDispo int, 
    dateDispo date,
    finHeureDispo int,
    
    PRIMARY KEY (idMoniteur, heureDebutDispo, dateDispo),
    
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

create table FACTURE_SOLDE(
    idClient int, -- cle etrangere ==> idPersonne
    idFacture int,
    dateFacture date,
    montant int,
    
    PRIMARY KEY (idClient, idFacture),
    
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
);

create table COTISATION(
    idCotisation int,
    nomCotisation varchar(100),
    annees int,
    prixCotisationAnnuelle int,
    
    PRIMARY KEY (idCotisation)    
);

create table PAYER(
    idCotisation int, -- cle etrangere ==> idCotisation
    idClient int, -- cle etrangere ==> idPersonne
    
    PRIMARY KEY (idCotisation, idClient),
    
    FOREIGN KEY (idCotisation) REFERENCES COTISATION(idCotisation),
    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient)
);

create table RACE(
    idRace int,
    nomRace varchar(50),
    descriptionRace varchar(255),
    
    PRIMARY KEY (idRace)
);

create table PONEY(
    idPoney int,
    nomPoney varchar(30),
    poidsMax int,
    photo varchar(30), -- photo ==> lien vers le dossier images/photoPoney/ mettre juste le nom de l'image donc "michelLePoney.png" pas "images/photoPoney/michelLePoney.png"
    idRace int, -- cle etrangere ==> idRace
    
    PRIMARY KEY (idPoney),
    
    FOREIGN KEY (idRace) REFERENCES RACE(idRace)
);

create table TYPE_COURS(
    idType int,
    nomType varchar(30),
    nbMax int,
    
    PRIMARY KEY (idType)
);

create table COURS(
    idCours int,
    idNiveau int,  -- cle etrangere ==> idNiveau
    idType int, -- cle etrangere ==> idType
    nomCours varchar(30),
    duree int,
    prix int,
    
    PRIMARY KEY (idCours, idNiveau, idType),
    
    FOREIGN KEY (idNiveau) REFERENCES NIVEAU(idNiveau),
    FOREIGN KEY (idType) REFERENCES TYPE_COURS(idType)
);

create table REPRESENTATION(
    idCours int, -- cle etrangere ==> idCours
    idNiveau int,  -- cle etrangere ==> idNiveau
    idType int, -- cle etrangere ==> idType
    idMoniteur int, -- cle etrangere ==> idMoniteur
    dateDebutCours date,
    heureDebutCour int,
    activite varchar(30),

    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCour),
    FOREIGN KEY (idCours, idNiveau, idType) REFERENCES COURS(idCours, idNiveau, idType),
    -- FOREIGN KEY (idCours) REFERENCES COURS(idCours),
    -- FOREIGN KEY (idNiveau) REFERENCES COURS(idNiveau),
    -- FOREIGN KEY (idType) REFERENCES COURS(idType),
    FOREIGN KEY (idMoniteur) REFERENCES MONITEUR(idMoniteur)
);

create table RESERVATION(
    idCours int, -- cle etrangere ==> idCours
    idNiveau int,  -- cle etrangere ==> idNiveau
    idType int, -- cle etrangere ==> idType
    idMoniteur int, -- cle etrangere ==> idMoniteur
    dateDebutCours date,
    heureDebutCour int,
    idClient int,
    idPoney int,
    
    PRIMARY KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCour, idClient, idPoney),
    
    -- FOREIGN KEY (idCours) REFERENCES REPRESENTATION(idCours),
    -- FOREIGN KEY (idNiveau) REFERENCES REPRESENTATION(idNiveau),
    -- FOREIGN KEY (idType) REFERENCES REPRESENTATION(idType),
    -- FOREIGN KEY (idMoniteur) REFERENCES REPRESENTATION(idMoniteur),
    -- FOREIGN KEY (dateDebutCours) REFERENCES REPRESENTATION(dateDebutCours),
    -- FOREIGN KEY (heureDebutCour) REFERENCES REPRESENTATION(heureDebutCour),

    FOREIGN KEY (idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCour) 
        REFERENCES REPRESENTATION(idCours, idNiveau, idType, idMoniteur, dateDebutCours, heureDebutCour),

    FOREIGN KEY (idClient) REFERENCES CLIENT(idClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);