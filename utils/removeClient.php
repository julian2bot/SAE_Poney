<?php
require_once "../utils/connexionBD.php";
if(!isset($_SESSION["connecte"]) OR $_SESSION["connecte"]["role"] !== "admin"){
    header("Location: ../");
    exit;
}
if($_SESSION["connecte"]["role"] === "admin"){

    if(isset($_GET["id"]))
    {

        
        // select et suppr toute les factures au nom du client a supprimer
        $reqUser = $bdd->prepare("SELECT * FROM FACTURE_SOLDE WHERE usernameClient = ? ");
        $reqUser->execute([$_GET["id"]]);
        $lesfactures = $reqUser->fetchAll();
        foreach ($lesfactures as $fact) {
            // print_r($fact);
            $sql = "DELETE FROM FACTURE_SOLDE WHERE usernameClient = ? and idFacture = ?";
            $stmt = $bdd->prepare($sql);
            $stmt ->execute([$fact["idCours"], $fact["idFacture"] ]);
        }
        

        // select et suppr toute les factures au nom du client a supprimer
        $reqUser = $bdd->prepare("SELECT * FROM PAYER WHERE usernameClient = ? ");
        $reqUser->execute([$_GET["id"]]);
        $lesPayers = $reqUser->fetchAll();
        foreach ($lesPayers as $payer) {
            // print_r($payer);
            $sql = "DELETE FROM PAYER WHERE nomCotisation = ? and periode = ? and usernameClient = ? ";
            $stmt = $bdd->prepare($sql);
            $stmt ->execute([$payer["nomCotisation"], $payer["periode"], $payer["usernameClient"]]);
        }


        // select et suppr toute les reservations au nom du client a supprimer
        $reqUser = $bdd->prepare("SELECT * FROM RESERVATION WHERE usernameClient = ? ");
        $reqUser->execute([$_GET["id"]]);
        $lesReserv = $reqUser->fetchAll();

        foreach ($lesReserv as $reservation) {
            $sql = "DELETE FROM RESERVATION WHERE idCours = ? and usernameMoniteur = ? and dateCours = ? and heureDebutCours = ? and usernameClient = ? and idPoney = ?";
            $stmt = $bdd->prepare($sql);
            $stmt ->execute([$reservation["idCours"], $reservation["usernameMoniteur"], $reservation["dateCours"], $reservation["heureDebutCours"], $reservation["usernameClient"], $reservation["idPoney"]]);
        }
        
        
        // suppr de client
        $sql = "DELETE FROM CLIENT WHERE usernameClient = ? ";
        $stmt = $bdd->prepare($sql);
        $stmt ->execute([$_GET["id"]]);

        // suppr de personne
        $sql = "DELETE FROM PERSONNE WHERE username = ? ";
        $stmt = $bdd->prepare($sql);
        $stmt ->execute([$_GET["id"]]);
    }
}

if($erreur){
    header("Location: ../page/administration.php?erreurCreerPoney=$erreur");
    exit;
}
else{
    header("Location: ../page/administration.php");
    exit;
}
    
?>