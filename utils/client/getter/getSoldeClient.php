<?php

require_once __DIR__."/../../BDD/connexionBD.php";



$reqUser = $bdd->prepare("SELECT solde FROM CLIENT WHERE usernameCLient = ?");
$reqUser->execute([$_GET['username']]);
$info = $reqUser->fetch();

if($info){
    print_r(json_encode($info));
}else{
    print_r(json_encode(array()));   
}

?>