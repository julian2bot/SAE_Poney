<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin"){

    if(isset($_GET["idPoney"]))
    {

        // suppr toute les reservations par rapport au nom du moniteur
        // suppr de client
        $sql = "DELETE FROM RESERVATION WHERE idPoney = :id;
                DELETE FROM PONEY WHERE idPoney = :id;";

        
        $stmt = $bdd->prepare($sql);
        $stmt ->execute([":id" => $_GET["idPoney"]]);
    }   
}
header("Location: ../page/administration.php");
exit;
    
?>