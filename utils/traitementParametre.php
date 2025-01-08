<?php
// code pour gerer les parametres d'un clients/moniteur
require_once "connexionBD.php";
require_once "annexe.php";
estConnecte();

echo "<pre>";
print_r($_SESSION);
print_r($_POST);

echo "</pre>";

$role = $_SESSION["connecte"]["role"];
$info = $_SESSION["connecte"]["info"];
$username = $_SESSION["connecte"]["username"];

if(
    !isset($_POST["prenom"]) ||
    !isset($_POST["nom"]) ||
    !isset($_POST["mail"]) || 
    !$bdd
){
    $err = "erreur changement information personnel";
    header("Location: ../page/moniteur.php?errChangementDonnee=" . urlencode($err));
    exit;
}

// $_SESSION["connecte"] = updateMoniteur($bdd, $_SESSION["connecte"]["username"], $_POST["username"] ,$_POST["prenom"] ,$_POST["nom"] ,$_POST["mail"], $_SESSION["connect"]["role"], $_SESSION["connect"]["info"]);


$updateSql = "UPDATE PERSONNE 
    SET prenomPersonne = ?, 
        nomPersonne = ?, 
        mail = ? 
    WHERE username = ?";

$updateStmt = $bdd->prepare($updateSql);

$result = $updateStmt->execute([$_POST["prenom"] ,$_POST["nom"] ,$_POST["mail"], $username ]);

// // Vérifier le résultat
// if ($result) {
//     echo "Mise à jour réussie<br>";
// } else {
//     $errorInfo = $updateStmt->errorInfo();
//     echo "Erreur SQL : " . $errorInfo[2];
// }


$_SESSION["connecte"] = array(
    "username" => $username,  // a voir pour edit ca en plus
    "prenom" => $_POST["prenom"],
    "nom" => $_POST["nom"],
    "mail" => $_POST["mail"],
    "role" => $role,
    "info" => $info
);


// echo "<pre>";
// print_r($_SESSION);

// echo "</pre>";
$_SESSION["succes"] = "Changement effectué avec succes";
if($_POST["clientmoniteur"] === "moniteur"){
    
    header("Location: ../page/moniteur.php#parametre");
    exit;
}

header("Location: ../page/adherent.php#parametre");
exit;

?>