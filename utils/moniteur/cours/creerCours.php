<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

if(isset($_POST["niveau"]) &&
isset($_POST["nom"]) &&
isset($_POST["choixheure"]) &&
isset($_POST["nbmax"]) &&
isset($_POST["prix"]) &&
isset($_POST["description"]) &&
isset($_POST["datevalider"]) &&
isset($_POST["temp"])){
    $idNiveau = (int)$_POST['niveau'];
    $nomCours = $_POST['nom'];
    $duree = (int)$_POST['choixheure'];
    $prix = (int)$_POST['prix'];
    $nbMax = (int)$_POST['nbmax'];
    
    $usernameMoniteur = $_SESSION["connecte"]["username"];
    $activite = $_POST['description'];
    $dateCours = $_POST['datevalider'];
    $temp = convertTimeToFloat($_POST['temp']);

    echo $_POST['temp']," ",convertFloatToTime($temp + $duree);

    $estDisponible = moniteurEstDispo($bdd,$usernameMoniteur,$dateCours,$_POST['temp'],convertFloatToTime($temp + $duree));
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
    
        $sql = "SELECT MAX(idCours) AS derniere_id FROM COURS";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
    
        // Récupérer la valeur
        $result = $stmt->fetch();
        if ($result && isset($result['derniere_id'])) {
            $idCours = $result['derniere_id'];
            $idCours = (int)$idCours+1;
        } else {
            $idCours = 0;
        }
    
        $insertionCours = $bdd->prepare("INSERT INTO COURS(idCours,idNiveau,nomCours,duree,prix,nbMax) VALUES(?, ?, ?, ?, ?, ?)");
        $insertionCours->execute(array(
            $idCours,
            $idNiveau,
            $nomCours,
            $duree,
            $prix,
            $nbMax
        ));
    
        $insertionRepresentation = $bdd->prepare("INSERT INTO REPRESENTATION (idCours,usernameMoniteur,dateCours,heureDebutCours,activite) VALUES(?, ?, ?, ?, ?)");
        $insertionRepresentation->execute(array(
            $idCours,
            $usernameMoniteur,
            $dateCours,
            $temp,
            $activite
        ));
    
        // // Redirection vers moniteur
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
