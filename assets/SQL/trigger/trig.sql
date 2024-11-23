

---
--Les horaires du cours doivent être dans ses disponibilités-- partie 1
delimiter |
create or replace trigger court_deja_present_avant_representer before insert on REPRESENTATION for each row
begin
    declare comptage INT;
    declare mes varchar (100) ;

    select count(*)  into comptage from REPRESENTATION where  usernameMoniteur = new.usernameMoniteur and dateCours = new.dateCours and heureDebutCours = new.heureDebutCours  ;

    if comptage > 0 then
        set mes = concat ( 'cours deja present la meme heure pour le moniteur ',new.usernameMoniteur," du cours numero ", new.idCours," le ",new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;



--Les horaires du cours doivent être dans ses disponibilités-- partie 2
delimiter |
create or replace trigger cours_hors_planning before insert on REPRESENTATION for each row
begin
    declare heureDebutDispos DECIMAL ;
    declare mes varchar (100) ;

    select heureDebutDispo into heureDebutDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;

    if heureDebutDispos > new.heureDebutCours then
        set mes = concat ( 'le moniteur n a pas commencer son service a cette heure' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;
