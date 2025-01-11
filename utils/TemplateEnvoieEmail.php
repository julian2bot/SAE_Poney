<?php



$email = "marquesjulian26@gmail.com";
$object = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h";
$objectConfirmation = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h a bien été confirmée";
$objectConfirmationMoniteur = "[SAE PONEY] Cours du ".$_POST["dateDemandeCours"]." à ".$_POST["heureCours"]."h a bien été confirmée";

$username= $_POST["usernameClient"];
$dateDemandeCours= $_POST["dateDemandeCours"];
$heureCours= $_POST["heureCours"];
$dureeCours= $_POST["heure"];
$activiteDuCours= $_POST["activiteDuCours"];

$moniteurName = "michel"; // pour test dans un premier temps la valeur on la connait plus tard

if(mailClientDemandeCours(SENDINGEMAIL,$email, $username, $object, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail envoyer";
}
else{
    echo "mail non envoyer";
}


if(mailClientDemandeCoursConfirme(SENDINGEMAIL, $email, $username, $objectConfirmation, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail confirme envoyer";
}
else{
    echo "mail confirme non envoyer";
}




if(mailMoniteurDemandeCoursConfirme(SENDINGEMAIL, $email, $moniteurName, $username, $objectConfirmationMoniteur, $dateDemandeCours, $heureCours, $dureeCours, $activiteDuCours)){
    echo "mail confirme envoyer";
}
else{
    echo "mail confirme non envoyer";
}


?>