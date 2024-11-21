--Moniteur--
--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
delimiter |
create or replace trigger niveauMoniteur_avant_representer before insert on REPRESENTATION for each row
begin
    declare idNiveau_moniteur TINYINT ;
    declare idNiveau_cours INT ;
    declare mes varchar (150) ;

    select idNiveau into idNiveau_moniteur from OBTENTION where  username = new.usernameMoniteur  ;
    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

    if  idNiveau_moniteur <  idNiveau_cours then
        set mes = concat ( 'inscription impossible le niveau ' , idNiveau_moniteur , ' de ', new.usernameMoniteur,' est trop faible par rapport a celui du cours ', idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--Moniteur--
--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
delimiter |
create or replace trigger niveauMoniteur_avant_RESERVATION before insert on RESERVATION for each row
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