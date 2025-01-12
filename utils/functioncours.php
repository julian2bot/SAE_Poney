<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";
?>

<?php
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
    validerchoix();
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


/*
function validerchoix()
{

// Récupérer les données

$idCours = "Select max(idCours) FROM COURS"
$idNiveau = $_POST['niveau'];
$nomCours = $_POST['nom'];
$duree = $_POST['choixheure'];
$prix = $_POST['prix'];
$nbMax = $_POST['nbmax'];


$datevalider = $_POST['datevalider'];
$temp = $_POST['temp'];

$insertionCOURS = "INSERT INTO COURS(idCours,idNiveau,nomCours,duree,prix,nbMax)
VALUES ('.$idCours.','.$idNiveau.','.$nomCours.','.$duree.','.$prix.','.$nbMax.')";

$insertionCOURS = "INSERT INTO COURS(idCours,idNiveau,nomCours,duree,prix,nbMax)
VALUES ('.$idCours.','.$idNiveau.','.$nomCours.','.$duree.','.$prix.','.$nbMax.')";


// Redirection vers une autre page
header("Location: ../page/moniteur.php");
exit;

}
*/
?>