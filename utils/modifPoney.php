<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["identifiant"]) &&
    isset($_POST["nomPoney"]) &&
    isset($_POST["poidMax"]) && 
    isset($_POST["photo"]) &&
    isset($_POST["race"])){
    // requete insert exemple:
    if(getRace($bdd, $_POST["race"])){

        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Préparer la requête avec des ? pour les paramètres
        // PARTIE USER
        $updateSql = "UPDATE PONEY 
                        SET nomPoney = ?,
                            poidsMax = ?, 
                            photo = ?, 
                            nomRace = ? 
                        WHERE idPoney = ?";
    
        $updateStmt = $bdd->prepare($updateSql);
        
        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
            $_POST["nomPoney"], 
            $_POST["poidMax"], 
            $_POST["photo"], 
            $_POST["race"], 
            $_POST["identifiant"]]
        );
    
        // Vérifier le résultat
        if ($result) {
            echo "Mise à jour réussie<br>";
        } else {
            $errorInfo = $updateStmt->errorInfo();
            echo "Erreur SQL : " . $errorInfo[2];
        }

        $_SESSION["erreur"] = [];
        createPopUp("Poney modifié avec succès");
    }        

    else{
        $erreur = "La race du poney n'existe pas";
        $_SESSION["erreur"] = [];
        $_SESSION["erreur"]["identifiant"] = $_POST["identifiant"];
        $_SESSION["erreur"]["nomPoney"] = $_POST["nomPoney"];
        $_SESSION["erreur"]["poidMax"] = $_POST["poidMax"];
        $_SESSION["erreur"]["photo"] = $_POST["photo"];
        $_SESSION["erreur"]["race"] = $_POST["race"];
        createPopUp($erreur,false);
        header("Location: ../page/administration.php?erreurCreerPoney=$erreur#Poney");
        exit;

    }
}

header("Location: ../page/administration.php#Poney");
exit;