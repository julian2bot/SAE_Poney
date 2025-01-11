<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";



if(($_SESSION["connecte"]["role"] === "moniteur" || $_SESSION["connecte"]["role"] === "admin") && 
    isset($_POST["previousDate"]) &&
    isset($_POST["previousTime"]) &&
    isset($_POST["dateDispo"]) &&
    isset($_POST["heureDebut"]) && 
    isset($_POST["heureFin"])){
    $heureDebutPrevious = convertTimeToFloat($_POST["previousTime"]);
    if($_POST["heureDebut"] >= $_POST["heureFin"]){
        createPopUp("L'heure de fin ne peut pas être avant l'heure de début",false);
        header("Location: ../../../page/moniteur.php#gestionDisponibilitep");
        exit;
    }
    else if((new DateTime($_POST["dateDispo"]) == new DateTime($_POST["previousDate"]))){
        if(existDateDispoConflit($bdd,$_SESSION["connecte"]["username"], $_POST["dateDispo"],$_POST["heureDebut"],$_POST["heureFin"],$heureDebutPrevious)){
            createPopUp("Un conflit existe avec les disponibilités déjà entrée, veuillez les modifier",false);
            header("Location: ../../../page/modifierDisponibilite.php?dateDispo=$_POST[previousDate]&debutDispo=$heureDebutPrevious");
            exit;
        }
    }
    else if(existDateDispoConflit($bdd,$_SESSION["connecte"]["username"], $_POST["dateDispo"],$_POST["heureDebut"],$_POST["heureFin"])){
        createPopUp("Un conflit existe avec les disponibilités déjà entrée, veuillez les modifier",false);
        header("Location: ../../../page/modifierDisponibilite.php?dateDispo=$_POST[previousDate]&debutDispo=$heureDebutPrevious");
        exit;
    }
    else{
        $heureDebut = convertTimeToFloat($_POST["heureDebut"]);
        $heureFin = convertTimeToFloat($_POST["heureFin"]);

        $updateSql = "UPDATE DISPONIBILITE
        SET heureDebutDispo = ?,
            dateDispo = ?, 
            heureFinDispo = ?
        WHERE usernameMoniteur = ? AND heureDebutDispo = ? AND dateDispo = ?";

        $updateStmt = $bdd->prepare($updateSql);

        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
            $heureDebut, 
            $_POST["dateDispo"], 
            $heureFin,
            $_SESSION["connecte"]["username"], 
            $heureDebutPrevious, 
            $_POST["previousDate"]]
        );

        // Vérifier le résultat
        if ($result) {
            echo "Mise à jour réussie<br>";
            createPopUp("Disponibilité modifiée avec succès");
        } else {
            $errorInfo = $updateStmt->errorInfo();
            echo "Erreur SQL : " . $errorInfo[2];
            createPopUp("Erreur SQL : " . $errorInfo[2],false);
        }

    }
}

header("Location: ../../../page/moniteur.php#gestionDisponibilite");
exit;