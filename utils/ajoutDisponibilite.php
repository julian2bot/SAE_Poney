<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

function convertTimeToFloat(string $time):float{
    $timeList = explode(':', $time);
    return (int)$timeList[0] + ($timeList[1] == "30" ? 0.5 : 0);
}

if(($_SESSION["connecte"]["role"] === "moniteur" || $_SESSION["connecte"]["role"] === "admin") && 
    isset($_POST["dateDispo"]) &&
    isset($_POST["heureDebut"]) && 
    isset($_POST["heureFin"])){
    if($_POST["heureDebut"] >= $_POST["heureFin"]){
        createPopUp("L'heure de fin ne peut pas être avant l'heure de début",false);
        header("Location: ../page/disponibilite.php");
        exit;
    }
    // else if(existDateDispoDay($bdd,$_SESSION["connecte"]["username"], $_POST["dateDispo"])){
    //     createPopUp("Dispo pour ce jour déjà défini",false);
    //     header("Location: ../page/disponibilite.php");
    //     exit;
    // }
    else{
        // echo "<pre>";
        // print_r($_POST);
        // echo convertTimeToFloat($_POST["heureDebut"])."<br>";
        // echo convertTimeToFloat($_POST["heureFin"]);
        // echo "</pre>";

        $heureDebut = convertTimeToFloat($_POST["heureDebut"]);
        $heureFin = convertTimeToFloat($_POST["heureFin"]);

        $insertMoniteur = $bdd->prepare("INSERT INTO DISPONIBILITE(usernameMoniteur, heureDebutDispo, dateDispo, heureFinDispo) VALUES(?, ?, ?, ?)");
        $insertMoniteur->execute(array(
            $_SESSION["connecte"]["username"],
            $heureDebut,
            $_POST["dateDispo"],
            $heureFin,));
        createPopUp("Disponibilité ajoutée avec succès");
    }
}

header("Location: ../page/disponibilite.php");
exit;