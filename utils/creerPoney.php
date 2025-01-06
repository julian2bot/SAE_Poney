<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["nomPoney"]) &&
    isset($_POST["poidMax"]) && 
    isset($_POST["photo"]) &&
    isset($_POST["race"])){
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
        $_SESSION["erreur"] = [];
    }
    else{
        $erreur = "La race du poney n'existe pas";
        $_SESSION["erreur"] = [];
        $_SESSION["erreur"]["nomPoney"] = $_POST["nomPoney"];
        $_SESSION["erreur"]["poidMax"] = $_POST["poidMax"];
        $_SESSION["erreur"]["photo"] = $_POST["photo"];
        $_SESSION["erreur"]["race"] = $_POST["race"];
        header("Location: ../page/administration.php?erreurCreerPoney=$erreur");
        exit;

    }
}

header("Location: ../page/administration.php");
exit;






