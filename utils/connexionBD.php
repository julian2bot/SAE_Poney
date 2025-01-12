<?php
// base de base
// code de connexion a une base de donnée
session_start();
require_once "annexe.php";
// session_destroy();
$host ="localhost";
$user = 'root'; 


$passCsv = fopen( __DIR__ . '/pass.csv', 'r');
if (!feof($passCsv)) {
    $replace = [";","\n","\r","\r\n"];
    $table = str_replace($replace,"",fgets($passCsv)) ;
    $mdp = str_replace($replace,"",fgets($passCsv)) ;
}

$bdd = new PDO('mysql:host='.$host.';dbname='.$table.'', $user, $mdp);


// pour crypter directement toute les mdps de la bd selon le sha1
//CrypterMdp($bdd);




// template requete simple en php:
// // requete select exemple:
// $requser = $bdd-> prepare("SELECT * FROM USER");
// $requser->execute();
// $userinfo = $requser->fetch();


// echo "<pre>";
// print_r($userinfo);

// echo "</pre>";

// // requete insert exemple:
// $insertmbr = $bdd->prepare("INSERT INTO user(pseudo, mdp, type) VALUES(?, ?, ?)");
// $insertmbr->execute(array("troll", "1234", "admin"));


?>
