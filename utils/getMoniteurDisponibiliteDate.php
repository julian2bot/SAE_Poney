<?php
require_once "./BDD/connexionBD.php";

$reqUser = $bdd->prepare("SELECT * FROM DISPONIBILITE WHERE dateDispo = ? AND usernameMoniteur = ?");
$reqUser->execute([$_GET["date"], $_GET["username"]]);
$info = $reqUser->fetchAll();
print_r(json_encode($info));