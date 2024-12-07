<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
estAdmin();

// ? est ce que je laisse la double verif??
if($_SESSION["connecte"]["role"] === "admin"){

  
    // suppr toute les factures au nom du client 
    // suppr toute les factures au nom du client 
    // suppr toute les reservations au nom du client 
    // suppr de client
    // suppr de personne
 
    if(isset($_GET["id"]))
        {
        // $sql = "DELETE FROM FACTURE_SOLDE WHERE usernameClient = :id;
        //     DELETE FROM PAYER WHERE usernameClient = :id;
        //     DELETE FROM RESERVATION WHERE usernameClient = :id;
        //     DELETE FROM CLIENT WHERE usernameClient = :id;
        //     DELETE FROM PERSONNE WHERE username = :id;";
        
        $stmt = $bdd->prepare($sql);
        $stmt ->execute([":id" => $_GET["id"]]);
    }
}

if($erreur){
    header("Location: ../page/administration.php");
    exit;
}
else{
    header("Location: ../page/administration.php");
    exit;
}
    
?>