<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
require_once "../utils/constante.php";

estConnecte();
// TODO

require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";


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
        header("Location: ../page/demandeCours.php");
        exit;
    }
    else if(getDemandeExistDay($bdd,$_SESSION["connecte"]["username"],$_POST["dateDemandeCours"])){
        createPopUp("Vous avez déjà réalisé une demande de cours pour ce jour",false);
        header("Location: ../page/demandeCours.php");
        exit;
    }

    // Insertion dans la BD

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

}
header("Location: ../page/demandeCours.php");
exit;




$email = "marquesjulian26@gmail.com";
$object = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h";
$objectConfirmation = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h a bien été confirmée";
$objectConfirmationMoniteur = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h a bien été confirmée";

$username= $_POST["usernameClient"];
$dateDemandeCours= $_POST["dateDemandeCours"];
$heureCours= $_POST["heureCours"];
$dureeCours= $_POST["heure"];
$activiteDuCours= $_POST["activiteDuCours"];

$moniteurName = "michel"; // pour test dans un premier temps la valeur on la connait plus tard

if(mailClientDemandeCours(SENDINGEMAIL,$email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail envoyer";
}
else{
    echo "mail non envoyer";
}


if(mailClientDemandeCoursConfirme(SENDINGEMAIL, $email, $username, $objectConfirmation, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail confirme envoyer";
}
else{
    echo "mail confirme non envoyer";
}




if(mailMoniteurDemandeCoursConfirme(SENDINGEMAIL, $email, $moniteurName, $username, $objectConfirmationMoniteur, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail confirme envoyer";
}
else{
    echo "mail confirme non envoyer";
}



?>