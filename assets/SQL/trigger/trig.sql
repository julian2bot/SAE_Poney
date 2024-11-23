

delimiter |
create or replace trigger cours_hors_Possibiliter before insert on REPRESENTATION for each row
begin
    declare heure_disp INT ;
    declare mes varchar (150) ;

    select COUNT(*) into heure_disp from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;

    if heure_disp = 0 then
        set mes = concat ( "le moniteur ",new.usernameMoniteur," n\'est pas dispo tout la journé pour le cours numero " ,NEW.idcours ," le ",new.dateCours ) ;
        signal SQLSTATE "45000" set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;






--Les horaires du cours doivent être dans ses disponibilités-- partie 2
delimiter |
create or replace trigger cours_hors_planning before insert on REPRESENTATION for each row
begin
    declare heureDebutDispos DECIMAL ;
    declare mes varchar (150) ;

    select heureDebutDispo into heureDebutDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;

    if heureDebutDispos > new.heureDebutCours then
        set mes = concat ( "le moniteur ",new.usernameMoniteur," n\'a pas commencer son service, trouver une autre heure que ", new.heureDebutCours ,"h le moniteur commence a " ,heureDebutDispos,"h" ) ;
        signal SQLSTATE "45000" set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--Moniteur--
--representation_existe_avant de reserver--
delimiter |
create or replace trigger representation_existe_avant_RESERVATION before insert on RESERVATION for each row
begin
    declare est_present INT;
    declare mes varchar (150) ;

    select COUNT(idCours) into est_present from REPRESENTATION where idCours = new.idCours and usernameMoniteur = new.usernameMoniteur and dateCours = new.dateCours and heureDebutCours = new.heureDebutCours ;

    if  est_present <=  0 then
        set mes = concat ( 'inscription impossible la representation na pas definie le cours avec ',new.usernameMoniteur,' le ', new.dateCours ," num cours ",new.idCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;