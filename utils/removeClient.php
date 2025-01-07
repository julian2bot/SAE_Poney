<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();

// ? est ce que je laisse la double verif??
if($_SESSION["connecte"]["role"] === "admin"){

  
    // suppr toute les factures au nom du client 
    // suppr toute les factures au nom du client 
    // suppr toute les reservations au nom du client 
    // suppr de client
    // suppr de personne
 
    if(isset($_GET["id"]))
        {

            // la meme chose d'avant mais en plusieurs fois car il y a une erreur;
            // Uncaught PDOException: SQLSTATE[HY000]: General error: 2014 Cannot execute queries while there are pending result sets. Consider unsetting the previous PDOStatement or calling PDOStatement::closeCursor()  

            $sql1 = "DELETE FROM FACTURE_SOLDE WHERE usernameClient = :id";
            $stmt1 = $bdd->prepare($sql1);
            $stmt1->execute([":id" => $_GET["id"]]);

            $sql2 = "DELETE FROM PAYER WHERE usernameClient = :id";
            $stmt2 = $bdd->prepare($sql2);
            $stmt2->execute([":id" => $_GET["id"]]);

            $sql3 = "DELETE FROM RESERVATION WHERE usernameClient = :id";
            $stmt3 = $bdd->prepare($sql3);
            $stmt3->execute([":id" => $_GET["id"]]);

            $sql4 = "DELETE FROM CLIENT WHERE usernameClient = :id";
            $stmt4 = $bdd->prepare($sql4);
            $stmt4->execute([":id" => $_GET["id"]]);

            $sql5 = "DELETE FROM PERSONNE WHERE username = :id";
            $stmt5 = $bdd->prepare($sql5);
            $stmt5->execute([":id" => $_GET["id"]]);

        echo "<pre>";
        print_r($_GET);
        print_r(getClient($bdd));
        echo "<pre>";
    }
}

header("Location: ../page/administration.php#Clients");
exit;

    
?>