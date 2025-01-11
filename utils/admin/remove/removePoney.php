<?php
// code pour supprimé un poney dans la BD

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin"){

    if(isset($_GET["idPoney"]))
    {

        // suppr toute les reservations par rapport a l'id du poney
        // suppr de client
        $sql1 = "DELETE FROM RESERVATION WHERE idPoney = :id";
        $stmt1 = $bdd->prepare($sql1);
        $stmt1->execute([":id" => $_GET["idPoney"]]);
        
        $sql2 = "DELETE FROM PONEY WHERE idPoney = :id";
        $stmt2 = $bdd->prepare($sql2);
        $stmt2->execute([":id" => $_GET["idPoney"]]);
        createPopUp("Poney retiré avec succès");
    }   
}
header("Location: ../../../page/administration.php#Poney");
exit;
    
?>