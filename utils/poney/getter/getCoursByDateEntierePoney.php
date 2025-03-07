<?php
// get les cours a une date donnée (utilisé avec ajax)
require_once __DIR__."/../../BDD/connexionBD.php";

estConnecte();



$reqUser = $bdd->prepare("SELECT * FROM RESERVATION NATURAL JOIN COURS WHERE dateCours = ?");
$reqUser->execute([$_GET["date"]]);
$info = $reqUser->fetchAll();
print_r(json_encode($info));