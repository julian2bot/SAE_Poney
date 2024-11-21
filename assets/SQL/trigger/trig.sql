--Un client ne doit pouvoir réserver qu’une cotisation par année--x
delimiter |
create or replace trigger une_cotisation_pas_plus before insert on PAYER for each row
begin
    declare datereserve date  ;
    declare cotise varchar (9);
    declare mes varchar (100) ;

    select count(periode) into cotise from PAYER where usernameClient = new.usernameClient and periode =NEW.periode ;

    if  cotise >= 1 then
        set mes = concat ( 'le ',NEW.usernameClient,' a deja la cotisation payer du ',NEW.periode ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if ;
end |
delimiter ;
