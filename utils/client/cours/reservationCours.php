<?php
// code pour reserver un cours et l'ajouter a la BD

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

estConnecte();

// print_r($_POST);

if(
        !isset($_POST["idCours"]) 
    AND !isset($_POST["usernameMoniteur"]) 
    AND !isset($_POST["dateCours"]) 
    AND !isset($_POST["heureDebutCours"]) 
    AND !isset($_POST["userclient"]) 
    AND !isset($_POST["poneySelectionne"])
    AND !isset($_POST["prix"])
){
    header("Location: ../../../");
    exit;
}

$dateCours = $_POST["dateCours"];

print_r(getSoldeClient($bdd, $_POST["userclient"]));

try {

    $soldeCourant = updateDecrSoldeCLient($bdd, $_POST["userclient"], (int)$_POST["prix"]);
    if($soldeCourant === -1){
        $err ="Votre solde n'est pas suffisamment élevé";
        header("Location: ../../../page/adherent.php?errReservCours=".$err);
        exit;
    }


    if(estTropLourd($bdd, $_POST["poneySelectionne"], $_SESSION["connecte"]["username"])){
        
        createPopUp("Votre poids est supérieur à ce que le poney peut porter.", false);
        header("Location: ../../../page/adherent.php?errReservCours=".$err);
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

    header("Location: ../../../");
    exit;

} catch (PDOException $e) {
    echo "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
    $err ="erreur lors de la reservation du cours";
    createPopUp("Erreur lors de la réservation du cours.", false);

    header("Location: ../../../page/adherent.php?errReservCours=".$err);
    exit;
}





?>