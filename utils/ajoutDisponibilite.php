<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";



if(($_SESSION["connecte"]["role"] === "moniteur" || $_SESSION["connecte"]["role"] === "admin") && 
    isset($_POST["dateDispo"]) &&
    isset($_POST["heureDebut"]) && 
    isset($_POST["heureFin"])){
    if($_POST["heureDebut"] >= $_POST["heureFin"]){
        createPopUp("L'heure de fin ne peut pas être avant l'heure de début",false);
        header("Location: ../page/disponibilite.php");
        exit;
    }
    else if(existDateDispoConflit($bdd,$_SESSION["connecte"]["username"], $_POST["dateDispo"],$_POST["heureDebut"],$_POST["heureFin"])){
        createPopUp("Un conflit existe avec les disponibilités déjà entrée, veuillez les modifier",false);
        header("Location: ../page/disponibilite.php");
        exit;
    }
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