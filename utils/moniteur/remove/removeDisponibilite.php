<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

if(($_SESSION["connecte"]["role"] === "moniteur" || $_SESSION["connecte"]["role"] === "admin") && 
    isset($_POST["previousDate"]) &&
    isset($_POST["previousTime"])){
   
        $heureDebutPrevious = convertTimeToFloat($_POST["previousTime"]);

        $updateSql = "DELETE FROM DISPONIBILITE
        WHERE usernameMoniteur = ? AND heureDebutDispo = ? AND dateDispo = ?";

        $updateStmt = $bdd->prepare($updateSql);

        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
            $_SESSION["connecte"]["username"], 
            $heureDebutPrevious, 
            $_POST["previousDate"]]
        );
        
        createPopUp("Disponibilité reitrée avec succès");
}
 

header("Location: ../../../page/moniteur.php#gestionDisponibilite");
exit;

?>