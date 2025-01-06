<?php
require_once "annexe.php";


function creerCalendrierCours($bdd, $client){
    $Days = 1;
    
    $date = new DateTime();
    
    // TODO: changer la date juste commenté cette instruction pour avoit la date de la journée
    $date->setDate("2023","12","1");
 
    $nbJourDansMois = $date->format('t'); // 't' retourne le nombre de jours dans le mois
    $jourDebutMois = $date->format('N'); // Le jour de la semaine du 1er jour du mois (1 = lundi, 7 = dimanche)
    $moisDeLaDate =$date->format('F  Y');

    // header basique avec les jours
    echo '<table border="1">';
    echo "<p> $moisDeLaDate </p>";
    echo '<tr>';
    echo '<th>L</th>';
    echo '<th>M</th>';
    echo '<th>M</th>';
    echo '<th>J</th>';
    echo '<th>V</th>';
    echo '<th>S</th>';
    echo '<th>D</th>';
    echo '</tr>';
    
    $coursesByDay = getAllInfoByMonth($bdd, $client, $date->format('m'), $date->format('Y'));

    for ($i = 0; $i < 6; $i++) { 
        echo '<tr>';
        for ($j = 1; $j <= 7; $j++) {
            
            if ($Days > $nbJourDansMois) {
                break;
            }
            if (($j >= $jourDebutMois && $i === 0) || ($i !== 0 && $Days <= $nbJourDansMois)) {
                if (isset($coursesByDay[$Days])) {
                    echo "<td class='styled-cell hover' id=$Days > $Days ";
                    
                   

                    foreach ($coursesByDay[$Days] as $cours) {
                        echo "<div class='event-box'>
                              </div>";
                    }
                    echo "</td>";
                } else {
                    echo "<td  class='styled-cell' id=$Days >$Days </td>";
                    
                    
                }
                $Days++;
            } else {
                echo "<td></td>";
            }
            
        }
        echo '</tr>';
    }
    
    echo '</table>';

}

?>