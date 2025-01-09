<?php
// get les cours a une date donnée (utilisé avec ajax)
require_once "connexionBD.php";
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
estConnecte();

$username = $_GET["username"];
$year = $_GET["year"];
$month = $_GET["month"];

$likePattern = $year . '-' . $month . '%'; // "YYYY-MM%"

$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE usernameMoniteur = ? AND dateCours LIKE ?");
$reqUser->execute([$username, $likePattern]);
$info = $reqUser->fetchAll();

if ($info === false) {
    error_log("Erreur lors de la récupération des données SQL");
    echo json_encode([]);
    exit;
}

header('Content-Type: application/json');

// Vérifiez si $info est un tableau
if (!is_array($info)) {
    error_log("Erreur : \$info n'est pas un tableau. Valeur : " . print_r($info, true));
    echo json_encode([]);
    exit;
}

echo json_encode($info);
