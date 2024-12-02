<?php
require_once "../utils/connexionBD.php";
if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){
    header("Location: ../");
}

if(isset($_GET["idPoney"]))
{

    $reqUser = $bdd->prepare("SELECT * FROM RESERVATION WHERE idPoney = ? ");
    $reqUser->execute([$_GET["idPoney"]]);
    $lesReserv = $reqUser->fetchAll();
    echo $userExist ;
    echo "<pre>";
    foreach ($lesReserv as $reservation) {
        print_r( $reservation);
        $sql = "DELETE FROM RESERVATION WHERE idCours = ? and usernameMoniteur = ? and dateCours = ? and heureDebutCours = ? and usernameClient = ? and idPoney = ?";
        $stmt = $bdd->prepare($sql);
        $stmt ->execute([$reservation["idCours"], $reservation["usernameMoniteur"], $reservation["dateCours"], $reservation["heureDebutCours"], $reservation["usernameClient"], $reservation["idPoney"]]);
    }
    echo "</pre>";
    
    // ! reservation a faire
    $sql = "DELETE FROM PONEY WHERE idPoney= ? ";
    $stmt = $bdd->prepare($sql);
    $stmt ->execute([$reservation["idPoney"]]);
}

header("Location: ../page/administration.php");

?>