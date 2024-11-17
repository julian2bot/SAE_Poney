--Peuvent porter jusqu'à un poids max dans réservation--

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




--Personne--
--Client doit pas être moniteur--

create or replace trigger admine_ou_client before insert on CLIENT for each row
begin
declare identifiant_Client int ;
declare identifiant_Moniteur int ;
declare mes varchar (100) ;
select idClient into identifiant_Client from CLIENT where  idClient = new.idPersonne  ;
select idanim into identifiant_Moniteur from MONITEUR where  idanim = new.idPersonne  ;

if  new.idPersonne =  identifiant_Moniteur then
set mes = concat ( 'inscription impossible le client numero' , new.idClient , 'est Moniteur') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
if  new.idPersonne =  identifiant_Client then
set mes = concat ( 'inscription impossible le client numero' , new.idClient , 'est deja present dans la base') ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |



--Moniteur--
--Moniteur Avoir le niveau nécessaire pour encadrer un cour--
--OBTENTION--
--COURS--
--RESERVATION--
create or replace trigger niveauMoniteur_avant_reserve before insert on RESERVATION for each row
begin
declare idNiveau_moniteur TINYINT ;
declare mes varchar (100) ;
select idNiveau into idNiveau_moniteur from OBTENTION where  idPersonne = new.idMoniteur  ;

if  idNiveau_moniteur <  new.idNiveau then
set mes = concat ( 'inscription impossible le niveau' , new.idNiveau , 'de', new.idMoniteur,'est trop faible' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |


--et--
--OBTENTION--
--COURS--
--REPRESENTATION--
create or replace trigger niveauMoniteur_avant_representer before insert on REPRESENTATION for each row
begin
declare idNiveau_moniteur TINYINT ;
declare mes varchar (100) ;
select idNiveau into idNiveau_moniteur from OBTENTION where  idPersonne = new.idPersonne  ;
if  idNiveau_moniteur <  new.idNiveau then
set mes = concat ( 'inscription impossible le niveau' , new.idNiveau , 'de', new.idMoniteur,'est trop faible' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |



--Client--
--Il doit rester de la place dans le cours--
COURS
RESERVATION

create or replace trigger niveauMoniteur_avant_representer before insert on RESERVATION for each row
begin
declare nbmax int ;
declare nbins int ;
declare mes varchar (100) ;
select nbMax into nbmax from COURS where idCours = new.idCours and idNiveau = new.idNiveau ;
select count ( idClient ) into nbins from RESERVATION where idCours = new.idCours and idNiveau = new.idNiveau ;
if nbins +1 > nbmax then
    set mes = concat ( 'inscription impossible le cours est complet' ) ;
    signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |


--Doit avoir le niveau nécessaire --
create or replace trigger niveauMoniteur_avant_reserve before insert on RESERVATION for each row
begin
declare idNiveau_client TINYINT ;
declare mes varchar (100) ;

select idNiveau into idNiveau_client from OBTENTION where  idPersonne = new.idClient and   ;

if  idNiveau_client <  new.idNiveau then
set mes = concat ( 'inscription impossible le niveau' , new.idNiveau , 'de', new.idClient,'est trop faible' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |
--update--
create or replace trigger niveauMoniteur_avant_reserve before update on RESERVATION for each row
begin
declare idNiveau_client TINYINT ;
declare mes varchar (100) ;
select idNiveau into idNiveau_client from OBTENTION where  idPersonne = new.idClient  ;
if  idNiveau_client <  new.idNiveau then
set mes = concat ( 'inscription impossible le niveau' , new.idNiveau , 'de', new.idClient,'est trop faible' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |




--Client--
--Doit avoir payer la cotisation annuelle--x
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

--Un client ne doit pouvoir réserver qu’une cotisation par année--x

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

------------------------------------------------------------
--Doit avoir les fonds suffisant sur son solde-- 
create or replace trigger sufisant_fonds_avant_reserve before insert on RESERVATION for each row
begin

declare soldes int  ;
declare montant_cours int;
declare mes varchar (100) ;

select solde into soldes from Client where   idClient = new.idClient ;
select prix into montant_cours from COURS where idCours = new.idCours and  idNiveau = new.idNiveau;

if  soldes < montant_cours then
set mes = concat ( 'il na pas assez de fond' ) ;
signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
end if ;
end |