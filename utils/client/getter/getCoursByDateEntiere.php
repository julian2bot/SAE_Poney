<?php
// get les cours a une date donnée (utilisé avec ajax)
require_once __DIR__."/../../BDD/connexionBD.php";

estConnecte();



$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE dateCours = ?");
$reqUser->execute([$_GET["date"]]);
$info = $reqUser->fetchAll();

foreach ($info as $key => $cours) {
    $info[$key]["restant"] = getNbRestantCours($bdd,$cours["idCours"],$cours["usernameMoniteur"],$cours["dateCours"],$cours["heureDebutCours"]);
}

print_r(json_encode($info));