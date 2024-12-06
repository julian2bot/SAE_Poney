<?php

require_once "./connexionBD.php";
require_once "./annexe.php";

if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){
    header("Location: ../");
    exit;
}
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
        $erreur = 
        header("Location: ../page/administration.php");
        exit;

    }
}

header("Location: ../page/administration.php");
exit;






