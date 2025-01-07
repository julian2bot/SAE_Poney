<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();

function setErrors(){
    $_SESSION["erreur"] = [];
    $_SESSION["erreur"]["identifiant"] = $_POST["identifiant"];
    $_SESSION["erreur"]["usernameMoniteur"] = $_POST["usernameMoniteur"];
    $_SESSION["erreur"]["nomMoniteur"] = $_POST["nomMoniteur"];
    $_SESSION["erreur"]["prenomMoniteur"] = $_POST["prenomMoniteur"];
    $_SESSION["erreur"]["ancienMail"] = $_POST["ancienMail"];
    $_SESSION["erreur"]["Mail"] = $_POST["Mail"];
    $_SESSION["erreur"]["estAdmin"] = $_POST["estAdmin"];
    $_SESSION["erreur"]["salaire"] = $_POST["salaire"];
}

if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["identifiant"]) &&
    isset($_POST["ancienMail"]) &&
    isset($_POST["usernameMoniteur"]) &&
    isset($_POST["prenomMoniteur"]) && 
    isset($_POST["nomMoniteur"]) &&
    isset($_POST["Mail"]) &&
    isset($_POST["estAdmin"]) &&
    isset($_POST["salaire"])){

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    // requete insert exemple:
    if($_POST["ancienMail"] != $_POST["Mail"] && existMail($bdd,$_POST["Mail"])){
        $erreur = "Ce mail est déjà utilisé";
        setErrors();
        header("Location: ../page/administration.php?erreurModifMoniteur=$erreur#Moniteurs");
        exit;
    }
    else if($_POST["identifiant"] != $_POST["usernameMoniteur"] && existUsername($bdd,$_POST["usernameMoniteur"])){
        $erreur = "Ce nom d'utilisateur est déjà utilisé";
        setErrors();
        header("Location: ../page/administration.php?erreurModifMoniteur=$erreur#Moniteurs");
        exit;
    }
    else{
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Préparer la requête avec des ? pour les paramètres
        // PARTIE USER
        $updateSql = "UPDATE PERSONNE 
                        SET username = ?,
                            prenomPersonne = ?, 
                            nomPersonne = ?, 
                            mail = ? 
                        WHERE username = ? AND mail = ?";
    
        $updateStmt = $bdd->prepare($updateSql);
        
        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
            $_POST["usernameMoniteur"], 
            $_POST["prenomMoniteur"], 
            $_POST["nomMoniteur"], 
            $_POST["Mail"], 
            $_POST["identifiant"], 
            $_POST["ancienMail"]]
        );
    
        // Vérifier le résultat
        if ($result) {
            echo "Mise à jour réussie<br>";
        } else {
            $errorInfo = $updateStmt->errorInfo();
            echo "Erreur SQL : " . $errorInfo[2];
        }

        // PARTIE MONITEUR

        $updateSql = "UPDATE MONITEUR 
        SET salaire = ?, 
            isAdmin = ?
        WHERE usernameMoniteur = ?";

        $updateStmt = $bdd->prepare($updateSql);

        // Exécuter la requête avec les paramètres dans le bon ordre
        $result = $updateStmt->execute([
        $_POST["salaire"], 
        (($_POST["estAdmin"] == "oui") ? 1 : 0), 
        $_POST["usernameMoniteur"]]
        );

        // Vérifier le résultat
        if ($result) {
        echo "Mise à jour réussie<br>";
        } else {
        $errorInfo = $updateStmt->errorInfo();
        echo "Erreur SQL : " . $errorInfo[2];
        }
        
        $_SESSION["erreur"] = [];
        }
}

header("Location: ../page/administration.php#Moniteurs");
exit;