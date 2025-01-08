<?php
// get les cours a une date donnée pour un moniteur (utilisé avec ajax)

require_once "connexionBD.php";

estConnecte();




$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE dateCours = ? AND usernameMoniteur = ?");
$reqUser->execute([$_GET["date"], $_GET["username"]]);
$info = $reqUser->fetchAll();
print_r(json_encode($info));