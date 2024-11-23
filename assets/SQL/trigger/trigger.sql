
-- Fonction prennant deux horaires de cours et renvoyant s'ils se chevauchent
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

-- Fonction prennant un horaires de cours et renvoyant s'il existe un cours juste avant ou après celui ci
delimiter  |
create or replace function collisionMillieux(
    dateCours1 DATE,
    heureDebutCours1 DECIMAL(3,1),
    dureeCours1 TINYINT,
    idPoney1 INT
) returns BOOLEAN
BEGIN
    return EXISTS(select * from RESERVATION where dateCours = dateCours1 and heureDebutCours = heureDebutCours1 -1 and idPoney = idPoney1) and
    EXISTS(select * from RESERVATION where dateCours = dateCours1 and heureDebutCours = heureDebutCours1 + dureeCours1 and idPoney = idPoney1);
END |
delimiter ;

-- TRUNCATE log_table;

-- Function renvoie si un poney est disponible pour un cours 
delimiter |
create or replace function poneyDispo(
    idPoneyF INT,
    idCours INT,
    usernameMoniteur VARCHAR(32),
    dateCoursF DATE,
    heureDebutCoursF DECIMAL(3,1),
    dureeCours TINYINT
    ) returns BOOLEAN
BEGIN
    declare heureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;
    declare dureeUnCours TINYINT DEFAULT 1;

    declare vraiDureeCours TINYINT DEFAULT 1;

    declare vraiHeureDebutUnCours DECIMAL(3,1) DEFAULT 0.0;
    declare calculHeure DECIMAL(3,1) DEFAULT 0.0;

    declare cptCoursUneHeure TINYINT DEFAULT 0;

    declare res BOOLEAN DEFAULT TRUE;
    declare fini BOOLEAN DEFAULT FALSE;

    declare lesCours cursor for
        select heureDebutCours, duree from RESERVATION NATURAL JOIN COURS where dateCours=dateCoursF and idPoney=idPoneyF order by heureDebutCours;
    declare continue handler for not found set fini = TRUE;

    -- Si la duree du cours est de 2, on l'a passe a 3 pour compter l'heure de repot
    if dureeCours = 2 then 
        set vraiDureeCours = 3;
    end if;

    
    open lesCours;
    while (not fini and res) do
        fetch lesCours into heureDebutUnCours, dureeUnCours;

        if not fini then
            -- INSERT INTO log_table (log_message)
            --     VALUES (CONCAT(NOW()," ", heureDebutUnCours," ", dureeUnCours));

            -- Si le compteur de cours d'une heure est a 0, on met l'heure de début du premier cours en vrai heure de cours
            -- Pour créer un cours factisse regroupant les différents cours d'une heure pour voir la collision avec le cours a réserver
            if cptCoursUneHeure = 0 then
                set vraiHeureDebutUnCours = heureDebutUnCours;
            end if;

            -- Vérifier si le prochain cours d'une heure est a la suite du dernier
            set calculHeure = vraiHeureDebutUnCours+cptCoursUneHeure;
            if dureeUnCours = 1 and (cptCoursUneHeure = 0 or calculHeure = heureDebutUnCours) then
                set cptCoursUneHeure = cptCoursUneHeure + 1;
            elseif dureeUnCours = 2 then
                -- Prendre en compte une heure de repoos si le cours fait 2h
                set dureeUnCours = 3;
                set cptCoursUneHeure = 0;
                set vraiHeureDebutUnCours = heureDebutUnCours;
            else
                set vraiHeureDebutUnCours = heureDebutUnCours;
                set cptCoursUneHeure = 0;
            end if;

            -- Partie vérification collisions
            -- Plusieurs vérifications en fonctions des cours d'une heure et 2 heures
            -- Vérifications double (avant et après) pour les cours d'au moins 2 heures (ou multiple cours de 1, passée en au moins 3 pour compter l'heure de repos)
            -- Car l'heure de repos peut être avant ou après 

            if cptCoursUneHeure > 1 then
                set dureeUnCours = (dureeUnCours*cptCoursUneHeure)+1;
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours-1,dureeUnCours));
            end if;

            if vraiDureeCours>2 and res then
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF-1,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours,dureeUnCours));
            else
                set res = not (select collisionMillieux(dateCoursF,heureDebutCoursF,vraiDureeCours,idPoneyF));            
            end if;
            if res then
                set res = not (select collisionCours(dateCoursF,heureDebutCoursF,vraiDureeCours,dateCoursF,vraiHeureDebutUnCours,dureeUnCours));
            end if;
        end if;
    end while;
    close lesCours;
    return res;
END |
delimiter ;

-- Trigger gérant le repos d'un poney après 2h de cours
delimiter |
create or replace trigger repos before insert on RESERVATION for each row
    begin
    declare res BOOLEAN DEFAULT FALSE;
    declare dureeCours TINYINT DEFAULT 1;
    declare mes VARCHAR(100) DEFAULT "";
    declare countRes INT DEFAULT 0;
    
    select duree into dureeCours from COURS where idCours = new.idCours;
    select IFNULL(count(new.idPoney),0) into countRes from RESERVATION where idPoney = new.idPoney and dateCours = new.dateCours;

    -- Si le poney n'a pas été réservé de la journée, il est libre
    if countRes > 0 then
        set res = (select poneyDispo(new.idPoney, new.idCours, new.usernameMoniteur, new.dateCours, new.heureDebutCours, dureeCours));
    else
        set res = TRUE;
    end if;

    if not res then
        set mes = concat ("inscription impossible " , new.idPoney , " n'est pas disponible") ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

-- INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
-- (1, 'moniteur2', '2023-12-01', 10.5), -- Invalide car chevauchement
-- (1, 'moniteur2', '2023-12-01', 11.0), -- Valide
-- -- (1, 'moniteur2', '2023-12-01', 9.0), -- Valide car avant
-- (1, 'moniteur2', '2023-12-01', 12.0); -- Invalide suite au court de 10h et 11h


-- -- 1H 1H
-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
-- (1, 'moniteur2', '2023-12-01', 11.0, 'client1', 1); -- Valide
-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
-- (1, 'moniteur2', '2023-12-01', 10.5, 'client1', 1);
-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
-- (1, 'moniteur2', '2023-12-01', 12.0, 'client1', 1);


-- -- 2H2H
-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
-- (3, 'moniteur2', '2023-12-01', 11.0, 'client1', 1); -- Valide

-- INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours) VALUES
-- (1, 'moniteur2', '2027-12-01', 12.0);

-- INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES
--     (1, 'moniteur2', '2027-12-01', 12.0, 'client1', 1);
    -- (3, 'moniteur2', '2027-12-01', 11.0, 'client1', 1);



-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 11.0, 1);
-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 10.5, 1);
-- select poneyDispo(1, 1, 'moniteur2', '2023-12-01', 12.0, 1);

-- select poneyDispo(1,3, 'moniteur2', '2023-12-01', 11.0, 'client1', 2);

-- select poneyDispo(1,3, 'moniteur2', '2023-12-01', 11.0, 2);
-- select poneyDispo(1,1, 'moniteur2', '2027-12-01', 12.0, 1); 
-- select truc('2027-12-01', 15.0, 1,1);