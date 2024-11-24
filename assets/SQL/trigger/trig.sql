--procesdure question 5

delimiter |
create or replace procedure proc_heure_avant (in heure_deb DECIMAL, in dateCourss DATE, in usernameMoniteurs VARCHAR(32), in duree_existant INT,out est_chevaucher BOOLEAN) 

begin
    declare identifant_cours INT;
    declare durees DECIMAL ;
    declare heureDebutCourss DECIMAL;
    declare fini BOOLEAN default false ;
    
    declare lesCours cursor for 
        select idCours 
        from REPRESENTATION 
        where dateCours = dateCourss and usernameMoniteur = usernameMoniteurs and heureDebutCours < heure_deb;
    
    declare continue handler for not found set fini = true;
    open lesCours ;
    while not fini DO
        fetch lesCours into identifant_cours ;
        if not fini then
            select duree,heureDebutCours into durees,heureDebutCourss from COURS where idCours = identifant_cours;


            if heureDebutCourss + durees < heure_deb + duree_existant then
                   set est_chevaucher = true;
                   
            end if ;
        end if ;
    end while ;
    
    close lesCours ;
    select est_chevaucher;

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

    call proc_heure_avant (new.heureDebutCours , new.dateCours , new.usernameMoniteur , duree_existant , est_chevaucher) ;
    
    if est_chevaucher = true then
        set mes = concat ( 'un precedent cours chevauche le nouveau' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
    
    
end |
delimiter ;


