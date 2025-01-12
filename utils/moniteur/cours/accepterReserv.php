<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";
require_once __DIR__."/../../constante.php";

estConnecte();
estMoniteur();

echo "<pre>";
print_r($_GET);
echo "</pre>";

if(isset($_GET["userClient"]) &&
isset($_GET["idCours"]) &&
isset($_GET["dateCours"]) &&
isset($_GET["heureDebutCours"]) &&
isset($_GET["usernameMoniteur"])){

    // Get la demande de cours
    $cours = getDemandeDeCours($bdd, $_GET["userClient"], $_GET["dateCours"], (int)$_GET["idCours"], (float)$_GET["heureDebutCours"]);
    $leCours = getCours($bdd,(int)$_GET["idCours"]);
    if(! isset($cours["idCours"])){
        createPopUp("Problème pour trouver la demande de cours",false);
        header("Location: ../../../page/gestionReserv.php");
        exit;
    }

    // Vérifier les disponibilités
    $heureFinCours = convertFloatToTime($cours["heureDebutCours"] + $leCours["duree"]);
    $estDisponible = moniteurEstDispo($bdd,$_GET["usernameMoniteur"],$_GET["dateCours"],convertFloatToTime((float)$_GET["heureDebutCours"]),$heureFinCours);
    if($estDisponible==0){
        createPopUp("Vous avez déjà un cours qui rentre en conflit avec celui ci",false);
        header("Location: ../../../page/gestionReserv.php");
        exit;
    }
    else if($estDisponible == -1){
        createPopUp("Vous n'avez pas de disponibilité matchant avec ce cours",false);
        header("Location: ../../../page/gestionReserv.php");
        exit;
    }

    // Insérer une représentation

    $insertRepresentation = $bdd->prepare("INSERT INTO REPRESENTATION (idCours, usernameMoniteur, dateCours, heureDebutCours, activite) VALUES (?, ?, ?, ?, ?)");
    $insertRepresentation->execute(array(
        (int)$_GET["idCours"],
        $_GET["usernameMoniteur"],
        $_GET["dateCours"],
        $_GET["heureDebutCours"],
        "Cours personnel"
    ));

    // Insérer une réservation

    $insertReservation = $bdd->prepare("INSERT INTO RESERVATION (idCours, usernameMoniteur, dateCours, heureDebutCours, usernameClient, idPoney) VALUES(?, ?, ?, ?, ?, ?)");
    $insertReservation->execute(array(
        (int)$_GET["idCours"],
        $_GET["usernameMoniteur"],
        $_GET["dateCours"],
        $_GET["heureDebutCours"],
        $_GET["userClient"],
        $cours["idPoney"]
    ));

    // Supprimer la demande de cours
    $deleteDemande = $bdd->prepare("DELETE FROM DEMANDECOURS WHERE usernameClient = ? AND idCours = ? AND dateCours = ? AND heureDebutCours = ?");
    $deleteDemande->execute(array($cours["usernameClient"], $cours["idCours"], $cours["dateCours"], $cours["heureDebutCours"]));


    // Mails


    $leClient = getPersonne($bdd, $_GET["userClient"]);
    $leMoniteur = getPersonne($bdd, $_GET["usernameMoniteur"]);

    // $object = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h";
    $objectConfirmation = "[SAE PONEY] Votre demande de cours a été accepté";
    $objectConfirmationMoniteur = "[SAE PONEY] Vous avez bien validé une demande de cours";
    $emailClient = getMail($bdd, $_GET["userClient"]);
    $emailMoniteur = getMail($bdd, $_GET["usernameMoniteur"]);
    // $emailClient = "slyjack999@gmail.com";
    // $emailMoniteur = "mathevet.chris@gmail.com";
    $nomMoniteur = strtoupper($leMoniteur["nomPersonne"])." ".$leMoniteur["prenomPersonne"];
    $nomClient = strtoupper($leClient["nomPersonne"])." ".$leClient["prenomPersonne"];

    $dateDemandeCours= $_GET["dateCours"];
    $heureCours= convertFloatToTime((float)$_GET["heureDebutCours"]);
    $dureeCours= $leCours["duree"];
    $activiteDuCours= "Cours personnel : $cours[demande]";

    if(mailClientDemandeCoursConfirme(SENDINGEMAIL, $emailClient, $nomClient, $objectConfirmation, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)
        && mailMoniteurDemandeCoursConfirme(SENDINGEMAIL, $emailMoniteur, $nomMoniteur, $_GET["usernameMoniteur"], $objectConfirmationMoniteur, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
        echo "mail confirme envoyer";
        createPopUp("La demande de cours a bien était accepté, mails de comfirmation envoyées");
    }
    else{
        createPopUp("La demande de cours a bien était accepté, mails de comfirmation non envoyées" , false);
    }
    
}
header("Location: ../../../page/gestionReserv.php");
exit;
?>