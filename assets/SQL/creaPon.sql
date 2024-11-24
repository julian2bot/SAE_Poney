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
    
    PRIMARY KEY (usernameClient),
    
    FOREIGN KEY (usernameClient) REFERENCES PERSONNE(username)
);

CREATE TABLE MONITEUR(
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> username
    salaire DECIMAL(7,2) NOT NULL DEFAULT 0,
    isAdmin BOOLEAN NOT NULL DEFAULT FALSE,
    
    PRIMARY KEY (usernameMoniteur),
    
    FOREIGN KEY (usernameMoniteur) REFERENCES PERSONNE(username)
);

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
    
    PRIMARY KEY (usernameMoniteur, heureDebutDispo, dateDispo),
    
    FOREIGN KEY (usernameMoniteur) REFERENCES MONITEUR(usernameMoniteur)
);

CREATE TABLE FACTURE_SOLDE(
    usernameClient VARCHAR(32), -- cle etrangere ==> username
    idFacture INT,
    dateFacture DATE NOT NULL,
    montant SMALLINT NOT NULL DEFAULT 1 CHECK (montant > 0),
    
    PRIMARY KEY (usernameClient, idFacture),
    
    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient)
);

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
    
    FOREIGN KEY (nomCotisation, periode) REFERENCES COTISATION(nomCotisation, periode),
    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient)
);

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
    FOREIGN KEY (idCours) REFERENCES COURS(idCours),
    FOREIGN KEY (usernameMoniteur) REFERENCES MONITEUR(usernameMoniteur)
);

CREATE TABLE RESERVATION(
    idCours INT, -- cle etrangere ==> idCours
    usernameMoniteur VARCHAR(32), -- cle etrangere ==> usernameMoniteur
    dateCours DATE, -- cle etrangere ==> dateCours,
    heureDebutCours DECIMAL(3,1) CHECK (heureDebutCours BETWEEN 1 AND 24), -- cle etrangere ==> heureDebutCours,
    usernameClient VARCHAR(32), -- cle etrangere ==> usernameClient,
    idPoney INT, -- cle etrangere ==> idPoney,
    
    PRIMARY KEY (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney),

    FOREIGN KEY (idCours, usernameMoniteur, dateCours, heureDebutCours) 
    REFERENCES REPRESENTATION(idCours, usernameMoniteur, dateCours, heureDebutCours 
    ),

    FOREIGN KEY (usernameClient) REFERENCES CLIENT(usernameClient),
    FOREIGN KEY (idPoney) REFERENCES PONEY(idPoney)
);

-- Fonctions et PL/SQL

----------------------------------------------------------------------------------------------------
-------------        fonction     RESERVATION               ----------------------------------------
----------------------------------------------------------------------------------------------------

delimiter |
create or replace function poids_max_poney_reservation (
poney INT,
clientel VARCHAR(32)
) returns BOOLEAN
begin
    declare poidsclientchoisie TINYINT ;
    declare poidsponeymax TINYINT ;
    
    select poidsMax 
    into poidsponeymax 
    from PONEY 
    where  idPoney = poney  ;

    select poidsClient 
    into poidsclientchoisie 
    from CLIENT 
    where  usernameClient = clientel  ;
    
    return poidsponeymax < poidsclientchoisie ;

end |
delimiter ;

--Client--
--Il doit rester de la place dans le cours--
delimiter |
create or replace function reste_place_pour_reservation (
    courss int
) 
returns boolean
begin
    declare idNiveau_cours INT ;
    declare nbmaxe int ;
    declare nbins int ;
    declare mes varchar (150) ;

    select idNiveau 
    into idNiveau_cours 
    from COURS 
    where idCours = courss;

    select nbMax 
    into nbmaxe 
    from COURS 
    where idCours = courss and idNiveau = idNiveau_cours ;

    select COUNT( usernameClient ) 
    into nbins 
    from RESERVATION 
    where idCours = courss ;

    return nbins +1 > nbmaxe ;
        
end |
delimiter ;



--Doit avoir le niveau nécessaire --
delimiter |
create or replace function niveauClient_avant_reserve (
   courss INT,
   clientel VARCHAR(32)

) returns BOOLEAN
begin
    declare idNiveau_client TINYINT ;
    declare idNiveau_cours INT ;

    select idNiveau 
    into idNiveau_cours 
    from COURS 
    where idCours = courss  ;

    select idNiveau 
    into idNiveau_client 
    from OBTENTION 
    where username = clientel;

    return  idNiveau_client < idNiveau_cours;
        
