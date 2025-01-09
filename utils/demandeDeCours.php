<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

estConnecte();
// TODO
echo "<pre>";
print_r($_POST);
echo "</pre>";

$email= "marquesjulian26@gmail.com";
$object= "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h";

$username= $_POST["usernameClient"];
$dateDemandeCours= $_POST["dateDemandeCours"];
$heureCours= $_POST["heureCours"];
$dureeCours= $_POST["heure"];
$activiteDuCours= $_POST["activiteDuCours"];

if(mailClientDemandeCours($email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail envoyer";
}
else{
    echo "mail non envoyer";
    
}

?>
