--Peuvent porter jusqu'à un poids max dans réservation--

delimiter |
create or replace trigger poidsmaxponey_reservation before insert on RESERVATION for each row
begin
declare poidsclientchoisie TINYINT ;
declare poidsponeymax TINYINT ;
declare mes varchar (100) ;

select poidsMax into poidsponeymax from PONEY where  idPoney = new.idPoney  ;
select poidsClient into poidsclientchoisie from CLIENT where  idClient = new.idClient  ;

if  poidsponeymax < poidsclientchoisie  then
set mes = concat ( 'inscription impossible' , new.idPoney , 'ne supporteras pas la charge') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;




--Personne--
--Client doit pas être moniteur--
delimiter |

create or replace trigger admine_ou_client before insert on CLIENT for each row
begin
declare identifiant_Moniteur int ;
declare mes varchar (100) ;
select idMoniteur into identifiant_Moniteur from MONITEUR where  idanim = new.idClient  ;

if  new.idClient =  identifiant_Moniteur then
set mes = concat ( 'inscription impossible le client numero' , new.idClient , 'est Moniteur') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
-- if  new.idPersonne =  identifiant_Client then
-- set mes = concat ( 'inscription impossible le client numero' , new.idClient , 'est deja present dans la base') ;
-- signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
-- end if ;
end |
delimiter ;

-- A REFAIRE POUR MONITEUR
delimiter |

create or replace trigger admin_est_client before insert on MONITEUR for each row
begin
declare identifiant_Client int ;
declare mes varchar (100) ;
select idClient into identifiant_Client from CLIENT where  idClient = new.idMoniteur  ;


if  new.idMoniteur =  identifiant_Client then
set mes = concat ( 'inscription impossible le client numero' , new.idMoniteur , 'est client') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;




--Moniteur--
--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
--OBTENTION--
--COURS--
--RESERVATION--

-- delimiter |
-- create or replace trigger niveauMoniteur_avant_reserve before insert on RESERVATION for each row
-- begin
-- declare idNiveau_moniteur TINYINT ;
-- declare idNiveau_cours INT ;
-- declare mes varchar (100) ;
-- select idNiveau into idNiveau_moniteur from OBTENTION where  idPersonne = new.idMoniteur  ;
-- select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

-- if  idNiveau_moniteur <  idNiveau_cours then
-- set mes = concat ( 'inscription impossible le niveau' , idNiveau_moniteur , 'de', new.idMoniteur,'est trop faible par rapport a celui du cours', idNiveau_cours ) ;
-- signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
-- end if ;
-- end |
-- delimiter ;


--et--
--OBTENTION--
--COURS--
--REPRESENTATION--

delimiter |
create or replace trigger niveauMoniteur_avant_representer before insert on REPRESENTATION for each row
begin
declare idNiveau_moniteur TINYINT ;
declare idNiveau_cours INT ;
declare mes varchar (100) ;
select idNiveau into idNiveau_moniteur from OBTENTION where  idPersonne = new.idMoniteur  ;
select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

