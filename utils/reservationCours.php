<?php
require_once "./connexionBD.php";
require_once "./annexe.php";


print_r($_POST);

if(
        !isset($_POST["idCours"]) 
    AND !isset($_POST["usernameMoniteur"]) 
    AND !isset($_POST["dateCours"]) 
    AND !isset($_POST["heureDebutCours"]) 
    AND !isset($_POST["userclient"]) 
    AND !isset($_POST["poneySelectionne"])
){
    header("Location: ../");
    exit;
}

$dateCours = $_POST["dateCours"];


$insertReservation = $bdd->prepare("INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES(?, ?, ?, ?, ?, ?)");
$insertReservation->execute(array(
    
    (int)$_POST["idCours"]
    ,$_POST["usernameMoniteur"]
    , $dateCours
    ,$_POST["heureDebutCours"]
    ,$_POST["userclient"]
    ,(int)$_POST["poneySelectionne"]    
));



?>