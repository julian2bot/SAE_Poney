<?php
require_once __DIR__."/../../BDD/connexionBD.php";
require_once __DIR__."/../../annexe.php";

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
    if(! isset($cours["idCours"])){
        createPopUp("Problème pour trouver la demande de cours",false);
        header("Location: ../../../page/gestionReserv.php");
        exit;
    }

    echo "uiii";
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

    createPopUp("La demande de cours a bien était accepté");

    // Mails
}
header("Location: ../../../page/gestionReserv.php");
exit;
?>