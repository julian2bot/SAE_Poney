<?php
// code pour reserver un cours et l'ajouter a la BD

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

estConnecte();

// print_r($_POST);

if(!isset($_POST["idCours"]) 
    && !isset($_POST["usernameMoniteur"]) 
    && !isset($_POST["dateCours"]) 
    && !isset($_POST["heureDebutCours"]) 
    && !isset($_POST["userclient"]) 
    && !isset($_POST["poneySelectionne"])
    && !isset($_POST["prix"])
){
    header("Location: ../../../");
    exit;
}

$dateCours = $_POST["dateCours"];

print_r(getSoldeClient($bdd, $_POST["userclient"]));

try {
    if(existReservation($bdd,$_POST["usernameMoniteur"],(int)$_POST["idCours"], $dateCours,$_POST["heureDebutCours"],$_POST["userclient"])){
        createPopUp("Vous avez déjà réservé ce cours",false);
        header("Location: ../../../page/adherent.php");
        exit;
    }

    $soldeCourant = updateDecrSoldeCLient($bdd, $_POST["userclient"], (int)$_POST["prix"]);
    if($soldeCourant === -1){
        createPopUp("Votre solde n'est pas suffisamment élevé",false);
        header("Location: ../../../page/adherent.php?errReservCours=".$err);
        exit;
    }


    if(estTropLourd($bdd, $_POST["poneySelectionne"], $_SESSION["connecte"]["username"])){
        
        createPopUp("Votre poids est supérieur à ce que le poney peut porter.", false);
        header("Location: ../../../page/adherent.php");
        exit;
    }

    $insertReservation = $bdd->prepare("INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES(?, ?, ?, ?, ?, ?)");
    $insertReservation->execute(array(
        (int)$_POST["idCours"]
        ,$_POST["usernameMoniteur"]
        , $dateCours
        ,$_POST["heureDebutCours"]
        ,$_POST["userclient"]
        ,(int)$_POST["poneySelectionne"]    
    ));

    createPopUp("Cour réservé avec succès");
    header("Location: ../../../");
    exit;

} catch (PDOException $e) {
    echo "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
    createPopUp("Erreur lors de la reservation du cours",false);
    header("Location: ../../../page/adherent.php");
    exit;
}





?>