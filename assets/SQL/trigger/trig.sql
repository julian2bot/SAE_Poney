--it avoir payer la cotisation annuelle--x
delimiter |
--Client--
--Domiter |
create or replace trigger cotisation_payer_avant_reserve before insert on RESERVATION for each row
begin
    declare datereserve date  ;
    declare date_en_string varchar(10);

    declare cotise INT;
    declare mes varchar (150) ;

    set date_en_string =  CONCAT ( CAST(YEAR(new.dateCours) As varchar(4)),'-',CAST(YEAR(new.dateCours)+1 As varchar(4))) ;
    select count(periode) into cotise from PAYER where usernameClient = new.usernameClient and periode = date_en_string ;

    if  cotise < 1 then
        set mes = concat ( " le " ,NEW.usernameClient,' n a pas la cotisation actif cette annee ',date_en_string,' pour la reservation ',NEW.idCours ,' et la date ' ,new.dateCours ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;