end |
delimiter ;



--it avoir payer la cotisation annuelle--x
delimiter |
--Client--
--Domiter |
create or replace function cotisation_payer_avant_reserve (
da DATE,
clientel VARCHAR(32)
) returns BOOLEAN
begin
    declare datereserve date  ;
    declare date_en_string varchar(10);
    declare cotise INT;

    set date_en_string =  CONCAT ( CAST(YEAR(da) As varchar(4)),'-',CAST(YEAR(da)+1 As varchar(4))) ;
    select count(periode) 
    into cotise 
    from PAYER 
    where usernameClient = clientel and periode = date_en_string ;

    return cotise < 1;

    
end |
delimiter ;


--Doit avoir les fonds suffisant sur son solde-- 
delimiter |
create or replace function sufisant_fonds_avant_reserve(
courss INT,
clientel VARCHAR(32)
) returns BOOLEAN
begin
    declare soldes int  ;
    declare montant_cours int;
    declare idNiveau_cours INT ;

    select idNiveau 
    into idNiveau_cours 
    from COURS 
    where idCours = courss  ;

    select solde 
    into soldes 
    from CLIENT 
    where usernameClient = clientel ;

    select prix 
    into montant_cours 
    from COURS 
    where idCours = courss and  idNiveau = idNiveau_cours;

    return soldes < montant_cours;

end |
delimiter ;


--Moniteur--
--representation_existe_avant de reserver--
delimiter |
create or replace function representation_existe_avant_RESERVATION (
monite VARCHAR(32),
courss INT,
da date,
heureDeb DECIMAL
) returns BOOLEAN
begin
    declare est_present INT;
    select COUNT(idCours) 
    into est_present 
    from REPRESENTATION 
    where idCours = courss and usernameMoniteur = monite and dateCours = da and heureDebutCours = heureDeb ;
    return  est_present <=  0 ;

end |
delimiter ;

----------------------------------------------------------------------------------------------------
-------------        fonction Fin RESERVATION               ----------------------------------------
----------------------------------------------------------------------------------------------------


----------------------------------------------------------------------------------------------------
-------------        fonction     REPRESENTATION            ----------------------------------------
----------------------------------------------------------------------------------------------------

--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
delimiter |
create or replace function niveauMoniteur_avant_representer (
monit VARCHAR(32),
courss INT
) returns BOOLEAN
begin
    declare idNiveau_moniteur TINYINT ;
    declare idNiveau_cours INT ;

    select idNiveau 
    into idNiveau_moniteur 
    from OBTENTION 
    where  username = monit  ;

    select idNiveau 
    into idNiveau_cours 
    from COURS 
    where idCours = courss  ;

    return  idNiveau_moniteur <  idNiveau_cours;
end |
delimiter ;


--Les horaires du cours doivent être dans ses disponibilités-- partie 1.0
delimiter |
create or replace function court_deja_present_avant_representer(
    monit VARCHAR(32),
    da date,
    heurD DECIMAL
)returns BOOLEAN
begin
    declare comptage INT;
    select count(*)  
    into comptage 
    from REPRESENTATION 
    where  usernameMoniteur = monit and dateCours = da and heureDebutCours = heurD  ;
    return comptage > 0 ;
end |
delimiter ;




--Les horaires du cours doivent être dans ses disponibilités-- partie 1.1
delimiter |
create or replace function cours_hors_Possibiliter (
    monit VARCHAR(32),
    da date
) returns BOOLEAN
begin
    declare heure_disp INT ;

    select COUNT(*) 
    into heure_disp 
    from DISPONIBILITE 
    where  usernameMoniteur = monit and dateDispo = da  ;

    return heure_disp = 0 ;

end |
delimiter ;



--Les horaires du cours doivent être dans ses disponibilités-- partie 1.2
delimiter |
create or replace function cours_hors_planning (
    monit VARCHAR(32),
    da date,
    heurD DECIMAL

) returns BOOLEAN
begin
    declare heureDebutDispos DECIMAL ;
    select heureDebutDispo into heureDebutDispos from DISPONIBILITE where  usernameMoniteur = monit and dateDispo = da  ;
    return heureDebutDispos > heurD ;

end |
delimiter ;


