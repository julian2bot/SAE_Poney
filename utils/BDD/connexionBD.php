<?php
// base de base
// code de connexion a une base de donnée
session_start();
require_once __DIR__."/../annexe.php";
// require_once "../../utils/annexe.php";
// session_destroy();
$host ="servinfo-maria";
$user = 'marques';


$passCsv = fopen( __DIR__ . '/../../dataMonted/pass.csv', 'r');
if (!feof($passCsv)) {
    $replace = [";","\n","\r","\r\n"];

    $host = str_replace($replace,"",fgets($passCsv)) ;
    $dbname = str_replace($replace,"",fgets($passCsv)) ;
    $port = str_replace($replace,"",fgets($passCsv)) ;
    $user = str_replace($replace,"",fgets($passCsv)) ;
    $mdp = str_replace($replace,"",fgets($passCsv)) ;
}
var_dump($host);
// $bdd = new PDO('mysql:host='.$host.';dbname='.$table.'', $user, $mdp);
$bdd = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $mdp);


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
