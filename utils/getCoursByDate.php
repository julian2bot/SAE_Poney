<?php
require_once "connexionBD.php";





$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE dateCours = ?");
$reqUser->execute([$_GET["date"]]);
$info = $reqUser->fetchAll();
print_r(json_encode($info));