--Les horaires du cours doivent être dans ses disponibilités-- partie 3
delimiter |
create or replace function cours_depasse_planning(
courss INT,
monit VARCHAR(32),
da date,
heurD DECIMAL
) returns BOOLEAN
begin
    declare durees INT ;
    declare heureFinDispos DECIMAL ;

    select duree into durees from COURS where  idCours = courss;
    select heureFinDispo into heureFinDispos from DISPONIBILITE where  usernameMoniteur = monit and dateDispo = da  ;

    return heureFinDispos < heurD + durees ;

end |
delimiter ;

--Les horaires du cours doivent être dans ses disponibilités-- partie 4
delimiter |
create or replace function court_deja_present_1h_apres_representer (
courss INT,
monit VARCHAR(32),
da date,
heurD DECIMAL
) returns BOOLEAN
begin
    declare durees INT ;
    declare comptage INT;
    select duree into durees from COURS where  idCours = courss;
    select count(*)  into comptage from REPRESENTATION where  usernameMoniteur = monit and dateCours = da and heureDebutCours BETWEEN heurD AND heurD + durees ;

    return comptage > 0 ;

end |
delimiter ;

----------------------------------------------------------------------------------------------------
-------------        fonction  FIN  REPRESENTATION          ----------------------------------------
----------------------------------------------------------------------------------------------------



----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------


-- Fonction prennant deux horaires de cours et renvoyant s'ils se chevauchent
delimiter  |
create or replace function collisionCours(
    dateCours1 DATE,
    heureDebutCours1 DECIMAL(3,1),
    dureeCours1 TINYINT,
    dateCours2 DATE,
    heureDebutCours2 DECIMAL(3,1),
    dureeCours2 TINYINT
) returns BOOLEAN
BEGIN
    if dateCours1 != dateCours2 then
        return FALSE;
    else 
        if heureDebutCours1<=heureDebutCours2 then
            return heureDebutCours1 + dureeCours1 > heureDebutCours2;
        else
            return heureDebutCours2 + dureeCours2 > heureDebutCours1;
        end if;
    end if;
END |
delimiter ;

-- Fonction prennant un horaires de cours et renvoyant s'il existe un cours juste avant ou après celui ci
delimiter  |
create or replace function collisionMillieux(
    dateCours1 DATE,
    heureDebutCours1 DECIMAL(3,1),
    dureeCours1 TINYINT,
    idPoney1 INT
) returns BOOLEAN
BEGIN
    return EXISTS(select * from RESERVATION where dateCours = dateCours1 and heureDebutCours = heureDebutCours1 -1 and idPoney = idPoney1) and
    EXISTS(select * from RESERVATION where dateCours = dateCours1 and heureDebutCours = heureDebutCours1 + dureeCours1 and idPoney = idPoney1);
END |
delimiter ;

-- Function renvoie si un poney est disponible pour un cours 
delimiter |
create or replace function poneyDispo(
    idPoneyF INT,
    idCours INT,
    usernameMoniteur VARCHAR(32),
    dateCoursF DATE,
    heureDebutCoursF DECIMAL(3,1),
    dureeCours TINYINT
    ) returns BOOLEAN
