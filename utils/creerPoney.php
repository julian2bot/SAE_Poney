<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin"){
    // requete insert exemple:
    if(getRace($bdd, $_POST["race"])){

        $insertmbr = $bdd->prepare("INSERT INTO PONEY (idPoney, nomPoney, poidsMax, photo, nomRace) VALUES(?, ?, ?, ?, ?)");
        $insertmbr->execute(array(
            getIdMax($bdd, "idPoney", "PONEY")[0] + 1,
            $_POST["nomPoney"],
            $_POST["poidMax"],
            $_POST["photo"],
            $_POST["race"]
        ));    
    }
    else{
        $erreur = "La race du poney n'existe pas";
        header("Location: ../page/administration.php?erreurCreerPoney=$erreur");
        exit;

    }
}

header("Location: ../page/administration.php");
exit;






