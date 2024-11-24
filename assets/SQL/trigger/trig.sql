-- TRUC CLEM
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



--Les horaires du cours doivent être dans ses disponibilités-- partie 5
delimiter |
create or replace trigger court_deja_present_1h_avant_representer before insert on REPRESENTATION for each row
begin
    declare duree_existant TINYINT default 0;
    declare est_chevaucher boolean default false ;
    declare mes varchar (100) default "";

    select duree into duree_existant from COURS where  idCours = new.idCours;

    set est_chevaucher = (select proc_heure_avant (new.heureDebutCours , new.dateCours , new.usernameMoniteur , duree_existant)) ;

    if est_chevaucher then
        set mes = concat ( 'un precedent cours chevauche le nouveau' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;