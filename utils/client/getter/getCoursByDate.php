<?php
// get les cours a une date donnée (utilisé avec ajax)
require_once __DIR__."/../../BDD/connexionBD.php";
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);
estConnecte();

$year = $_GET["year"];
$month = $_GET["month"];

// if($month<10){
//     $likePattern = $year . '-0' . $month . '%'; // "YYYY-MM%"

// }
$likePattern = $year . '-' . $month . '%'; // "YYYY-MM%"

$reqUser = $bdd->prepare("SELECT * FROM REPRESENTATION NATURAL JOIN COURS WHERE dateCours LIKE ?");
$reqUser->execute([$likePattern]);
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