BEGIN
    declare heureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;
    declare dureeUnCours TINYINT DEFAULT 1;

    declare vraiDureeCours TINYINT DEFAULT 1;

    declare vraiHeureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;
    declare calculHeure DECIMAL(3,1) DEFAULT 0.0;

    declare cptCoursUneHeure TINYINT DEFAULT 0;

    declare res BOOLEAN DEFAULT TRUE;
    declare fini BOOLEAN DEFAULT FALSE;

    declare lesCours cursor for
        select heureDebutCours, duree from RESERVATION NATURAL JOIN COURS where dateCours=dateCoursF and idPoney=idPoneyF order by heureDebutCours;
    declare continue handler for not found set fini = TRUE;

    -- Si la duree du cours est de 2, on l'a passe a 3 pour compter l'heure de repot
    if dureeCours = 2 then 
        set vraiDureeCours = 3;
    end if;

    
    open lesCours;
    while (not fini and res) do
        fetch lesCours into heureDebutUnCours, dureeUnCours;

        if not fini then
            -- INSERT INTO log_table (log_message)
            --     VALUES (CONCAT(NOW()," ", heureDebutUnCours," ", dureeUnCours));

            -- Si le compteur de cours d'une heure est a 0, on met l'heure de début du premier cours en vrai heure de cours
            -- Pour créer un cours factisse regroupant les différents cours d'une heure pour voir la collision avec le cours a réserver
            if cptCoursUneHeure = 0 then
                set vraiHeureDebutUnCours = heureDebutUnCours;
            end if;

            -- Vérifier si le prochain cours d'une heure est a la suite du dernier
            set calculHeure = vraiHeureDebutUnCours+cptCoursUneHeure;
            if dureeUnCours = 1 and (cptCoursUneHeure = 0 or calculHeure = heureDebutUnCours) then
                set cptCoursUneHeure = cptCoursUneHeure + 1;
            elseif dureeUnCours = 2 then
                -- Prendre en compte une heure de repoos si le cours fait 2h
                set dureeUnCours = 3;
                set cptCoursUneHeure = 0;
                set vraiHeureDebutUnCours = heureDebutUnCours;
            else
                set vraiHeureDebutUnCours = heureDebutUnCours;
                set cptCoursUneHeure = 0;
            end if;

            -- Partie vérification collisions
            -- Plusieurs vérifications en fonctions des cours d'une heure et 2 heures
            -- Vérifications double (avant et après) pour les cours d'au moins 2 heures (ou multiple cours de 1, passée en au moins 3 pour compter l'heure de repos)
            -- Car l'heure de repos peut être avant ou après 

            if cptCoursUneHeure > 1 then
                set dureeUnCours = (dureeUnCours*cptCoursUneHeure)+1;
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours-1,dureeUnCours));
            end if;

            if vraiDureeCours>2 and res then
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF-1,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours,dureeUnCours));
            else
                set res = not (select collisionMillieux(dateCoursF,heureDebutCoursF,vraiDureeCours,idPoneyF));            
            end if;
            if res then
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours,dureeUnCours));
            end if;
        end if;
    end while;
    close lesCours;
    return res;
END |
delimiter ;

-- procesdure question 5

delimiter |
create or replace function proc_heure_avant (heure_deb DECIMAL(3,1), dateCourss DATE, usernameMoniteurs VARCHAR(32), duree_existant TINYINT) 
returns BOOLEAN
begin
    declare identifant_cours INT default 0;
    declare durees TINYINT default 0;
    declare heureDebutCourss DECIMAL(3,1) default 0.0;
    declare fini BOOLEAN default false;
    declare est_chevaucher boolean default false;

    declare lesCours cursor for
        select idCours, duree,heureDebutCours
        from REPRESENTATION natural join COURS
        where dateCours = dateCourss and usernameMoniteur = usernameMoniteurs and heureDebutCours < heure_deb;

    declare continue handler for not found set fini = true;
    open lesCours ;
    while (not fini and not est_chevaucher) DO
        fetch lesCours into identifant_cours, durees,heureDebutCourss;
        if (not fini and not est_chevaucher) then
            if heureDebutCourss + durees < heure_deb then
                   set est_chevaucher = true;
            end if ;
        end if ;
    end while ;

    close lesCours ;
    return est_chevaucher;

end |
delimiter ;


--------------------------- TRIGGER ---------------------------

------------- PAYER -------------

