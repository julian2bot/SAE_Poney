--Poney--
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

-- Test fonctions
-- Faux
-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("11 05 2024", "%d %m %Y"), 11,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("10 06 2024", "%d %m %Y"), 11,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("10 05 2025", "%d %m %Y"), 11,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("10 05 2025", "%d %m %Y"), 11,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("10 05 2025", "%d %m %Y"), 14,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,2,
--     STR_TO_DATE("10 05 2025", "%d %m %Y"), 12,1);

-- Vrai
-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,2,
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 11,1);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 12,2,
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 12,1);
    
-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 11,2,
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 12,2);

-- select collisionCours(
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 10,1,
--     STR_TO_DATE("10 05 2024", "%d %m %Y"), 9,2);

delimiter |
create or replace procedure poneyDispo(
    idPoney INT,
    idCours INT,
    usernameMoniteur VARCHAR(32),
    dateCours DATE,
    heureDebutCours DECIMAL(3,1),
    dureeCours TINYINT
    )
BEGIN
    declare heureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;
    declare dureeUnCours TINYINT DEFAULT 1;

    declare vraiDureeCours TINYINT DEFAULT dureeCours;

    declare vraiHeureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;

    declare cptCoursUneHeure TINYINT DEFAULT 0;

    declare res BOOLEAN DEFAULT TRUE;
    declare fini BOOLEAN DEFAULT FALSE;
    declare lesCours cursor for
        select heureDebutCours, duree from RESERVATION NATURAL JOIN COURS where dateCours=dateCours and idPoney=idPoney order by heureDebutCours;
    declare continue handler for not found set fini = TRUE;

    if dureeCours = 2 then
        set vraiDureeCours = 3;
    end if;

    while not (fini and res) do
        fetch lesCours into heureDebutUnCours, dureeUnCours;

        if not fini then
            if cptCoursUneHeure = 0 then -- Met la vrai heure de cours avant les conteurs
                set vraiHeureDebutUnCours = heureDebutUnCours;
            end if;

            if dureeUnCours = 1 and vraiHeureDebutUnCours+dureeUnCours*(cptCoursUneHeure) = heureDebutUnCours then
                set cptCoursUneHeure = cptCoursUneHeure + 1;
            else if dureeUnCours = 2 then
                set dureeUnCours = 3; -- Prendre en compte une heure de repoos si le cours fait 2h
                set cptCoursUneHeure = 0;
            end if;

            if cptCoursUneHeure != 0 then
                set dureeUnCours = dureeUnCours*cptCoursUneHeure;
            end if;

            set res = (select collisionCours(dateCours,heureDebutCours,vraiDureeCours,dateCours,vraiHeureDebutUnCours,dureeUnCours));
        end if;
    end while;
    close lesCours;
    select res;
END |
delimiter ;

-- delimiter |
-- create or replace trigger repos before insert on RESERVATION for each row
--     begin
--     declare Debut_heure_cours DECIMAL(2,1) ;
--     declare mes varchar (100) ;
--     select heureDebutCours into Debut_heure_cours from RESERVATION where dateCours = new.dateCours AND idPoney = new.idPoney AND ;
--     select count ( idp ) int o nbins from PARTICIPER where ida = new.ida ;

--     if  new.heureDebutCours not in ( ’ oui ’ , ’ non ’) )  then
--     set mes = concat ( 'inscription impossible' , new.idPoney , 'na pas terminer son repos') ;
--     signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
--     end if ;
-- end |
-- delimiter ;
