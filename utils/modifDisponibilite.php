<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";



if(($_SESSION["connecte"]["role"] === "moniteur" || $_SESSION["connecte"]["role"] === "admin") && 
    isset($_POST["previousDate"]) &&
    isset($_POST["previousTime"]) &&
    isset($_POST["dateDispo"]) &&
    isset($_POST["heureDebut"]) && 
    isset($_POST["heureFin"])){
    if($_POST["heureDebut"] >= $_POST["heureFin"]){
        createPopUp("L'heure de fin ne peut pas être avant l'heure de début",false);
        header("Location: ../page/moniteur.php#gestionDisponibilitep");
        exit;
    }
    // else if(existDateDispoDay($bdd,$_SESSION["connecte"]["username"], $_POST["dateDispo"])){
    //     createPopUp("Dispo pour ce jour déjà défini",false);
    //     header("Location: ../page/disponibilite.php");
    //     exit;
    // }
    else{
        $heureDebut = convertTimeToFloat($_POST["heureDebut"]);
        $heureFin = convertTimeToFloat($_POST["heureFin"]);
        $heureDebutPrevious = convertTimeToFloat($_POST["previousTime"]);

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

header("Location: ../page/moniteur.php#gestionDisponibilite");
exit;