
--Poney--
-- a revoire--
create or replace trigger repos before insert on RESERVATION for each row
begin
declare Debut_heure_cours DECIMAL(2,1) ;
declare mes varchar (100) ;
select heureDebutCours into Debut_heure_cours from RESERVATION where dateCours = new.dateCours AND idPoney = new.idPoney AND ;
select count ( idp ) int o nbins from PARTICIPER where ida = new.ida ;

if  new.heureDebutCours not in ( ’ oui ’ , ’ non ’) )  then
set mes = concat ( 'inscription impossible' , new.idPoney , 'na pas terminer son repos') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
----












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
