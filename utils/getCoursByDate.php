<?php
// get les cours a une date donnée (utilisé avec ajax)
require_once "connexionBD.php";

estConnecte();



$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE dateCours = ?");
$reqUser->execute([$_GET["date"]]);
$info = $reqUser->fetchAll();
print_r(json_encode($info));