--Doit avoir les fonds suffisant sur son solde-- 
delimiter |
create or replace trigger sufisant_fonds_avant_reserve before insert on RESERVATION for each row
begin
    declare soldes int  ;
    declare montant_cours int;
    declare mes varchar (100) ;
    declare idNiveau_cours INT ;

    select idNiveau into idNiveau_cours from COURS where idCours = new.idCours  ;
    select solde into soldes from CLIENT where   usernameClient = new.usernameClient ;
    select prix into montant_cours from COURS where idCours = new.idCours and  idNiveau = idNiveau_cours;

    if  soldes < montant_cours then
        set mes = concat ( 'le ',new.usernameClient,' n a pas assez de fond le solde est a ',soldes ,' contre ', montant_cours,' a payer' ) ;
        signal SQLSTATE '45000' set MESSAGE_TEXT = mes ;
    end if;
end |
delimiter ;
