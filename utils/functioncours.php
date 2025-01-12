<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";

include "../utils/connexionBD.php";

// Gestion des dates pour le calendrier avec une approche différente
$month = isset($_GET['month']) ? intval($_GET['month']) : date('n');
$year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Calculer les mois précédent et suivant en utilisant mktime
$prevMonthTime = mktime(0, 0, 0, $month - 1, 1, $year);
$nextMonthTime = mktime(0, 0, 0, $month + 1, 1, $year);

$prevMonth = date('n', $prevMonthTime);
$prevYear = date('Y', $prevMonthTime);
$nextMonth = date('n', $nextMonthTime);
$nextYear = date('Y', $nextMonthTime);

// Nombre de jours dans le mois courant
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Jour de la semaine du premier jour du mois
$firstDayOfWeek = date('N', strtotime("$year-$month-01")) - 1;

// Nom des jours et des mois
$daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
$months = [
    1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    
];

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validerchoix($bdd);
}



function generercase($firstDayOfWeek,$daysInMonth,$month,$year){

echo '<script src="../assets/script/jsCreationCours.js"></script>';
// Cases vides avant le premier jour du mois
for ($i = 0; $i < $firstDayOfWeek; $i++) {
    echo '<td class="passer"></td>';
}

// Affichage des jours du mois
for ($day = 1; $day <= $daysInMonth; $day++) {
    $classes = '';
    $id =0;

    if ($day < date('j') && $month <= date('n') || $year < date('Y') ) {
        $classes = 'passer';
    }

    else{
        $classes = 'jourpossible';
        $id =$day;
    }

    if ($day == date('j') && $month == date('n') && $year == date('Y')) {
        $classes = 'today';
        $id =$day;
    }

    if ($classes == 'passer')
    {
        echo '<td class="' . $classes .'"id='.$id.'>' . $day . '</td>';
    }

    else
    {
        echo '<td class="' . $classes .'"id='.$id.' onclick="getDate('.$month.','.$year.')" >' . $day . '</td>';
    }
    
    // Retour à la ligne chaque dimanche
    if (($firstDayOfWeek + $day) % 7 == 0) {
        echo '</tr><tr>';
    }
}



// Cases vides après le dernier jour du mois
$remainingDays = (7 - (($firstDayOfWeek + $daysInMonth) % 7)) % 7;
for ($i = 0; $i < $remainingDays; $i++) {
    echo '<td class="passer"></td>';
}
}



function validerchoix($bdd)
{



(int)$idNiveau = $_POST['niveau'];
$nomCours = $_POST['nom'];
(int)$duree = $_POST['choixheure'];
(int)$prix = $_POST['prix'];
(int)$nbMax = $_POST['nbmax'];

$usernameMoniteur = $_SESSION["connecte"]["username"];
$activite = $_POST['description'];
$dateCours = $_POST['datevalider'];
$temp = $_POST['temp'];

// Séparer l'heure et les minutes
list($heures, $minutes) = explode(":", $temp);
// Convertir en une valeur décimale
$temp = $heures + ($minutes / 60);

try {

    // Récupérer les données

    $sql = "SELECT MAX(idCours) AS derniere_id FROM COURS";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();

    // Récupérer la valeur
    $result = $stmt->fetch();
    if ($result && isset($result['derniere_id'])) {
        $idCours = $result['derniere_id'];
        $idCours = (int)$idCours+1;
    } else {
        $idCours = 0;
    }

 
    echo $idCours ,"\n";
    echo $idNiveau ,"\n";
    echo $nomCours,"\n";
    echo $duree,"\n";
    echo $prix,"\n";
    echo $nbMax,"\n";
    echo $usernameMoniteur,"\n";
    echo $activite,"\n";
    echo $dateCours,"\n";
    echo $temp,"\n";

    $insertionCours = $bdd->prepare("INSERT INTO COURS(idCours,idNiveau,nomCours,duree,prix,nbMax) VALUES(?, ?, ?, ?, ?, ?)");
    $insertionCours->execute(array(
        $idCours,
        $idNiveau,
        $nomCours,
        $duree,
        $prix,
        $nbMax
    ));

    $insertionRepresentation = $bdd->prepare("INSERT INTO REPRESENTATION (idCours,usernameMoniteur,dateCours,heureDebutCours,activite) VALUES(?, ?, ?, ?, ?)");
    $insertionRepresentation->execute(array(
        $idCours,
        $usernameMoniteur,
        $dateCours,
        $temp,
        $activite
    ));

    // Redirection vers moniteur
    header("Location: ../page/moniteur.php");
    exit;
}

catch (Exeption $e) {
    echo 'Echec :' .$e->getMessage();
    // Redirection vers creationCours
    header("Location: ../page/creationCours.php");
    exit;
}



}



?>
