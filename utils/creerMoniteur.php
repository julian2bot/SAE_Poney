<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();


if($_SESSION["connecte"]["role"] === "admin" && 
    isset($_POST["usernameMoniteur"]) &&
    isset($_POST["prenomMoniteur"]) && 
    isset($_POST["nomMoniteur"]) &&
    isset($_POST["Mail"]) &&
    isset($_POST["estAdmin"]) &&
    isset($_POST["salaire"])){
    // requete insert exemple:
    if(existMail($bdd,$_POST["Mail"])){
        $erreur = "Ce mail est déjà utilisé";
        header("Location: ../page/administration.php?erreurCreerMoniteur=$erreur");
        exit;
    }
    else if(existUsername($bdd,$_POST["usernameMoniteur"])){
        $erreur = "Ce nom d'utilisateur est déjà utilisé";
        header("Location: ../page/administration.php?erreurCreerMoniteur=$erreur");
        exit;
    }
    else{
        $insertmbr = $bdd->prepare("INSERT INTO PERSONNE(username, mdp, prenomPersonne, nomPersonne, mail) VALUES(?, ?, ?, ?, ?)");
        $insertmbr->execute(array(
            $_POST["usernameMoniteur"],
            $_POST["usernameMoniteur"],
            $_POST["prenomMoniteur"],
            $_POST["nomMoniteur"],
            $_POST["Mail"]));
        

        $insertMoniteur = $bdd->prepare("INSERT INTO MONITEUR(usernameMoniteur, salaire, isAdmin) VALUES(?, ?, ?)");
        $insertMoniteur->execute(array(
            $_POST["usernameMoniteur"],
            (int)$_POST["salaire"],
            ($_POST["estAdmin"] == "Oui") ? 1:0));
    }
}

header("Location: ../page/administration.php");
exit;