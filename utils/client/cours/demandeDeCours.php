<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
require_once __DIR__."/../../constante.php";

estConnecte();
// TODO

// require_once __DIR__."/../../BDD/connexionBD.php";
// require_once __DIR__."/../../annexe.php";


echo "<pre>";
print_r($_POST);
echo "</pre>";

if(isset($_POST["poneySelectionne"]) &&
isset($_POST["dateDemandeCours"]) &&
isset($_POST["niveau"]) &&
isset($_POST["heureCours"]) &&
isset($_POST["heure"])){

    // Trouver le cours perso

    $coursPerso = getCoursPerso($bdd,(int)$_POST["niveau"], $_POST["heure"]);
    echo $coursPerso["idCours"];

    if(!isset($coursPerso["idCours"])){
        createPopUp("Problème pour trouver un cours adéquat",false);
        header("Location: ../../../page/demandeCours.php");
        exit;
    }
    else if(getDemandeExistDay($bdd,$_SESSION["connecte"]["username"],$_POST["dateDemandeCours"])){
        createPopUp("Vous avez déjà réalisé une demande de cours pour ce jour",false);
        header("Location: ../../../page/demandeCours.php");
        exit;
    }

    // Insertion dans la BD

    $soldeCourant = updateDecrSoldeCLient($bdd, $_SESSION["connecte"]["username"], $coursPerso["prix"]);
    if($soldeCourant === -1){
        $err ="Votre solde n'est pas assez élevé";
        // header("Location: ../../../page/adherent.php?errReservCours=".$err);
        // exit;
    }

    $insertDemandeCours = $bdd->prepare("INSERT INTO DEMANDECOURS (usernameClient, idCours, idPoney, dateCours, heureDebutCours, demande) VALUES (?, ?, ?, ?, ?, ?)");
    $insertDemandeCours->execute(array(
        $_SESSION["connecte"]["username"],
        $coursPerso["idCours"],
        $_POST["poneySelectionne"],
        $_POST["dateDemandeCours"],
        convertTimeToFloat($_POST["heureCours"]),
        ($_POST["activiteDuCours"] == "") ? "Aucune activité précise" : $_POST["activiteDuCours"]));
    createPopUp("Demande de cours envoyée avec succès, vous recevrez un mail quand votre demande sera accepté");

    // Envoyer mail
    
    // $email = "marquesjulian26@gmail.com";
    $leClient = getPersonne($bdd, $_POST["usernameClient"]);
    $email = $leClient["mail"];
    $object = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h";

    $username= strtoupper($leClient["nomPersonne"])." ".$leClient["prenomPersonne"];
    $dateDemandeCours= $_POST["dateDemandeCours"];
    $heureCours= $_POST["heureCours"];
    $dureeCours= $_POST["heure"];
    $activiteDuCours= $_POST["activiteDuCours"];

    // Envoyer mail
    
    if(mailClientDemandeCours(SENDINGEMAIL,$email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
        echo "mail envoyer";
    }
    else{
        echo "mail non envoyer";
    }


}
header("Location: ../../../page/demandeCours.php");
exit;





?>