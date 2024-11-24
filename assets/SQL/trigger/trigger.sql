---------------    marche              -------------------------
--Sur la Table PAYER--
--Un client ne doit pouvoir réserver qu’une cotisation par année--x
delimiter |
create or replace trigger une_cotisation_pas_plus before insert on PAYER for each row
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
create or replace trigger update_une_cotisation_pas_plus before update on PAYER for each row
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

--Sur la Table CLIENT--
--Client doit pas être moniteur--
delimiter |
create or replace trigger moniteur_est_client before insert on CLIENT for each row
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
create or replace trigger update_moniteur_est_client before update on CLIENT for each row
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


--Sur la Table MONITEUR--
--moniteur doit pas être Client--
delimiter |
create or replace trigger client_est_moniteur before insert on MONITEUR for each row
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
create or replace trigger client_est_moniteur before update on MONITEUR for each row
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
-------------        RESERVATION                       ---------------------------------------------
----------------------------------------------------------------------------------------------------

delimiter |
create or replace trigger reservation before insert on RESERVATION for each row
begin
    declare idNiveau_client TINYINT ;
    declare soldes int  ;
    declare montant_cours int;
    declare idNiveau_cours INT ;
    declare date_en_string varchar(10);

    declare mes varchar (200) ;
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
        select idNiveau into idNiveau_client from OBTENTION where username = clientel;

        set mes = concat ( 'inscription impossible le niveau de ', new.usernameClient,' est trop faible ', idNiveau_client,' < ',idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;


    if   cotisation_payer_avant_reserve (new.dateCours,new.usernameClient) then
        
        set date_en_string =  CONCAT ( CAST(YEAR(new.dateCours) As varchar(4)),'-',CAST(YEAR(new.dateCours)+1 As varchar(4))) ;

        set mes = concat ( " le " ,NEW.usernameClient,' n a pas la cotisation actif cette annee ',date_en_string,' pour la reservation ',NEW.idCours ,' et la date ' ,new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;



    if   sufisant_fonds_avant_reserve(new.idCours ,new.usernameClient) then


        select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
        select solde into soldes from CLIENT where   usernameClient = new.usernameClient ;
        select prix into montant_cours from COURS where idCours = new.idCours and  idNiveau = idNiveau_cours;

        set mes = concat ( 'le ',new.usernameClient,' n a pas assez de fond le solde est a ',soldes ,' contre ', montant_cours,' a payer' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;



    if   representation_existe_avant_RESERVATION (new.usernameMoniteur ,new.idCours ,new.dateCours ,new.heureDebutCours) then
        set mes = concat ( 'inscription impossible la representation na pas definie le cours avec ',new.usernameMoniteur,' le ', new.dateCours ," num cours ",new.idCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;



end |
delimiter ;

----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
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
-------------        REPRESENTATION                       ---------------------------------------------
----------------------------------------------------------------------------------------------------

delimiter |
create or replace trigger REPRESENTATION before insert on REPRESENTATION for each row
begin
    declare idNiveau_moniteur TINYINT ;
    declare idNiveau_cours INT ;
    declare heureDebutDispos DECIMAL ;
    declare durees INT ;
    declare heureFinDispos DECIMAL ;

    declare mes VARCHAR (150) ;

    if  niveauMoniteur_avant_representer (new.usernameMoniteur,new.idCours) then
        select idNiveau into idNiveau_moniteur from OBTENTION where  username = new.usernameMoniteur  ;
        select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

        set mes = concat ( 'inscription impossible le niveau ' , idNiveau_moniteur , ' de ', new.usernameMoniteur,' est trop faible par rapport a celui du cours ', idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;




    if  court_deja_present_avant_representer(new.usernameMoniteur,new.dateCours,new.heureDebutCours) then
        set mes = concat ( 'cours deja present la meme heure pour le moniteur ',new.usernameMoniteur," du cours numero ", new.idCours," le ",new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;



    if   cours_hors_Possibiliter (new.usernameMoniteur,new.dateCours)  then
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

end |
delimiter ;





----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------------------

