<?php
// code pour reserver un cours et l'ajouter a la BD

require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

estConnecte();

if(!isset($_POST["idCours"]) 
    || !isset($_POST["usernameMoniteur"]) 
    || !isset($_POST["dateCours"]) 
    || !isset($_POST["heureDebutCours"]) 
    || !isset($_POST["userclient"]) 
){
    header("Location: ../../../");
    exit;
}

$representation = getRepresentation($bdd,(int)$_POST["idCours"],$_POST["usernameMoniteur"],$_POST["dateCours"],$_POST["heureDebutCours"]);

if(isset($representation["idCours"])){
    $solde = remboursementClientReservation($bdd,$_POST["userclient"],(int)$_POST["idCours"],$_POST["usernameMoniteur"],$_POST["dateCours"],$_POST["heureDebutCours"]);
    if($solde == -1){
        createPopUp("Erreur lors de la suprresion de la réservation",false);
        header("Location: ../../../page/adherent.php");
        exit;
    }
    try {
        
        $insertReservation = $bdd->prepare("DELETE FROM RESERVATION WHERE idCours = ? AND usernameMoniteur = ? AND dateCours = ? AND heureDebutCours = ? AND usernameClient = ?");
        $insertReservation->execute(array(
            (int)$_POST["idCours"]
            ,$_POST["usernameMoniteur"]
            ,$_POST["dateCours"]
            ,$_POST["heureDebutCours"]
            ,$_POST["userclient"]
        ));
    
        createPopUp("Réservation annulé avec succès, vous avez été remboursé de $solde");
        header("Location: ../../../");
        exit;
    
    } catch (PDOException $e) {
        echo "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
        createPopUp("Erreur lors de la reservation du cours",false);
        header("Location: ../../../page/adherent.php");
        exit;
    }
}

?>