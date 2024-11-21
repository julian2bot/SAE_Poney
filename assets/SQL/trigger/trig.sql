
--Doit avoir le niveau nécessaire --
delimiter |
create or replace trigger niveauClient_avant_reserve before insert on RESERVATION for each row
begin
    declare idNiveau_client TINYINT ;
    declare idNiveau_cours INT ;

    declare mes varchar (100) ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
    select idNiveau into idNiveau_client from OBTENTION where username = new.usernameClient;

    if  idNiveau_client < idNiveau_cours then
        set mes = concat ( 'inscription impossible le niveau de ', new.usernameClient,' est trop faible ', idNiveau_client,' < ',idNiveau_cours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;
