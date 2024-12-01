<?php
// base de base 
// code de connexion a une base de donnée

session_start();
$host ="localhost";
$table =" ";
$user = ' ';
$mdp = ' ';
$bdd = new PDO('mysql:host='.$host.';dbname='.$table.'', $user, $mdp);


// requete select exemple:
$requser = $bdd-> prepare("SELECT * FROM USER");
$requser->execute();
$userinfo = $requser->fetch();


echo "<pre>";
print_r($userinfo);

echo "</pre>";

// requete insert exemple:
$insertmbr = $bdd->prepare("INSERT INTO user(pseudo, mdp, type) VALUES(?, ?, ?)");
$insertmbr->execute(array("troll", "1234", "admin"));