--Un client ne doit pouvoir réserver qu’une cotisation par année--x
delimiter |
create or replace trigger une_cotisation_pas_plus_before_insert before insert on PAYER for each row
begin
    declare datereserve date  ;
    declare cotise varchar (9);
    declare mes varchar (100) ;

    select count(periode) 
    into cotise 
    from PAYER 
    where usernameClient = new.usernameClient and periode =NEW.periode ;

    if  cotise >= 1 then
        set mes = concat ( 'le ',NEW.usernameClient,' a deja la cotisation payer du ',NEW.periode ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--update

delimiter |
create or replace trigger update_une_cotisation_pas_plus_before_update before update on PAYER for each row
begin
    declare datereserve date  ;
    declare cotise varchar (9);
    declare mes varchar (100) ;

    select count(periode) 
    into cotise 
    from PAYER 
    where usernameClient = new.usernameClient and periode =NEW.periode ;

    if  cotise >= 1 then
        set mes = concat ( 'le ',NEW.usernameClient,' a deja la cotisation payer du ',NEW.periode ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

------------- CLIENT -------------

--Client doit pas être moniteur--
delimiter |
create or replace trigger moniteur_est_client_before_insert before insert on CLIENT for each row
begin
    declare identifiant_Moniteur VARCHAR(32) ;
    declare mes varchar (100) ;

    select usernameMoniteur 
    into identifiant_Moniteur 
    from MONITEUR 
    where  usernameMoniteur = new.usernameClient  ;

    if  new.usernameClient =  identifiant_Moniteur then
        set mes = concat ( 'inscription impossible le client ' , new.usernameClient , ' ne peut pas devenir client car il est aussi Moniteur ') ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--update

delimiter |
create or replace trigger update_moniteur_est_client_before_update before update on CLIENT for each row
begin
    declare identifiant_Moniteur VARCHAR(32) ;
    declare mes varchar (100) ;

    select usernameMoniteur 
    into identifiant_Moniteur 
    from MONITEUR 
    where  usernameMoniteur = new.usernameClient  ;

    if  new.usernameClient =  identifiant_Moniteur then
        set mes = concat ( 'inscription impossible le client ' , new.usernameClient , ' ne peut pas devenir client car il est aussi Moniteur ') ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;


------------- MONITEUR -------------

--moniteur doit pas être Client--
delimiter |
create or replace trigger client_est_moniteur_before_insert before insert on MONITEUR for each row
begin
    declare identifiant_Client VARCHAR(32) ;
    declare mes varchar (100) ;

    select usernameClient 
    into identifiant_Client 
    from CLIENT 
    where  usernameClient = new.usernameMoniteur  ;

    if  new.usernameMoniteur =  identifiant_Client then
        set mes = concat ( 'inscription impossible le client ' , new.usernameMoniteur , ' ne peut pas devenir  Moniteur car il est aussi client ') ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

-- update

delimiter |
create or replace trigger client_est_moniteur_before_update before update on MONITEUR for each row
begin
    declare identifiant_Client VARCHAR(32) ;
    declare mes varchar (100) ;

    select usernameClient 
    into identifiant_Client 
    from CLIENT 
    where  usernameClient = new.usernameMoniteur  ;

    if  new.usernameMoniteur =  identifiant_Client then
        set mes = concat ( 'inscription impossible le client ' , new.usernameMoniteur , ' ne peut pas devenir  Moniteur car il est aussi client ') ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

------------- RESERVATION -------------

delimiter |
create or replace trigger triggerReservation before insert on RESERVATION for each row
begin
    declare idNiveau_client TINYINT ;
    declare soldes int  ;
    declare montant_cours int;
    declare idNiveau_cours INT ;
    declare date_en_string varchar(10);
    declare resReposPoney BOOLEAN DEFAULT FALSE;
    declare dureeCours TINYINT DEFAULT 1;
    declare countRes INT DEFAULT 0;

    declare mes varchar (200) ;

    select duree into dureeCours from COURS where idCours = new.idCours;
    select IFNULL(count(new.idPoney),0) into countRes from RESERVATION where idPoney = new.idPoney and dateCours = new.dateCours;

    if   poids_max_poney_reservation(new.idPoney,new.usernameClient)  then
        set mes = concat ( 'inscription impossible le poney numero ' , new.idPoney , ' ne supporteras pas la charge de ',new.usernameClient," pour la reservation du cours avec le numero" ,new.idCours) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;


    if  reste_place_pour_reservation(new.idCours) then
        set mes = concat ( 'inscription impossible le cours est complet donc ',new.usernameClient," a besoin de choisir un autre cours que le cours",new.idCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;


    if   niveauClient_avant_reserve(new.idCours,new.usernameClient) then


        select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
        select max(idNiveau) into idNiveau_client from OBTENTION where username = clientel;

        set mes = concat ( 'inscription impossible le niveau de ', new.usernameClient,' est trop faible ', idNiveau_client,' < ',idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;


    if   cotisation_payer_avant_reserve (new.dateCours,new.usernameClient) then
        
        set date_en_string =  CONCAT ( CAST(YEAR(new.dateCours) As varchar(4)),'-',CAST(YEAR(new.dateCours)+1 As varchar(4))) ;

        set mes = concat ( " le " ,NEW.usernameClient,' n a pas la cotisation actif cette annee ',date_en_string,' pour la reservation ',NEW.idCours ,' et la date ' ,new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;


    if sufisant_fonds_avant_reserve(new.idCours ,new.usernameClient) then

        select solde into soldes from CLIENT where usernameClient = new.usernameClient;
        select prix into montant_cours from COURS where idCours = new.idCours;

        set mes = concat ( 'le ',new.usernameClient,' n a pas assez de fond le solde est a ',soldes ,' contre ', montant_cours,' a payer' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;

    if representation_existe_avant_RESERVATION (new.usernameMoniteur ,new.idCours ,new.dateCours ,new.heureDebutCours) then
        set mes = concat ( 'inscription impossible la representation na pas definie le cours avec ',new.usernameMoniteur,' le ', new.dateCours ," num cours ",new.idCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

    -- Disponibilité poney

    -- Si le poney n'a pas été réservé de la journée, il est libre
    if countRes > 0 then
        set resReposPoney = (select poneyDispo(new.idPoney, new.idCours, new.usernameMoniteur, new.dateCours, new.heureDebutCours, dureeCours));
    else
        set resReposPoney = TRUE;
    end if;

    if not resReposPoney then
        set mes = concat ("inscription impossible " , new.idPoney , " n'est pas disponible") ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

end |
delimiter ;

------------- REPRESENTATION -------------

delimiter |
create or replace trigger triggerRepresentation before insert on REPRESENTATION for each row
begin
    declare idNiveau_moniteur TINYINT ;
    declare idNiveau_cours INT ;
    declare heureDebutDispos DECIMAL ;
    declare durees INT ;
    declare heureFinDispos DECIMAL ;
    declare duree_existant TINYINT default 0;
    declare mes VARCHAR (150) ;

    select duree into duree_existant from COURS where idCours = new.idCours;

    if (select niveauMoniteur_avant_representer (new.usernameMoniteur,new.idCours)) then
        select max(idNiveau) into idNiveau_moniteur from OBTENTION where username = new.usernameMoniteur;
        select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

        set mes = concat ( 'inscription impossible le niveau ' , idNiveau_moniteur , ' de ', new.usernameMoniteur,' est trop faible par rapport a celui du cours ', idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

    if  court_deja_present_avant_representer(new.usernameMoniteur,new.dateCours,new.heureDebutCours) then
        set mes = concat ( 'cours deja present la meme heure pour le moniteur ',new.usernameMoniteur," du cours numero ", new.idCours," le ",new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

    if cours_hors_Possibiliter (new.usernameMoniteur,new.dateCours)  then
        set mes = concat ( "le moniteur ",new.usernameMoniteur," n\'est pas dispo tout la journé pour le cours numero " ,NEW.idcours ," le ",new.dateCours ) ;
        signal SQLSTATE "45000" set MESSAGE_TEXT = mes ;
    end if ;

    if  cours_hors_planning (new.usernameMoniteur,new.dateCours,new.heureDebutCours) then
        select heureDebutDispo into heureDebutDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;
        set mes = concat ( "le moniteur ",new.usernameMoniteur," n\'a pas commencer son service, trouver une autre heure que ", new.heureDebutCours ,"h le moniteur commence a " ,heureDebutDispos,"h" ) ;
        signal SQLSTATE "45000" set MESSAGE_TEXT = mes ;
    end if ;

    if  cours_depasse_planning(new.idCours,new.usernameMoniteur,new.dateCours,new.heureDebutCours)  then
        select duree into durees from COURS where  idCours = new.idCours;
        select heureFinDispo into heureFinDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;
        
        set mes = concat ( 'le moniteur ne peux pas realiser ce cours car il depasse son temps de travails ',heureFinDispos  ," < ",  new.heureDebutCours + durees , " le ",new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

    if  court_deja_present_1h_apres_representer (new.idCours,new.usernameMoniteur,new.dateCours,new.heureDebutCours) then
        set mes = concat ( 'le cours ',new.idCours,' se chevauche avec celui d apres pour le ',new.dateCours, ' a ',new.heureDebutCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;

    -- Les horaires du cours doivent être dans ses disponibilités -- partie 5
    if (select proc_heure_avant (new.heureDebutCours , new.dateCours , new.usernameMoniteur , duree_existant)) then
        set mes = concat ( 'un precedent cours chevauche le nouveau' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;    

end |
delimiter ;

-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 11.0, 1);
-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 10.5, 1);
-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 12.0, 1);

-- select poneyDispo(1,3, 'moniteur2', '2023-12-01', 11.0, 'client1', 2);

-- select poneyDispo(1,3, 'moniteur2', '2023-12-01', 11.0, 2);
-- select poneyDispo(1,1, 'moniteur2', '2027-12-01', 12.0, 1); 
-- select truc('2027-12-01', 15.0, 1,1);
