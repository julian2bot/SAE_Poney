
--Poney remplacer par celui de chris
-- a revoire--
create or replace trigger repos before insert on RESERVATION for each row
begin
declare Debut_heure_cours DECIMAL(2,1) ;
declare mes varchar (100) ;
select heureDebutCours into Debut_heure_cours from RESERVATION where dateCours = new.dateCours AND idPoney = new.idPoney AND ;
select count ( idp ) int o nbins from PARTICIPER where ida = new.ida ;

if  new.heureDebutCours not in ( ’ oui ’ , ’ non ’) )  then
set mes = concat ( 'inscription impossible' , new.idPoney , 'na pas terminer son repos') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
----















---------------    marche              -------------------------
--Sur la Table PAYER--
--Un client ne doit pouvoir réserver qu’une cotisation par année--x
delimiter |
create or replace trigger une_cotisation_pas_plus before insert on PAYER for each row
begin
    declare datereserve date  ;
    declare cotise varchar (9);
    declare mes varchar (100) ;

    select count(periode) into cotise from PAYER where usernameClient = new.usernameClient and periode =NEW.periode ;

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

    select usernameMoniteur into identifiant_Moniteur from MONITEUR where  usernameMoniteur = new.usernameClient  ;

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

    select usernameClient into identifiant_Client from CLIENT where  usernameClient = new.usernameMoniteur  ;

    if  new.usernameMoniteur =  identifiant_Client then
        set mes = concat ( 'inscription impossible le client ' , new.usernameMoniteur , ' ne peut pas devenir  Moniteur car il est aussi client ') ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;


-----
-----

--Sur la Table RESERVATION--
--Peuvent porter jusqu'à un poids max dans réservation--

delimiter |
create or replace trigger poids_max_poney_reservation before insert on RESERVATION for each row
begin
    declare poidsclientchoisie TINYINT ;
    declare poidsponeymax TINYINT ;
    declare mes varchar (200) ;

    select poidsMax into poidsponeymax from PONEY where  idPoney = new.idPoney  ;
    select poidsClient into poidsclientchoisie from CLIENT where  usernameClient = new.usernameClient  ;

    if  poidsponeymax < poidsclientchoisie  then
        set mes = concat ( 'inscription impossible le poney numero ' , new.idPoney , ' ne supporteras pas la charge de ',new.usernameClient," pour la reservation du cours avec le numero" ,new.idCours) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;


--Client--
--Il doit rester de la place dans le cours--
delimiter |
create or replace trigger reste_place_pour_reservation before insert on RESERVATION for each row
begin
    declare idNiveau_cours INT ;
    declare nbmaxe int ;
    declare nbins int ;
    declare mes varchar (150) ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
    select nbMax into nbmaxe from COURS where idCours = new.idCours and idNiveau = idNiveau_cours ;
    select COUNT( usernameClient ) into nbins from RESERVATION where idCours = new.idCours ;

    if nbins +1 > nbmaxe then
        set mes = concat ( 'inscription impossible le cours est complet donc ',new.usernameClient," a besoin de choisir un autre cours que le cours",new.idCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;



--Doit avoir le niveau nécessaire --
delimiter |
create or replace trigger niveauClient_avant_reserve before insert on RESERVATION for each row
begin
    declare idNiveau_client TINYINT ;
    declare idNiveau_cours INT ;

    declare mes varchar (100) ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
    select idNiveau into idNiveau_client from OBTENTION where username = new.usernameClient;

    if  idNiveau_client < idNiveau_cours then
        set mes = concat ( 'inscription impossible le niveau de ', new.usernameClient,' est trop faible ', idNiveau_client,' < ',idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;


--it avoir payer la cotisation annuelle--x
delimiter |
--Client--
--Domiter |
create or replace trigger cotisation_payer_avant_reserve before insert on RESERVATION for each row
begin
    declare datereserve date  ;
    declare date_en_string varchar(10);

    declare cotise INT;
    declare mes varchar (150) ;

    set date_en_string =  CONCAT ( CAST(YEAR(new.dateCours) As varchar(4)),'-',CAST(YEAR(new.dateCours)+1 As varchar(4))) ;
    select count(periode) into cotise from PAYER where usernameClient = new.usernameClient and periode = date_en_string ;

    if  cotise < 1 then
        set mes = concat ( " le " ,NEW.usernameClient,' n a pas la cotisation actif cette annee ',date_en_string,' pour la reservation ',NEW.idCours ,' et la date ' ,new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--Doit avoir les fonds suffisant sur son solde-- 
delimiter |
create or replace trigger sufisant_fonds_avant_reserve before insert on RESERVATION for each row
begin
    declare soldes int  ;
    declare montant_cours int;
    declare mes varchar (100) ;
    declare idNiveau_cours INT ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
    select solde into soldes from CLIENT where   usernameClient = new.usernameClient ;
    select prix into montant_cours from COURS where idCours = new.idCours and  idNiveau = idNiveau_cours;

    if  soldes < montant_cours then
        set mes = concat ( 'le ',new.usernameClient,' n a pas assez de fond le solde est a ',soldes ,' contre ', montant_cours,' a payer' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;
end |
delimiter ;

--Sur la Table REPRESENTATION--
