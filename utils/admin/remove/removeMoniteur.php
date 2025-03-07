<?php
// code pour supprimé un moniteur dans la BD

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin"){

    if(isset($_GET["id"]))
    {

        // suppr toute les reservations par rapport au nom du moniteur
        // suppr de client
        
        $stmt1 = $bdd->prepare("DELETE FROM DISPONIBILITE WHERE usernameMoniteur = :id");
        $stmt1->execute([":id" => $_GET["id"]]);

        $stmt2 = $bdd->prepare("DELETE FROM RESERVATION WHERE usernameMoniteur = :id");
        $stmt2->execute([":id" => $_GET["id"]]);
        
        $stmt3 = $bdd->prepare("DELETE FROM REPRESENTATION WHERE usernameMoniteur = :id");
        $stmt3->execute([":id" => $_GET["id"]]);

        $stmt4 = $bdd->prepare("DELETE FROM MONITEUR WHERE usernameMoniteur = :id");
        $stmt4->execute([":id" => $_GET["id"]]);

        $sql6 = "DELETE FROM OBTENTION WHERE username = :id";
        $stmt6 = $bdd->prepare($sql6);
        $stmt6->execute([":id" => $_GET["id"]]);

        $stmt5 = $bdd->prepare("DELETE FROM PERSONNE WHERE username = :id");
        $stmt5->execute([":id" => $_GET["id"]]);


        createPopUp("Moniteur retiré avec succès");
    }   
}
header("Location: ../../../page/administration.php#Moniteurs");
exit;
    
?>