if  idNiveau_moniteur <  idNiveau_cours then
set mes = concat ( 'inscription impossible le niveau' , idNiveau_moniteur , 'de', new.idMoniteur,'est trop faible par rapport a celui du cours', idNiveau_cours ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;



--Client--
--Il doit rester de la place dans le cours--
-- COURS
-- RESERVATION

delimiter |
create or replace trigger reste_place before insert on RESERVATION for each row
begin
declare idNiveau_cours INT ;
declare nbmax int ;
declare nbins int ;
declare mes varchar (100) ;
select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
select nbMax into nbmax from COURS where idCours = new.idCours and idNiveau = idNiveau_cours ;
select count ( idClient ) into nbins from RESERVATION where idCours = new.idCours and idNiveau = idNiveau_cours;
if nbins +1 > nbmax then
    set mes = concat ( 'inscription impossible le cours est complet' ) ;
    signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

--Doit avoir le niveau nécessaire --
delimiter |
create or replace trigger niveauClient_avant_reserve before insert on RESERVATION for each row
begin
declare idNiveau_client TINYINT ;
declare idNiveau_cours INT ;

declare mes varchar (100) ;

select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

select idNiveau into idNiveau_client from OBTENTION where idPersonne = new.idClient;

if  idNiveau_client < idNiveau_cours then
    set mes = concat ( 'inscription impossible le niveau' , idNiveau_cours , 'de', new.idClient,'est trop faible' ) ;
    signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;

delimiter |
--update--
create or replace trigger niveauMoniteur_avant_reserve before update on RESERVATION for each row
begin
declare idNiveau_cours INT ;
declare idNiveau_client TINYINT ;
declare mes varchar (100) ;
select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

select idNiveau into idNiveau_client from OBTENTION where idPersonne = new.idClient  ;
if  idNiveau_client <  idNiveau_cours then
set mes = concat ( 'inscription impossible le niveau' , idNiveau_cours , 'de', new.idClient,'est trop faible' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;



--Un client ne doit pouvoir réserver qu’une cotisation par année--x
delimiter |
create or replace trigger une_cotisation_pas_plus before insert on RESERVATION for each row
begin

declare datereserve date  ;
declare cotise int;
declare mes varchar (100) ;

select dateCours into datereserve from reserver where   dateCours = new.dateCours ;
select count(anneesCoti) into cotise from payer where idClient = new.idClient and anneesCoti = YEAR(datereserve);

if  cotise >= 1 then
set mes = concat ( 'il a deja la cotisation' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;

--Client--
--Doit avoir payer la cotisation annuelle--x
delimiter |
create or replace trigger cotisation_avant_reserve before insert on RESERVATION for each row
begin

declare datereserve date  ;
declare cotise int;
declare mes varchar (100) ;

select dateCours into datereserve from reserver where   dateCours = new.dateCours ;
select count(anneesCoti) into cotise from payer where idClient = new.idClient and anneesCoti = YEAR(datereserve);

if  cotise < 1 then
set mes = concat ( 'il na pas la cotisation' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;

--Doit avoir les fonds suffisant sur son solde-- 
delimiter |
create or replace trigger sufisant_fonds_avant_reserve before insert on RESERVATION for each row
begin

declare soldes int  ;
declare montant_cours int;
declare mes varchar (100) ;
declare idNiveau_cours INT ;
select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;

select solde into soldes from Client where   idClient = new.idClient ;
select prix into montant_cours from COURS where idCours = new.idCours and  idNiveau = idNiveau_cours;

if  soldes < montant_cours then
set mes = concat ( 'il na pas assez de fond' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
delimiter ;







--
--
--






--Les horaires du cours doivent être dans ses disponibilités-- partie 1
REPRESENTATION
DISPONIBILITE

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


--Les horaires du cours doivent être dans ses disponibilités-- partie 2
REPRESENTATION
DISPONIBILITE

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


--Les horaires du cours doivent être dans ses disponibilités-- partie 3
REPRESENTATION
DISPONIBILITE

create or replace trigger cours_depasse_planning before insert on REPRESENTATION for each row
begin
declare durees INT ;
declare finHeureDispos DECIMAL ;
declare mes varchar (100) ;
select duree into durees from COURS where  idCours = new.idCours;
select finHeureDispo into finHeureDispos from DISPONIBILITE where  usernameMoniteur = new.usernameMoniteur and dateDispo = new.dateCours  ;

if finHeureDispos > new.heureDebutCours + duree then
set mes = concat ( 'le moniteur ne peux pas realiser ce cours car il depasse son temps de travails' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |






--Les horaires du cours doivent être dans ses disponibilités-- partie 4
REPRESENTATION
DISPONIBILITE

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


--Les horaires du cours doivent être dans ses disponibilités-- partie 5
REPRESENTATION
DISPONIBILITE

create or replace trigger court_deja_present_1h_avant_representer before insert on REPRESENTATION for each row
begin
declare durees INT ;
declare est_chevaucher boolean default false ;
declare mes varchar (100) ;


select duree into durees from COURS where  idCours = new.idCours;

call proc_heure_avant (new.heureDebutCours ,new.dateCours,new.usernameMoniteur,durees,est_chevaucher) ;


if est_chevaucher = true then
set mes = concat ( 'un precedent cours chevauche le nouveau' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;

end |


delimiter |
create or replace procedure proc_heure_avant (heure_deb DECIMAL,dateCourss DATE,usernameMoniteur VARCHAR,duree_existant INT,est_chevaucher boolean ) as
heure_deb DECIMAL;
dateCourss DATE;
usernameMoniteurs VARCHAR(32);
duree_existant INT;
 est_chevaucher boolean;

begin
declare identifant_cours int;

declare durees INT ;
declare heureDebutCourss DECIMAL;
declare fini boolean default false ;
declare lesCours cursor for

select idcours from REPRESENTATION where dateCours = dateCourss and usernameMoniteur = usernameMoniteurs and heureDebutCours < heure_deb;

declare continue handler for not found set fini = true;
open lesCours ;
while not fini do
    fetch lesCours into identifant_cours ;
    if not fini then
        select duree into durees from COURS where idCours = identifant_cours
        select heureDebutCours into heureDebutCourss from COURS where idCours = identifant_cours

        if heureDebutCourss+durees < heure_deb + duree_existant then
                est_chevaucher = true;
        end if ;
    end if ;
end while ;
close lesCours ;
select est_chevaucher ;

end |
delimiter ;
