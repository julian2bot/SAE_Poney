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
create or replace function poneyDispo(
    idPoney INT,
    idCours INT,
    usernameMoniteur VARCHAR(32),
    dateCours DATE,
    heureDebutCours DECIMAL(3,1),
    dureeCours TINYINT
    ) returns BOOLEAN
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
    open lesCours;
    while not (fini and res) do
        fetch lesCours into heureDebutUnCours, dureeUnCours;

        if not fini then
            if cptCoursUneHeure = 0 then -- Met la vrai heure de cours avant les conteurs
                set vraiHeureDebutUnCours = heureDebutUnCours;
            end if;

            if dureeUnCours = 1 and vraiHeureDebutUnCours+dureeUnCours*(cptCoursUneHeure) = heureDebutUnCours then
                set cptCoursUneHeure = cptCoursUneHeure + 1;
            elseif dureeUnCours = 2 then
                set dureeUnCours = 3; -- Prendre en compte une heure de repoos si le cours fait 2h
                set cptCoursUneHeure = 0;
            end if;

            if cptCoursUneHeure != 0 then
                set dureeUnCours = dureeUnCours*cptCoursUneHeure;
            end if;

            set res = not (select collisionCours(dateCours,heureDebutCours,vraiDureeCours,dateCours,vraiHeureDebutUnCours,dureeUnCours));
        end if;
    end while;
    close lesCours;
    return res;
END |
delimiter ;

delimiter |
create or replace trigger repos before insert on RESERVATION for each row
    begin
    declare res BOOLEAN DEFAULT FALSE;
    declare dureeCours TINYINT DEFAULT 1;
    declare mes VARCHAR(100) DEFAULT "";
    select duree into dureeCours from COURS where idCours = new.idCours;
    set res = (select poneyDispo(new.idPoney, new.idCours,new.usernameMoniteur,new.dateCours,new.heureDebutCours,dureeCours));

    if not res then
        set mes = concat ("inscription impossible" , new.idPoney , "n'est pas disponible") ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
(1, 'moniteur2', '2023-12-01', 11.0), -- Valide
(1, 'moniteur2', '2023-12-01', 10.5), -- Invalide car chevauchement
-- (1, 'moniteur2', '2023-12-01', 9.0), -- Valide car avant
(1, 'moniteur2', '2023-12-01', 12.0); -- Invalide suite au court de 10h et 11h

INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
(1, 'moniteur2', '2023-12-01', 11.0, 'client1', 1), -- Valide
(1, 'moniteur2', '2023-12-01', 10.5, 'client1', 1),
(1, 'moniteur2', '2023-12-01', 12.0, 'client1', 1);
