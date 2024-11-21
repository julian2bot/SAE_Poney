






--Moniteur--
--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
delimiter |
create or replace trigger niveauMoniteur_avant_representer before insert on REPRESENTATION for each row
begin
    declare idNiveau_moniteur TINYINT ;
    declare idNiveau_cours INT ;
    declare mes varchar (100) ;

    select idNiveau into idNiveau_moniteur from OBTENTION where  username = new.usernameMoniteur  ;
    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

    if  idNiveau_moniteur <  idNiveau_cours then
        set mes = concat ( 'inscription impossible le niveau' , idNiveau_moniteur , 'de', new.usernameMoniteur,'est trop faible par rapport a celui du cours', idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;


--update--
delimiter |
create or replace trigger niveauMoniteur_avant_reserve before update on RESERVATION for each row
begin
    declare idNiveau_cours INT ;
    declare idNiveau_client TINYINT ;
    declare mes varchar (100) ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours;
    select idNiveau into idNiveau_client from OBTENTION where username = new.usernameClient;

    if  idNiveau_client <  idNiveau_cours then
        set mes = concat ( 'inscription impossible le niveau' , idNiveau_cours , 'de', new.usernameClient,'est trop faible' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;




--Les horaires du cours doivent être dans ses disponibilités-- partie 1
delimiter |
create or replace trigger court_deja_present_avant_representer before insert on REPRESENTATION for each row
begin
    declare comptage INT;
    declare mes varchar (100) ;

    select count(*)  into comptage from REPRESENTATION where  usernameMoniteur = new.usernameMoniteur and dateCours = new.dateCours and heureDebutCours = new.heureDebutCours  ;

    if comptage > 0 then
        set mes = concat ( 'cours deja present la meme heure' ) ;
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



--Les horaires du cours doivent être dans ses disponibilités-- partie 3
delimiter |
create or replace trigger cours_depasse_planning before insert on REPRESENTATION for each row
begin
    declare durees INT ;
    declare finHeureDispos DECIMAL ;
    declare mes varchar (100) ;

    select duree into durees from COURS where  idCours = new.idCours;
    select finHeureDispo into finHeureDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;

    if finHeureDispos > new.heureDebutCours + durees then
        set mes = concat ( 'le moniteur ne peux pas realiser ce cours car il depasse son temps de travails' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;





--Les horaires du cours doivent être dans ses disponibilités-- partie 4
delimiter |
create or replace trigger court_deja_present_1h_apres_representer before insert on REPRESENTATION for each row
begin
    declare durees INT ;
    declare comptage INT;
    declare mes varchar (100) ;

    select duree into durees from COURS where  idCours = new.idCours;
    select count(*)  into comptage from REPRESENTATION where  usernameMoniteur = new.usernameMoniteur and dateCours = new.dateCours and heureDebutCours BETWEEN new.heureDebutCours AND new.heureDebutCours + durees ;

    if comptage > 0 then
        set mes = concat ( 'des cours se chevauche' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;













--
--
--












/*
--procesdure question 5

delimiter |
create or replace procedure proc_heure_avant (heure_deb DECIMAL,dateCourss DATE,usernameMoniteur VARCHAR,duree_existant INT,est_chevaucher boolean ) 

begin
    declare identifant_cours INT;
    declare durees INT ;
    declare heureDebutCourss DECIMAL;
    declare fini boolean default false ;
    declare lesCours cursor for 
        select idcours 
        from REPRESENTATION 
        where dateCours = dateCourss and usernameMoniteur = usernameMoniteurs and heureDebutCours < heure_deb;

    declare continue handler for not found set fini = true;
    open lesCours ;
    while not fini do
        fetch lesCours into identifant_cours ;
        if not fini then
            select duree into durees from COURS where idCours = identifant_cours;
            select heureDebutCours into heureDebutCourss from COURS where idCours = identifant_cours;

            if heureDebutCourss+durees < heure_deb + duree_existant then
                    est_chevaucher = true;
            end if ;
        end if ;
    end while ;
    close lesCours ;
    select est_chevaucher ;

end |
delimiter ;



--Les horaires du cours doivent être dans ses disponibilités-- partie 5
delimiter |
create or replace trigger court_deja_present_1h_avant_representer before insert on REPRESENTATION for each row
begin
    declare duree_existant INT ;
    declare est_chevaucher boolean default false ;
    declare mes varchar (100) ;


    select duree into duree_existant from COURS where  idCours = new.idCours;
    call proc_heure_avant (new.heureDebutCours ,new.dateCours,new.usernameMoniteur,duree_existant,est_chevaucher) ;

    if est_chevaucher = true then
        set mes = concat ( 'un precedent cours chevauche le nouveau' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;
*/