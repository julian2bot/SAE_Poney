
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
create or replace trigger reste_place before insert on RESERVATION for each row
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


