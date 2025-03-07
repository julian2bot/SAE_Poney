<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

if(isset($_POST["cours"]) &&
isset($_POST["description"]) &&
isset($_POST["datevalider"]) &&
isset($_POST["temp"])){
    $idCours = (int)$_POST["cours"];
    $usernameMoniteur = $_SESSION["connecte"]["username"];
    $activite = $_POST['description'];
    $dateCours = $_POST['datevalider'];
    $temp = convertTimeToFloat($_POST['temp']);
    $leCours = getCours($bdd,$idCours);

    $estDisponible = moniteurEstDispo($bdd,$usernameMoniteur,$dateCours,$_POST['temp'],convertFloatToTime($temp + $leCours["duree"]));
    if($estDisponible==0){
        createPopUp("Vous avez déjà un cours qui rentre en conflit avec celui ci",false);
        header("Location: ../../../page/creerCours.php");
        exit;
    }
    else if($estDisponible == -1){
        createPopUp("Vous n'avez pas de disponibilité matchant avec ce cours",false);
        header("Location: ../../../page/creerCours.php");
        exit;
    }
    
    try {
        // Récupérer les données
        $insertionRepresentation = $bdd->prepare("INSERT INTO REPRESENTATION (idCours,usernameMoniteur,dateCours,heureDebutCours,activite) VALUES(?, ?, ?, ?, ?)");
        $insertionRepresentation->execute(array(
            $idCours,
            $usernameMoniteur,
            $dateCours,
            $temp,
            $activite
        ));
    
        // Redirection vers moniteur
        createPopUp("Cours crée avec succès");
        header("Location: ../../../page/moniteur.php#creerCours");
        exit;
    }
    
    catch (Exeption $e) {
        echo 'Echec :' .$e->getMessage();
        // Redirection vers creationCours
        createPopUp("Impossible de créer le cours",false);
        header("Location: ../../../page/creerCours.php");
        exit;
    }
    
}

header("Location: ../../../page/creerCours.php");
exit;
?>
